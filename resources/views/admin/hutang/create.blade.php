@extends('layouts.app', ['title' => 'Tambah Kategori'])

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-folder"></i> TAMBAH HUTANG</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.hutang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>NAMA HUTANG</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Hutang" class="form-control @error('nama') is-invalid @enderror">

                       
                       
                            @error('nama')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis Hutang</label>
                            <select name="jenis_hutang" class="form-control @error('nama') is-invalid @enderror">
                                <option value="">Jenis Hutang</option>
                                <option value="hutang">Hutang </option>
                                <option value="piutang">Piutang</option>
                            </select>
                            @error('jenis_hutang')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>NOMINAL</label>
                            <input type="number" name="nominal" value="{{ old('nominal') }}" placeholder="Masukkan Nama Hutang" class="form-control @error('nominal') is-invalid @enderror">

                            @error('nominal')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder="Masukkan Keterangan" class="form-control @error('keterangan') is-invalid @enderror" ></textarea>

                            @error('keterangan')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
