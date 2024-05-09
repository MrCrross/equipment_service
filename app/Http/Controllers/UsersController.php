<?php

namespace App\Http\Controllers;

use App\Traits\FilterTrait;
use App\Traits\OrderTrait;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    use OrderTrait;
    use FilterTrait;

    public static array $orderFields = [
        'name',
        'phone',
        'email',
        'login',
    ];

    public static array $filterFields = [
        'name' => [
            'type' => '',
            'action' => 'like'
        ],
        'phone' => [
            'type' => '',
            'action' => 'like'
        ],
        'login' => [
            'type' => '',
            'action' => 'like'
        ],
        'email' => [
            'type' => '',
            'action' => 'like'
        ],
        'deleted_at' => [
            'type' => '',
            'action' => 'null'
        ]
    ];

    public function __construct()
    {
        $this->middleware('permission:users_view|users_view-delete', ['only' => ['index']]);
        $this->middleware('permission:users_edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:users_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $users = User::query();
        $users = self::filterData($request, $users);
        $users = self::orderData($request, $users);
        if (Auth::user()->can('users_view-delete')) {
            $users = $users->withTrashed();
        }
        $users = $users->paginate(6);

        return response()->view('users.index', [
            'data' => $users,
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
        $roles = Role::select('name as value', 'name as label')->get();

        return response()->view('users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255',
            'phone' => 'required|string|max:16|min:16',
            'email' => ['required', 'email', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array'],
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', __('users.messages.store'));
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
        $user = User::withTrashed()->find($id);
        $history = $user->getHistory();

        return response()->view('users.show', [
            'user' => $user,
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
        $user = User::withTrashed()->find($id);
        $roles = Role::select('name as value', 'name as label')->get();
        $userRole = $user->roles->pluck('name');

        return response()->view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRole' => $userRole,
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
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255',
            'phone' => 'required|string|max:16',
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($id)],
            'roles' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $request->validate([
                'password' => ['confirmed', Password::defaults()],
            ]);
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::withTrashed()->find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', __('users.messages.update'));
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
        User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', __('users.messages.delete'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function recovery(int $id): RedirectResponse
    {
        User::withTrashed()->find($id)->restore();

        return redirect()->route('users.show', $id)
            ->with('success', __('users.messages.recovery'));
    }
}
