<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
     /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $metodepembayarans = MetodePembayaran::latest()->when(request()->q, function($metodepembayarans) {
            $metodepembayarans = $metodepembayarans->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.metodepembayaran.index', compact('metodepembayarans'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('admin.metodepembayaran.create');
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
           'nama_metode'       => 'required',
       ]);

       //save to DB
       $metodepembayaran = new MetodePembayaran;
       $metodepembayaran->nama_metode  = $request->nama_metode;
       $metodepembayaran->no_rekening = $request->no_rekening;
       $metodepembayaran->nama_pemilik_rekening = $request->nama_pemilik_rekening;
       $metodepembayaran->type  = $request->type;
       $metodepembayaran->save();

       if($metodepembayaran){
            //redirect dengan pesan sukses
            return redirect()->route('admin.metodepembayaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.metodepembayaran.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * edit
     *
     * @param  mixed $metodepembayaran
     * @return void
     */
    public function edit(metodepembayaran $metodepembayaran)
    {
        return view('admin.metodepembayaran.edit', compact('metodepembayaran'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $metodepembayaran
     * @return void
     */
    public function update(Request $request, metodepembayaran $metodepembayaran)
    {
        $this->validate($request, [
            'nama_metode'       => 'required',

        ]);

        $metodepembayaran = MetodePembayaran::findOrFail($metodepembayaran->id);
        $metodepembayaran->nama_metode  = $request->nama_metode;
        $metodepembayaran->no_rekening = $request->no_rekening;
        $metodepembayaran->nama_pemilik_rekening = $request->nama_pemilik_rekening;
        $metodepembayaran->type  = $request->type;
        $metodepembayaran->save();

        if($metodepembayaran){
             //redirect dengan pesan sukses
             return redirect()->route('admin.metodepembayaran.index')->with(['success' => 'Data Berhasil Diupdate!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.metodepembayaran.index')->with(['error' => 'Data Gagal Diupdate!']);
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
        $metodepembayaran = MetodePembayaran::findOrFail($id);
        $metodepembayaran->delete();

        if($metodepembayaran){
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
