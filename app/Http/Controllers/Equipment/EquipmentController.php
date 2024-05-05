<?php

namespace App\Http\Controllers\Equipment;

use App\Http\Controllers\Controller;
use App\Models\Equipment\Equipment;
use App\Models\Equipment\EquipmentField;
use App\Models\Equipment\EquipmentFieldsValues;
use App\Models\Equipment\EquipmentModel;
use App\Models\User;
use App\Traits\FilterTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class EquipmentController extends Controller
{
    use FilterTrait;
    use OrderTrait;

    public static array $orderFields = [
        'name',
        'model_id',
        'serial',
        'short_name',
    ];

    public static array $filterFields = [
        'name' => [
            'type' => '',
            'action' => 'like'
        ],
        'serial' => [
            'type' => '',
            'action' => 'like'
        ],
        'short_name' => [
            'type' => '',
            'action' => 'like'
        ],
        'model_id' => [
            'type' => '',
            'action' => '='
        ],
        'creator_id' => [
            'type' => '',
            'action' => '='
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:equipment_view|equipment_view-delete', ['only' => ['index']]);
        $this->middleware('permission:equipment_edit', ['only' => ['create', 'store', 'edit', 'update', 'destroy', 'recovery']]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $equipment = Equipment::query()->with(['model.brand', 'model.type', 'fields.field', 'creator', 'editor']);
        $equipment = self::filterData($request, $equipment);
        $equipment = self::orderData($request, $equipment);
        if (Auth::user()->can('equipment_view-delete')) {
            $equipment = $equipment->withTrashed();
        }
        $equipment = $equipment->paginate(6);

        return response()->view('equipment.main.index', [
            'equipment' => $equipment,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request),
            'users_select' => User::autocomplete(),
            'models_select' => EquipmentModel::autocomplete(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('equipment.main.create', [
            'models_select' => EquipmentModel::autocomplete(),
            'fields_select' => EquipmentField::autocomplete(),
        ]);
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
            'model_id' => ['required', 'int', Rule::exists(EquipmentModel::class, 'id')],
            'serial' => ['required', 'string'],
            'short_name' => ['required', 'string'],
            'fields' => ['array', 'nullable'],
        ]);
        $fields = [
            'model_id' => $request->post('model_id'),
            'serial' => $request->post('serial'),
            'short_name' => $request->post('short_name'),
            'creator_id' => Auth::id(),
        ];
        $equipmentID = Equipment::query()->create($fields)->id;
        if ($request->filled('fields')) {
            foreach ($request->post('fields') as $field) {
                if (!empty($field['id']) && isset($field['value'])) {
                    EquipmentFieldsValues::query()->create([
                        'equipment_id' => $equipmentID,
                        'field_id' => $field['id'],
                        'value' => $field['value'],
                    ]);
                }
            }
        }

        return redirect()->route('equipment.main.index')
            ->with('success', __('equipment.messages.main.store'));
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
        $equipment = Equipment::query()->with(['model.brand', 'model.type', 'fields.field', 'creator', 'editor'])->withTrashed()->find($id);

        return response()->view('equipment.main.show', [
            'equipment' => $equipment,
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
        $equipment = Equipment::query()->with(['model.brand', 'model.type', 'fields.field', 'creator', 'editor'])->withTrashed()->find($id);

        return response()->view('equipment.main.edit', [
            'equipment' => $equipment,
            'models_select' => EquipmentModel::autocomplete(),
            'fields_select' => EquipmentField::autocomplete(),
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
            'model_id' => ['required', 'int', Rule::exists(EquipmentModel::class, 'id')],
            'serial' => ['required', 'string'],
            'short_name' => ['required', 'string'],
            'fields' => ['array', 'nullable'],
        ]);

        $fields = [
            'model_id' => $request->post('model_id'),
            'serial' => $request->post('serial'),
            'short_name' => $request->post('short_name'),
            'editor_id' => Auth::id(),
        ];
        $equipmentID = Equipment::withTrashed()->updateOrCreate(['id' => $id], $fields)->id;
        EquipmentFieldsValues::query()->where('equipment_id', $id)->delete();
        if ($request->filled('fields')) {
            foreach ($request->post('fields') as $field) {
                if (!empty($field['id']) && isset($field['value'])) {
                    EquipmentFieldsValues::query()->create([
                        'equipment_id' => $equipmentID,
                        'field_id' => $field['id'],
                        'value' => $field['value'],
                    ]);
                }
            }
        }

        return redirect()->route('equipment.main.index')
            ->with('success', __('equipment.messages.main.update'));
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
        Equipment::find($id)->delete();

        return redirect()->route('equipment.main.index')
            ->with('success', __('equipment.messages.main.delete'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function recovery(int $id): RedirectResponse
    {
        Equipment::withTrashed()->where('id', '=', $id)->update([
            'deleted_at' => null,
        ]);

        return redirect()->route('equipment.main.show', $id)
            ->with('success', __('equipment.messages.main.recovery'));
    }
}
