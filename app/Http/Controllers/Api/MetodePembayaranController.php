<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        $data = MetodePembayaran::all();
        return response()->json([
            'success'       => true,
            'message'       => 'List Data Metode Pembayaran',
            'data'    => $data
        ]);
    }
}
