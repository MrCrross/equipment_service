<?php

namespace App\Http\Controllers;

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

    public function show(int $id): Response
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
            'equipment_id' => ['required', 'integer', Rule::exists(Equipment::class, 'id')],
        ]);
        $fields = [
            'equipment_id' => $request->post('equipment_id'),
            'description' => $request->post('description'),
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
            $fields['status_code'] = 'accepted';
        } else {
            $fields['client_id'] = Auth::id();
            $fields['status_code'] = 'accepted';
            $route = 'dashboard';
        }
        EquipmentOrder::create($fields);

        return redirect()->route($route)
            ->with('success', __('orders.messages.store'));
    }

    public function edit(int $id): Response
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
            'equipment_id' => ['required', 'integer', Rule::exists(Equipment::class, 'id')],
            'status_code' => ['required', 'string', Rule::exists(OrdersStatus::class, 'code')],
        ]);
        $fields = [
            'equipment_id' => $request->post('equipment_id'),
            'description' => $request->post('description'),
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
        EquipmentOrder::updateOrCreate(['id' => $id], $fields);

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
}
