<?php

namespace App\Http\Controllers\Equipment;

use App\Http\Controllers\Controller;
use App\Models\Equipment\EquipmentBrand;
use App\Models\User;
use App\Traits\FilterTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class EquipmentBrandsController extends Controller
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
        'creator_id' => [
            'type' => '',
            'action' => '='
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:equipment_brands_view|equipment_brands_view-delete', ['only' => ['index']]);
        $this->middleware('permission:equipment_brands_edit', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $brands = EquipmentBrand::query()->with('creator');
        $brands = self::filterData($request, $brands);
        $brands = self::orderData($request, $brands);
        if (Auth::user()->can('equipment_brands_view-delete')) {
            $brands = $brands->withTrashed();
        }
        $brands = $brands->paginate(6);

        return response()->view('equipment.brands.index', [
            'brands' => $brands,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request),
            'users_select' => User::autocomplete(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response()->view('equipment.brands.create');
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
            'name' => ['required', 'string', Rule::unique(EquipmentBrand::class, 'name')],
        ]);
        $fields = [
            'name' => $request->post('name'),
            'creator_id' => Auth::id(),
        ];
        EquipmentBrand::create($fields);

        return redirect()->route('equipment.brands.index')
            ->with('success', __('equipment.messages.brands.store'));
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
        $brand = EquipmentBrand::query()->with('creator')->withTrashed()->find($id);

        return response()->view('equipment.brands.show', [
            'brand' => $brand,
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
        $brand = EquipmentBrand::withTrashed()->find($id);

        return response()->view('equipment.brands.edit', [
            'brand' => $brand,
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
            'name' => ['required', 'string', Rule::unique(EquipmentBrand::class, 'name')->ignore($id)],
        ]);

        $fields = [
            'name' => $request->post('name'),
        ];
        EquipmentBrand::withTrashed()->find($id)->update($fields);

        return redirect()->route('equipment.brands.index')
            ->with('success', __('equipment.messages.brands.update'));
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
        EquipmentBrand::find($id)->delete();

        return redirect()->route('equipment.brands.index')
            ->with('success', __('equipment.messages.brands.delete'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function recovery(int $id): RedirectResponse
    {
        EquipmentBrand::withTrashed()->where('id', '=', $id)->update([
            'deleted_at' => null,
        ]);

        return redirect()->route('equipment.brands.show', $id)
            ->with('success', __('equipment.messages.brands.recovery'));
    }
}
