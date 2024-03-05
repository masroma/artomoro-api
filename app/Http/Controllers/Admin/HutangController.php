<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hutang;

class HutangController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $data = Hutang::latest()->when(request()->q, function($row) {
            $row = $row->where('nama', 'like', '%'. request()->q . '%')
            ->orWhere('keterangan', 'like', '%'. request()->q . '%')
            ->orWhere('jenis_hutang', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.hutang.index', compact('data'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('admin.hutang.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
           'nama'  => 'required',
           'keterangan'  => 'required',
           'jenis_hutang'  => 'required',
           'nominal'  => 'required',

       ]);

       //upload image

       //save to DB
       $save = Hutang::create([
           'nama'   => $request->nama,
           'keterangan' => $request->keterangan,
           'jenis_hutang' => $request->jenis_hutang,
           'nominal' => $request->nominal
       ]);

       if($save){
            //redirect dengan pesan sukses
            return redirect()->route('admin.hutang.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.hutang.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * edit
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function edit(Hutang $hutang)
    {
        return view('admin.hutang.edit', compact('category'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $category
     * @return void
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'nama'  => 'required',
            'keterangan'  => 'required',
            'jenis_hutang'  => 'required',
            'nominal'  => 'required',

        ]);

        $update = Hutang::findOrFail($category->id);
        $update->update([
            'nama'   => $request->nama,
           'keterangan' => $request->keterangan,
           'jenis_hutang' => $request->jenis_hutang,
           'nominal' => $request->nominal
        ]);

        if($update){
            //redirect dengan pesan sukses
            return redirect()->route('admin.hutang.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.hutang.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $data = Hutang::findOrFail($id);

        $data->delete();

        if($data){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
