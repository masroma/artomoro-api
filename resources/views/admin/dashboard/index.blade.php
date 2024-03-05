@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->


        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-md-4">

                <div class="card border-0 shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">PENDAPATAN KEMARIN</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h5>{{ moneyFormat($totalOmsetKemarin) }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">PENDAPATAN HARI INI</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h5>{{ moneyFormat($totalOmsetHariIni) }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">PENDAPATAN BULAN INI</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h5>{{ moneyFormat($totalOmsetBulanIni) }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="card border-0 shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">LABA KEMARIN</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h5>{{ moneyFormat($totalOmsetKemarin - $totalLabaKemarin) }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">LABA HARI INI</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h5>{{ moneyFormat($totalOmsetHariIni - $totalLabaHariIni) }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold">LABA BULAN INI</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <h5>{{ moneyFormat($totalOmsetBulanIni - $totalLabaBulanIni) }}</h5>
                    </div>
                </div>
            </div>

        </div>

        <div class="row ">
            <div class="col-md-12">
                @php
                    $totalqty = 0;
                    $kerugian = 0;

                    foreach ($productsexp as $r) {
                        $totalqty += $r->stock;
                        $kerugian += $r->stock * $r->harga_modal;
                    }

                @endphp
                <div class="card border-0 shadow mb-4 p-3">
                    <p>Total Product yang akan exp 3 bulan mendatang</p>
                    <p>Total qty produk: {{ $totalqty }}</p>
                    <p>Estimasi Kerugian : {{ moneyFormat($kerugian) }}</p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card border-0 shadow mb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col">GAMBAR</th>
                                    <th scope="col">NAMA PRODUCT</th>
                                    <th scope="col">Harga Modal</th>
                                    <th scope="col">Sisa Stok</th>
                                    <th scope="col">EXP</th>
                                    <th scope="col">Kerugian</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productsexp as $no => $r)
                                    <tr>
                                        <th scope="row" style="text-align: center">
                                            {{ ++$no + ($productsexp->currentPage() - 1) * $productsexp->perPage() }}</th>
                                        <td class="text-center">
                                            <img src="{{ $r->image }}" style="width:50px">
                                        </td>
                                        <td>{{ $r->title }}</td>
                                        <td> {{ moneyFormat($r->harga_modal) }}</td>
                                        <td>{{ $r->stock }}</td>

                                        <td>{{ \Carbon\Carbon::parse($r->tanggal_exp)->isoFormat('DD MMMM YYYY') }}</td>

                                        <td>{{ moneyFormat($r->harga_modal * $r->stock) }}</td>
                                    </tr>
                                @empty

                                    <div class="alert alert-danger">
                                        Data Belum Tersedia!
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{ $productsexp->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
