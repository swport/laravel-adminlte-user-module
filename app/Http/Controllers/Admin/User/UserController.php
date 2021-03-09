<?php

namespace App\Http\Controllers\Admin\User;

use App\Consts\UserTypes;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function resourceAbilityMap()
    {
        return [
            'index'  => 'browse_users',
            'show'   => 'browse_users',
            'create' => 'add_user',
            'store'  => 'add_user',
            'edit'   => 'edit_user',
            'update' => 'edit_user',
            'destroy'=> 'remove_user'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()
            ->where('id', '<>', auth()->user()->id)
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // @string = true
        $allowedPermissions = $this->getAllowedPermissions(true);

        $validated = $request->validate([
            'type'        => ['required', 'in:' . UserTypes::SUB_ADMIN],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['in:' . $allowedPermissions],
            'first_name'  => ['required', 'string', 'max:191'],
            'last_name'   => ['required', 'string', 'max:191'],
            'email'       => ['required', 'email', 'unique:users,email'],
            'phone'       => ['nullable', 'digits_between:8,14'],
            'password'    => ['required', 'confirmed']
        ]);

        DB::beginTransaction();

        try {
            if( $request->has('email_verified_at') ) {
                $validated['email_verified_at'] = date('Y-m-d H:i:s');
            }

            if( $request->has('phone_verified_at') ) {
                $validated['phone_verified_at'] = date('Y-m-d H:i:s');
            }

            $validated['password'] = Hash::make($request->password);

            $user = User::create(
                $validated
            );

            // create permission if not already created
            $permissions = 
                collect($validated['permissions'])
                    ->map(function($permission) {
                        return Permission::findOrCreate($permission);
                    });

            $user->givePermissionTo(
                $permissions
            );

            DB::commit();

            return redirect()->route('admin.users.index')
                ->withSuccess(__('User Added Successfully'));
        } catch (\Exception $e) {
            logger( $e->getMessage() );
        }

        DB::rollBack();

        return back()->withError(__('Something Went Wrong!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // @string = true
        $allowedPermissions = $this->getAllowedPermissions(true);

        $validated = $request->validate([
            'type'        => ['required', 'in:2'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['in:' . $allowedPermissions],
            'first_name'  => ['required', 'string', 'max:191'],
            'last_name'   => ['required', 'string', 'max:191']
        ]);

        DB::beginTransaction();

        try {
            $user->update( $validated );

            $permissions = 
                collect($request->permissions)
                    ->map(function($permission) {
                        return Permission::findOrCreate($permission);
                    });
                    
            $user->syncPermissions(
                $permissions
            );

            DB::commit();

            return redirect()->route('admin.users.index')
                ->withSuccess(__('User Saved'));
        } catch (\Exception $e) {
            logger( $e->getMessage() );
        }

        DB::rollBack();

        return back()->withError(__('Something Went Wrong!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch(\Exception $e) {
            logger( $e->getMessage() );
        }

        return back()->withSuccess(__('User Removed'));
    }
}
