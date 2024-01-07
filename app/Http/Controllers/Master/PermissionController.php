<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $route = 'permission.';
    protected $view = 'master.';
    protected $title = 'Master Permission';
    protected $subTitle = 'Permission';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;
        $subTitle = $this->subTitle;

        return view($this->view . 'permission', compact('route', 'title', 'subTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'guard_name' => 'required'
        ]);

        $input = $request->all();
        Permission::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Data permission berhasil tersimpan.'
        ]);
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return $permission;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'guard_name' => 'required'
        ]);

        $input = $request->all();
        $permission = Permission::findOrFail($id);
        $permission->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Data permission berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        Permission::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data permission berhasil dihapus.'
        ]);
    }

    public function api()
    {
        $permission = Permission::all();
        return Datatables::of($permission)
            ->addIndexColumn()
            ->addColumn('action', function ($p) {
                $editBtn = "<a onclick='edit(this)' title='Edit' data-url='" . route($this->route . 'edit', $p->id) . "'><i class='icon-edit text-blue m-1'></i></a>";

                $deteleBtn = "<a onclick='remove(this)' title='Hapus'  data-url='" . route($this->route . 'destroy', $p->id) . "'><i class='icon-remove text-red m-1'></i></a>";

                return $editBtn . $deteleBtn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
