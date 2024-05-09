<?php

namespace App\Http\Controllers\Equipment;

use App\Http\Controllers\Controller;
use App\Models\Equipment\EquipmentField;
use App\Models\Equipment\EquipmentFieldsType;
use App\Traits\FilterTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EquipmentFieldsController extends Controller
{
    use FilterTrait;
    use OrderTrait;

    public static array $orderFields = [
        'name',
        'type_id',
    ];

    public static array $filterFields = [
        'name' => [
            'type' => '',
            'action' => 'like'
        ],
        'type_id' => [
            'type' => '',
            'action' => '='
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:equipment_fields_view|equipment_fields_view-delete', ['only' => ['index']]);
        $this->middleware('permission:equipment_fields_edit', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $fields = EquipmentField::query()->with('type');
        $fields = self::filterData($request, $fields);
        $fields = self::orderData($request, $fields);
        if (Auth::user()->can('equipment_fields_view-delete')) {
            $fields = $fields->withTrashed();
        }
        $fields = $fields->paginate(6);

        return response()->view('equipment.fields.index', [
            'fields' => $fields,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request),
            'types_select' => EquipmentFieldsType::autocomplete(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('equipment.fields.create', [
            'types_select' => EquipmentFieldsType::autocomplete(),
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
            'name' => ['required', 'string', Rule::unique(EquipmentField::class, 'name')],
            'type_code' => ['required', 'string', Rule::exists(EquipmentFieldsType::class, 'code')],
        ]);
        $fields = [
            'name' => $request->post('name'),
            'type_code' => $request->post('type_code'),
        ];
        EquipmentField::create($fields);

        return redirect()->route('equipment.fields.index')
            ->with('success', __('equipment.messages.fields.store'));
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
        $field = EquipmentField::query()->with(['type'])->withTrashed()->find($id);
        $history = $field->getHistory();

        return response()->view('equipment.fields.show', [
            'field' => $field,
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
        $field = EquipmentField::withTrashed()->with(['type'])->find($id);

        return response()->view('equipment.fields.edit', [
            'field' => $field,
            'types_select' => EquipmentFieldsType::autocomplete(),
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
            'name' => ['required', 'string', Rule::unique(EquipmentField::class, 'name')->ignore($id)],
            'type_code' => ['required', 'string', Rule::exists(EquipmentFieldsType::class, 'code')],
        ]);

        $fields = [
            'name' => $request->post('name'),
            'type_code' => $request->post('type_code'),
        ];
        EquipmentField::withTrashed()->find($id)->update($fields);

        return redirect()->route('equipment.fields.index')
            ->with('success', __('equipment.messages.fields.update'));
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
        EquipmentField::find($id)->delete();

        return redirect()->route('equipment.fields.index')
            ->with('success', __('equipment.messages.fields.delete'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function recovery(int $id): RedirectResponse
    {
        $field = EquipmentField::withTrashed()->find($id);
        $field->restore();

        return redirect()->route('equipment.fields.show', $id)
            ->with('success', __('equipment.messages.fields.recovery'));
    }
}
