@extends('layouts.app', ['title' => 'Tambah Metode Pembayaran'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-user-circle"></i> TAMBAH METODE PEMBAYARAN</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.metodepembayaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Metode <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_metode" value="{{ old('nama_metode') }}"
                                        placeholder="Masukkan Nama Metode"
                                        class="form-control @error('nama_metode') is-invalid @enderror">


                                    @error('nama_metode')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No Rekening</label>
                                    <input type="number" name="no_rekening" value="{{ old('no_rekening') }}"
                                        placeholder="Masukkan No Rekening"
                                        class="form-control @error('no_rekening') is-invalid @enderror">

                                    @error('no_rekening')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pemilik Rekening </label>
                                    <input type="text" name="nama_pemilik_rekening" value="{{ old('nama_pemilik_rekening') }}"
                                        placeholder="Masukkan Nama Pemilik Rekening"
                                        class="form-control @error('nama_pemilik_rekening') is-invalid @enderror">


                                    @error('nama_pemilik_rekening')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select name="type" class="form-control @error('no_rekening') is-invalid @enderror">
                                        <option value=""></option>
                                        <option value="transfer">Transfer</option>
                                        <option value="cash">COD</option>
                                        <option value="virtual_account">Virtual Account</option>
                                    </select>
                                    @error('no_rekening')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
