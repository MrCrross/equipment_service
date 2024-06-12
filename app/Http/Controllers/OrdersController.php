<?php

namespace App\Http\Controllers;

use App\Mail\ApprovalRepair;
use App\Mail\CanceledRepair;
use App\Mail\ClosedRepair;
use App\Mail\CompletedRepair;
use App\Models\Equipment\Equipment;
use App\Models\Orders\EquipmentOrder;
use App\Models\Orders\OrdersStatus;
use App\Models\User;
use App\Traits\FilterTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class OrdersController extends Controller
{
    use FilterTrait;
    use OrderTrait;

    public static array $orderFields = [
        'status_id',
        'equipment_id',
        'master_id',
        'client_id',
        'creator_id',
        'editor_id',
    ];

    public static array $filterFields = [
        'status_id' => [
            'type' => '',
            'action' => '='
        ],
        'equipment_id' => [
            'type' => '',
            'action' => '='
        ],
        'master_id' => [
            'type' => '',
            'action' => '='
        ],
        'client_id' => [
            'type' => '',
            'action' => '='
        ],
        'creator_id' => [
            'type' => '',
            'action' => '='
        ],
        'editor_id' => [
            'type' => '',
            'action' => '='
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:equipment_orders_view|equipment_orders_view-delete', ['only' => ['index']]);
        $this->middleware('permission:equipment_orders_my_create', ['only' => ['store',]]);
        $this->middleware('permission:equipment_orders_create', ['only' => ['create', 'store',]]);
        $this->middleware('permission:equipment_orders_edit|equipment_orders_my_edit', ['only' => ['edit', 'update', 'destroy']]);
    }

    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $orders = EquipmentOrder::query()->with([
            'equipment.model.type',
            'equipment.model.brand',
            'client',
            'creator',
            'editor',
            'master',
            'status'
        ]);
        $orders = self::filterData($request, $orders);
        $orders = self::orderData($request, $orders);
        if (Auth::user()->can('equipment_orders_view-delete')) {
            $orders = $orders->withTrashed();
        }
        $orders = $orders->paginate(6);

        return response()->view('orders.index', [
            'orders' => $orders,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request),
            'order_statuses_select' => OrdersStatus::autocomplete(),
            'users_select' => User::autocomplete(),
        ]);
    }

    public function show(int $id): RedirectResponse|Response
    {
        $order = EquipmentOrder::query()->with([
            'equipment.model.type',
            'equipment.model.brand',
            'client',
            'creator',
            'editor',
            'master',
            'status'
        ])->withTrashed()->find($id);
        if (
            !Auth::user()->can('equipment_orders_view-delete') &&
            $order->master_id !== Auth::id() &&
            $order->client_id !== Auth::id() &&
            $order->creator_id !== Auth::id() &&
            $order->editor_id !== Auth::id()
        ) {
            return redirect()->route('dashboard');
        }
        $history = $order->getHistory();

        return response()->view('orders.show', [
            'order' => $order,
            'history' => $history,
        ]);
    }

    public function create(): Response
    {
        return response()->view('orders.create', [
            'order_statuses_select' => OrdersStatus::autocomplete(),
            'users_select' => User::autocomplete(),
            'equipment_select' => Equipment::autocomplete(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'description' => ['required','string'],
            'price' => ['numeric'],
            'equipment_id' => ['required', 'integer', Rule::exists(Equipment::class, 'id')],
        ]);
        $fields = [
            'equipment_id' => $request->post('equipment_id'),
            'description' => $request->post('description'),
            'price' => $request->post('price', 0),
            'creator_id' => Auth::id(),
        ];
        $route = 'orders.index';
        if ($request->has('client_name')) {
            $request->validate([
                'client_name' => ['required','string'],
                'phone' => ['required','string'],
            ]);
            $fields['client_name'] = $request->post('client_name');
            $fields['phone'] = $request->post('phone');
            $fields['master_id'] = Auth::id();
            $fields['status_code'] = 'diagnostic';
        } else {
            $fields['client_id'] = Auth::id();
            $fields['status_code'] = 'draft';
            $route = 'dashboard';
        }
        EquipmentOrder::create($fields);

        return redirect()->route($route)
            ->with('success', __('orders.messages.store'));
    }

    /**
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function edit(int $id): RedirectResponse|Response
    {
        $order = EquipmentOrder::query()->with([
            'equipment.model.type',
            'equipment.model.brand',
            'client',
            'creator',
            'editor',
            'master',
            'status'
        ])->withTrashed()->find($id);

        if (Auth::user()->can('equipment_orders_my_edit') && $order->creator_id !== Auth::id()) {
            return redirect()->route('dashboard');
        }

        return response()->view('orders.edit', [
            'order' => $order,
            'order_statuses_select' => OrdersStatus::autocomplete(),
            'users_select' => User::autocomplete(),
            'equipment_select' => Equipment::autocomplete(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'description' => ['required','string'],
            'price' => ['required', 'numeric'],
            'equipment_id' => ['required', 'integer', Rule::exists(Equipment::class, 'id')],
            'status_code' => ['required', 'string', Rule::exists(OrdersStatus::class, 'code')],
        ]);
        $fields = [
            'equipment_id' => $request->post('equipment_id'),
            'description' => $request->post('description'),
            'price' => $request->post('price'),
            'editor_id' => Auth::id(),
            'status_code' => $request->post('status_code'),
        ];
        if ($request->has('client_name')) {
            $request->validate([
                'client_name' => ['required','string'],
                'phone' => ['required','string'],
            ]);
            $fields['client_name'] = $request->post('client_name');
            $fields['phone'] = $request->post('phone');
            $fields['master_id'] = Auth::id();
        } elseif ($request->has('client_id')) {
            $fields['client_id'] = $request->post('client_id');
        }
        $oldOrder = EquipmentOrder::query()->with(['client'])->find($id);
        EquipmentOrder::updateOrCreate(['id' => $id], $fields);

        $order = EquipmentOrder::query()->with(['client', 'equipment.model.type', 'equipment.model.brand',])->find($id);
        if ($oldOrder->status_code !== $order->status_code && !empty($order->client)) {
            $mailTemplate = match ($order->status_code) {
                'approval' => new ApprovalRepair($order),
                'canceled' => new CanceledRepair($order),
                'closed' => new ClosedRepair($order),
                'completed' => new CompletedRepair($order),
                default => null,
            };
            if (!empty($mailTemplate)) {
                Mail::to($order->client->email)->send($mailTemplate);
            }
        }


        return redirect()->route('orders.index')
            ->with('success', __('orders.messages.update'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $order = EquipmentOrder::withTrashed()->find($id);
        $order->update([
            'status_code' => 'deleted',
        ]);
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', __('orders.messages.delete'));
    }

    public function recovery(int $id): RedirectResponse
    {
        $order = EquipmentOrder::withTrashed()->find($id);
        $order->restore();
        $order->update([
            'status_code' => 'draft',
        ]);

        return redirect()->route('orders.show', $id)
            ->with('success', __('orders.messages.recovery'));
    }

    public function getByUser(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $orders = EquipmentOrder::query()->with([
            'equipment.model.type',
            'equipment.model.brand',
            'client',
            'creator',
            'editor',
            'master',
            'status'
        ])
            ->where('master_id', '=', Auth::id())
            ->orWhere('client_id', '=', Auth::id())
            ->orWhere('creator_id', '=', Auth::id())
            ->orWhere('editor_id', '=', Auth::id())
        ;
        $orders = self::filterData($request, $orders);
        $orders = self::orderData($request, $orders);
        if (Auth::user()->can('equipment_orders_view-delete')) {
            $orders = $orders->withTrashed();
        }
        $orders = $orders->paginate(6);

        return response()->view('dashboard', [
            'orders' => $orders,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request),
            'order_statuses_select' => OrdersStatus::autocomplete(),
            'users_select' => User::autocomplete(),
            'equipment_select' => Equipment::autocomplete(),
        ]);
    }

    public function changeStatus(
        int $orderID,
        string $statusCode
    ): RedirectResponse {
        $order = EquipmentOrder::query()->find($orderID);
        if (!empty($order)) {
            $checkOldStatus = match ($statusCode) {
                'signed', 'canceled' => 'approval',
            };
            if ($checkOldStatus === $order->status_code) {
                $order->update(['status_code' => $statusCode]);
            }
            $mailTemplate = match ($statusCode) {
                'approval' => new ApprovalRepair($order),
                'canceled' => new CanceledRepair($order),
                'closed' => new ClosedRepair($order),
                'completed' => new CompletedRepair($order),
                default => null,
            };
            if (!empty($mailTemplate) && !empty($order->client)) {
                Mail::to($order->client->email)->send($mailTemplate);
            }
        }

        return redirect()->route('welcome');
    }
}
