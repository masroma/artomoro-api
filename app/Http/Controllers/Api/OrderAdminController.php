<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderAdminController extends Controller
{


    /**
     * index
     *
     * @return void
     */
    public function index()
    {

        $invoices = Invoice::with(['orders','payment'])
        ->when(request()->tanggal != null, function($query){
            $query->whereDate('created_at', request()->tanggal);
        })
        ->where('customer_id', auth()->guard('api_admin')->user()->id)
        ->paginate(10);


        return response()->json([
            'success' => true,
            'message' => 'List Invoices: '.auth()->guard('api_admin')->user()->name,
            'data'    => $invoices
        ], 200);

    }



    public function omsetKemarin()
    {
        // Menggunakan Carbon untuk mendapatkan tanggal kemarin
        $kemarin = Carbon::yesterday()->toDateString();

        $totalOmset = Invoice::where('customer_id', auth()->user()->id)
            ->whereDate('created_at', $kemarin)
            ->sum('grand_total');

        return response()->json([
            'success' => true,
            'message' => 'Total Omset Kemarin',
            'totalOmset' => $totalOmset
        ], 200);
    }


    public function omsetHariIni()
    {
        // Menggunakan Carbon untuk mendapatkan tanggal hari ini
        $hariIni = Carbon::now()->toDateString();

        $totalOmset = Invoice::where('customer_id', auth()->user()->id)
            ->whereDate('created_at', $hariIni)
            ->sum('grand_total');

        return response()->json([
            'success' => true,
            'message' => 'Total Omset Hari Ini',
            'totalOmset' => $totalOmset
        ], 200);
    }


    public function omsetSatuBulanIni()
    {
        // Menggunakan Carbon untuk mendapatkan tanggal awal dan akhir dari bulan ini
        $awalBulan = Carbon::now()->startOfMonth()->toDateString();
        $akhirBulan = Carbon::now()->endOfMonth()->toDateString();

        $totalOmset = Invoice::where('customer_id', auth()->user()->id)
            ->whereBetween('created_at', [$awalBulan, $akhirBulan])
            ->sum('grand_total');

        return response()->json([
            'success' => true,
            'message' => 'Total Omset Satu Bulan Ini',
            'totalOmset' => $totalOmset
        ], 200);
    }

    /**
     * show
     *
     * @param  mixed $snap_token
     * @return void
     */
    public function show($snap_token)
    {
        $invoice = Invoice::where('customer_id', auth()->guard('api_admin')->user()->id)->where('snap_token', $snap_token)->latest()->first();

        return response()->json([
            'success' => true,
            'message' => 'Detail Invoices: '.auth()->guard('api_admin')->user()->name,
            'data'    => $invoice,
            'product' => $invoice->orders
        ], 200);

    }
}
