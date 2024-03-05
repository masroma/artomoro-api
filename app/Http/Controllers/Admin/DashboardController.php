<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //count invoice

        //year and month
        $year   = date('Y');
        $month  = date('m');

        //statistic revenue
        // $revenueMonth = Invoice::where('status', 'success')->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->sum('grand_total');
        // $revenueYear  = Invoice::where('status', 'success')->whereYear('created_at', $year)->sum('grand_total');
        // $revenueAll   = Invoice::where('status', 'success')->sum('grand_total');


        $productsexp = Product::where('tanggal_exp', '>=', Carbon::now())
        ->where('tanggal_exp', '<=', Carbon::now()->addMonth(4))
        ->orderBy('tanggal_exp','ASC')
        ->paginate(10);


        // omset hari ini
        $hariIni = Carbon::now()->toDateString();
        $totalOmsetHariIni = Invoice::where('customer_id', auth()->user()->id)
            ->whereDate('created_at', $hariIni)
            ->sum('grand_total');
        $totalLabaHariIni = Invoice::where('customer_id', auth()->user()->id)
            ->whereDate('created_at', $hariIni)
            ->sum('grand_total_modal');

        $kemarin = Carbon::yesterday()->toDateString();
        $totalOmsetKemarin = Invoice::where('customer_id', auth()->user()->id)
            ->whereDate('created_at', $kemarin)
            ->sum('grand_total');
        $totalLabaKemarin = Invoice::where('customer_id', auth()->user()->id)
            ->whereDate('created_at', $kemarin)
            ->sum('grand_total_modal');

        $awalBulan = Carbon::now()->startOfMonth()->toDateString();
        $akhirBulan = Carbon::now()->endOfMonth()->toDateString();

        $totalOmsetBulanIni = Invoice::where('customer_id', auth()->user()->id)
            ->whereBetween('created_at', [$awalBulan, $akhirBulan])
            ->sum('grand_total');
        $totalLabaBulanIni = Invoice::where('customer_id', auth()->user()->id)
            ->whereBetween('created_at', [$awalBulan, $akhirBulan])
            ->sum('grand_total_modal');



        // $totalLabaBulanIni = Invoice::with('orders')->


        return view('admin.dashboard.index', compact('totalOmsetHariIni','totalOmsetBulanIni','totalOmsetKemarin','totalLabaHariIni','totalLabaBulanIni','totalLabaKemarin','productsexp'));
    }
}
