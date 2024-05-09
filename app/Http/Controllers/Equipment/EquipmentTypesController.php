<?php

namespace App\Http\Controllers\Equipment;

use App\Http\Controllers\Controller;
use App\Models\Equipment\EquipmentType;
use App\Traits\FilterTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EquipmentTypesController extends Controller
{
    use FilterTrait;
    use OrderTrait;

    public static array $orderFields = [
        'name',
    ];

    public static array $filterFields = [
        'name' => [
            'type' => '',
            'action' => 'like'
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:equipment_types_view|equipment_types_view-delete', ['only' => ['index']]);
        $this->middleware('permission:equipment_types_edit', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $types = EquipmentType::query();
        $types = self::filterData($request, $types);
        $types = self::orderData($request, $types);
        if (Auth::user()->can('equipment_types_view-delete')) {
            $types = $types->withTrashed();
        }
        $types = $types->paginate(6);

        return response()->view('equipment.types.index', [
            'types' => $types,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('equipment.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique(EquipmentType::class, 'name')],
        ]);
        $fields = [
            'name' => $request->post('name'),
        ];
        EquipmentType::create($fields);

        return redirect()->route('equipment.types.index')
            ->with('success', __('equipment.messages.types.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        $type = EquipmentType::query()->withTrashed()->find($id);
        $history = $type->getHistory();

        return response()->view('equipment.types.show', [
            'type' => $type,
            'history' => $history,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(int $id): Response
    {
        $type = EquipmentType::withTrashed()->find($id);

        return response()->view('equipment.types.edit', [
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique(EquipmentType::class, 'name')->ignore($id)],
        ]);

        $fields = [
            'name' => $request->post('name'),
        ];
        EquipmentType::withTrashed()->find($id)->update($fields);

        return redirect()->route('equipment.types.index')
            ->with('success', __('equipment.messages.types.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        EquipmentType::find($id)->delete();

        return redirect()->route('equipment.types.index')
            ->with('success', __('equipment.messages.types.delete'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function recovery(int $id): RedirectResponse
    {
        $type = EquipmentType::withTrashed()->find($id);
        $type->restore();

        return redirect()->route('equipment.types.show', $id)
            ->with('success', __('equipment.messages.types.recovery'));
    }
}
