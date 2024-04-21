<?php

namespace App\Http\Controllers;

use App\Traits\FilterTrait;
use App\Traits\OrderTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
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
        $this->middleware('permission:roles_view', ['only' => ['index']]);
        $this->middleware('permission:roles_edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:roles_delete', ['only' => ['destroy']]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $roles = Role::query();
        $roles = self::filterData($request, $roles);
        $roles = self::orderData($request, $roles);
        $roles = $roles->paginate(6);

        return response()->view('roles.index', [
            'roles' => $roles,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $permission = Permission::pluck('name', 'name');

        return response()->view('roles.create', [
            'permission' => $permission,
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->post('name')]);
        $role->syncPermissions($request->post('permission'));

        return redirect()->route('roles.index')
            ->with('success', __('roles.messages.store'));
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
        $role = Role::find($id);

        return response()->view('roles.show', [
            'role' => $role
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
        $role = Role::find($id);
        $permission = Permission::pluck('name', 'name');
        $rolePermissions = $role->permissions->pluck('name', 'name')->toArray();

        return response()->view('roles.edit', [
            'role' => $role,
            'permission' => $permission,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->post('name');
        $role->save();
        $role->syncPermissions($request->post('permission'));

        return redirect()->route('roles.index')
            ->with('success', __('roles.messages.update'));
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
        Role::find($id)->delete();

        return redirect()->route('roles.index')
            ->with('success', __('roles.messages.delete'));
    }
}
