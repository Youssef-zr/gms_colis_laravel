<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\roles\CrudRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:liste_rôles', ['only' => 'index']);
        $this->middleware('permission:nouveau_rôle', ['only' => ['create', 'store']]);
        $this->middleware('permission:editer_rôle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:afficher_rôle', ['only' => 'show']);
        $this->middleware('permission:supprimer_rôle', ['only' => 'destroy']);
        $this->middleware('permission:nouvelle_autorisation', ['only' => 'newPermission', 'createPermission']);
    }

    /*** Display a listing of the resource.
     ** @return \Illuminate\Http\Response*/
    public function index()
    {
        $title = "rôles";
        if (auth()->user()->roles[0]->name == "developpeur") {
            $roles = Role::get();
        } else {
            $roles = Role::where('name', '!=', 'developpeur')->get();
        }

        return view('backend.views.roles.index', compact('roles', 'title'));
    }

    /*** Show the form for creating a new resource.
     * ** @return \Illuminate\Http\Response*/
    public function create()
    {
        $permission = Permission::get();

        return view('backend.views.roles.create', compact('permission'));
    }

    /*** Store a newly created resource in storage.
     * ** @param  \Illuminate\Http\Request  $request* @return \Illuminate\Http\Response*/
    public function store(CrudRoleRequest $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect_with_flash("msgSuccess", "rôle ajouté avec succès", "roles");
    }

    /*** Display the specified resource.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function show($id)
    {
        // cant show dev role from others
        $roleDev = Auth::user()->roles[0]->name;
        if ($id == 1 and $roleDev != "developpeur") {
            return view('_partial.404');
        }

        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('backend.views.roles.show', compact('role', 'rolePermissions'));
    }

    /*** Show the form for editing the specified resource.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function edit($id)
    {
        // cant edit dev role from others
        $roleDev = Auth::user()->roles[0]->name;
        if ($id == 1 and $roleDev != "developpeur") {
            return view('_partial.404');
        }

        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('backend.views.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /*** Update the specified resource in storage.
     * ** @param  \Illuminate\Http\Request  $request* @param  int  $id* @return \Illuminate\Http\Response*/
    public function update(CrudRoleRequest $request, $id)
    {
        $role = Role::find($id);
        // $role->name = $request->input('name');
        // $role->save();
        $role->syncPermissions($request->input('permission'));

        return redirect_with_flash("msgSuccess", "Rôle Mise à jour avec succès", "roles");
    }

    /*** Remove the specified resource from storage.
     * ** @param  int  $id* @return \Illuminate\Http\Response*/
    public function destroy($id)
    {
        if ($id == 1) {

            return redirect_with_flash("msgDanger", "Impossible de supprimer ce rôle", "roles");
        }

        DB::table("roles")->where('id', $id)->delete();

        return redirect_with_flash("msgSuccess", "rôle supprimé avec succès", "roles");
    }

    // new permission form
    public function newPermission()
    {
        return view('backend.views.roles.new_permission');
    }

    // store new permission
    public function createPermission(Request $request)
    {
        $rule = ['name' => 'required|unique:permissions|max:50'];
        $niceNames = ['name' => "nom"];

        $this->validate($request, $rule, [], $niceNames);

        $new = new Permission();
        $new->fill(['name' => $request->name])->save();

        return redirect_with_flash("msgSuccess", "Autorisation ajoutée avec succès", "roles");
    }

    // block edit developpeur account without no autorisation
    public function checkUserIsDevloppeur($idRole)
    {
        $roleDev = Auth::user()->roles[0]->name;
        if ($idRole == 1 and $roleDev != "developpeur") {
            return view('_partial.404');
        }
    }
}
