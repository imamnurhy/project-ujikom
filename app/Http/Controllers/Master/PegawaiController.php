<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Datatables;

use App\Models\Pegawai;
use App\Models\User;

class PegawaiController extends Controller
{
    protected $route = 'pegawai.';
    protected $view = 'master.';
    protected $title = 'Master Pegawai';
    protected $subTitle = 'Pegawai';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;
        $subTitle = $this->subTitle;

        return view($this->view . 'pegawai', compact('route', 'title', 'subTitle'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'n_pegawai' => 'required',
            'telp'      => 'required|string|min:10|max:14|unique:pegawais,telp',
            'email'     => 'required|email',
        ]);

        Pegawai::create([
            'n_pegawai' => $request->n_pegawai,
            'telp'      => $request->telp,
            'email'     => $request->email,
        ]);

        return response('Data pegawai berhasil tersimpan.');
    }

    public function edit($id)
    {
        return Pegawai::find($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'n_pegawai' => 'required',
            'telp'      => 'required|string|min:10|max:14|unique:pegawais,telp,' . $id,
            'email'     => 'required|email',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update([
            'n_pegawai' => $request->n_pegawai,
            'telp'      => $request->telp,
            'email'     => $request->email,
        ]);

        return response('Data pegawai berhasil diperbaharui.');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        User::destroy($pegawai->user_id);
        Pegawai::destroy($id);

        return response('Data pegawai berhasil dihapus.');
    }

    public function api()
    {
        $data = Pegawai::get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('user_id', function ($p) {
                if ($p->user_id == "") {
                    return "Tidak <a href='javascript:;' onclick='addUser($p->id)' class='float-right text-success' title='Tambah sebagai pengguna aplikasi'><i class='icon-user-plus'></i></a>";
                } else {
                    // return "Ya <a href='" . route('user.edit', $p->user_id) . "' class='float-right' title='Edit akun user'><i class='icon-user'></i></a>";

                    return "Ya <a href='javascript:;' data-url='" . route('user.edit', $p->user_id) . "' onclick='showPopupUser(this)' class='float-right' title='Edit akun user'><i class='icon-user'></i></a>";
                }
            })
            ->addColumn('action', function ($p) {
                $editBtn = "<a onclick='edit(this)' title='Edit' data-url='" . route($this->route . 'edit', $p->id) . "' data-id='" . $p->id . "'><i class='icon-edit text-blue m-1' title='Edit Data'></i></a>";

                $deteleBtn = "<a onclick='remove(this)' title='Hapus'  data-url='" . route($this->route . 'destroy', $p->id) . "'><i class='icon-remove text-red m-1' title='Hapus Data'></i></a>";
                return $editBtn . $deteleBtn;
            })
            ->rawColumns(['user_id', 'action'])
            ->toJson();
    }
}
