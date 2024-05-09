<?php

namespace App\Http\Controllers\Equipment;

use App\Http\Controllers\Controller;
use App\Models\Equipment\EquipmentBrand;
use App\Models\Equipment\EquipmentModel;
use App\Models\Equipment\EquipmentType;
use App\Models\User;
use App\Traits\FilterTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EquipmentModelsController extends Controller
{
    use FilterTrait;
    use OrderTrait;

    public static array $orderFields = [
        'name',
        'type_id',
        'brand_id',
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
        'brand_id' => [
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
        $this->middleware('permission:equipment_models_view|equipment_models_view-delete', ['only' => ['index']]);
        $this->middleware('permission:equipment_models_edit', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $models = EquipmentModel::query()->with(['creator', 'brand', 'type']);
        $models = self::filterData($request, $models);
        $models = self::orderData($request, $models);
        if (Auth::user()->can('equipment_models_view-delete')) {
            $models = $models->withTrashed();
        }
        $models = $models->paginate(6);

        return response()->view('equipment.models.index', [
            'models' => $models,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request),
            'users_select' => User::autocomplete(),
            'types_select' => EquipmentType::autocomplete(),
            'brands_select' => EquipmentBrand::autocomplete(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('equipment.models.create', [
            'types_select' => EquipmentType::autocomplete(),
            'brands_select' => EquipmentBrand::autocomplete(),
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
            'name' => ['required', 'string', Rule::unique(EquipmentModel::class, 'name')],
            'brand_id' => ['required', 'integer', Rule::exists(EquipmentBrand::class, 'id')],
            'type_id' => ['required', 'integer', Rule::exists(EquipmentType::class, 'id')],
        ]);
        $fields = [
            'name' => $request->post('name'),
            'brand_id' => $request->post('brand_id'),
            'type_id' => $request->post('type_id'),
            'creator_id' => Auth::id(),
        ];
        EquipmentModel::create($fields);

        return redirect()->route('equipment.models.index')
            ->with('success', __('equipment.messages.models.store'));
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
        $model = EquipmentModel::query()->with(['creator', 'brand', 'type'])->withTrashed()->find($id);
        $history = $model->getHistory();

        return response()->view('equipment.models.show', [
            'model' => $model,
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
        $model = EquipmentModel::withTrashed()->with(['brand', 'type'])->find($id);

        return response()->view('equipment.models.edit', [
            'model' => $model,
            'types_select' => EquipmentType::autocomplete(),
            'brands_select' => EquipmentBrand::autocomplete(),
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
            'name' => ['required', 'string', Rule::unique(EquipmentModel::class, 'name')->ignore($id)],
            'brand_id' => ['required', 'integer', Rule::exists(EquipmentBrand::class, 'id')],
            'type_id' => ['required', 'integer', Rule::exists(EquipmentType::class, 'id')],
        ]);

        $fields = [
            'name' => $request->post('name'),
            'brand_id' => $request->post('brand_id'),
            'type_id' => $request->post('type_id'),
        ];
        EquipmentModel::withTrashed()->find($id)->update($fields);

        return redirect()->route('equipment.models.index')
            ->with('success', __('equipment.messages.models.update'));
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
        EquipmentModel::find($id)->delete();

        return redirect()->route('equipment.models.index')
            ->with('success', __('equipment.messages.models.delete'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function recovery(int $id): RedirectResponse
    {
        $model = EquipmentModel::withTrashed()->find($id);
        $model->restore();

        return redirect()->route('equipment.models.show', $id)
            ->with('success', __('equipment.messages.models.recovery'));
    }
}
