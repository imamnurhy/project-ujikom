<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $route = 'role.';
    protected $view = 'master.';
    protected $title = 'Master Role';
    protected $subTitle = 'Role';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;
        $subTitle = $this->subTitle;

        $permissions = Permission::all();

        return view($this->view . 'role', compact('route', 'title', 'subTitle', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required'
        ]);

        $input = $request->all();
        Role::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data role berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        return Role::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'guard_name' => 'required'
        ]);

        $input = $request->all();
        $role = Role::findOrFail($id);
        $role->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data role berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Role::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data role berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $role = Role::all();

        return Datatables::of($role)
            ->addIndexColumn()
            ->addColumn('permissions', function ($p) {
                // return count($p->permissions) . " <a href='" . route('role.permissions', $p->id) . "' class='text-success pull-right' title='Edit Permissions'><i class='icon-clipboard-list2 mr-1'></i></a>";

                return count($p->permissions) . " <a href='javascript:;' onclick='showPopupPermission($p->id)' class='text-success pull-right' title='Edit Permissions'><i class='icon-clipboard-list2 mr-1'></i></a>";
            })
            ->addColumn('action', function ($p) {
                $editBtn = "<a onclick='edit(this)' title='Edit' data-url='" . route($this->route . 'edit', $p->id) . "' data-id='" . $p->id . "'><i class='icon-edit text-blue m-1'></i></a>";
                $deteleBtn = "<a onclick='remove(this)' title='Hapus'  data-url='" . route($this->route . 'destroy', $p->id) . "'><i class='icon-remove text-red m-1'></i></a>";

                return $editBtn . $deteleBtn;
            })
            ->rawColumns(['action', 'permissions'])
            ->toJson();
    }

    //--- Permission
    public function permissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('master._permission.form', compact('role', 'permissions'));
    }

    public function getPermissions($id)
    {
        $role = Role::findOrFail($id);
        return $role->permissions;
    }

    public function storePermissions(Request $request)
    {
        $request->validate([
            'permissions' => 'required'
        ]);

        $role = Role::findOrFail($request->id);
        $role->givePermissionTo($request->permissions);

        return response()->json([
            'success' => true,
            'message' => 'Data permission berhasil tersimpan.'
        ]);
    }

    public function destroyPermission(Request $request, $name)
    {
        $role = Role::findOrFail($request->id);
        $role->revokePermissionTo($name);
    }
}
