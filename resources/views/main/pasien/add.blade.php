@extends('../../dashboard')

@section('title')
    Tambah Pasien
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-dark">
            <h4 class="card-title text-white">Tambah Pasien</h4>
            <h6 class="card-subtitle text-white">Data yang dimasukkan harus lengkap</h6>
        </div>
        @if(\Session::has('msg'))
            <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Success - </strong> {!! \Session::get('msg') !!}
            </div>
        @endif
        @if($errors->first('error'))
            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Error - </strong> {!! $errors->first('error') !!}
            </div>
        @endif
        <div class="card-body">
            <form method="post" action="{{route('pasien-store')}}">
                {{ csrf_field() }}
                <div style="margin:1em;display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr 1fr; grid-gap:1em;">
                    <div style="grid-column:1/7;">
                        <label class="form-control-label">No Rekam Medis</label>
                        <input type="text" class="form-control" name="no_rekam_medis" placeholder="Masukan no rekam medis">
                    </div>
                    <div style="grid-column:1/7;">
                        <label class="form-control-label">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukan nama">
                    </div>
                    <div style="grid-column:1/3;">
                        <label class="form-control-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" placeholder="Masukan tanggal lahir">
                    </div>
                    <div style="grid-column:3/5;">
                        <label class="form-control-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="pekerjaan" placeholder="Masukan pekerjaan">
                    </div>
                    <div style="grid-column:5/7;">
                        <label class="form-control-label">Tanggal</label>
                        <input type="date" value="{{$tanggal}}" name="tanggal" class="form-control">
                    </div>
                    <div style="grid-column:1/7;">
                        <label class="form-control-label">Alamat</label>
                        <textarea placeholder="Masukan alamat" name="alamat" class="form-control"></textarea>
                    </div>
                    <div style="grid-column:1/7">
                        <label class="form-control-label">Jenis Kelamin</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" value="L" name="jenis_kelamin" class="custom-control-input" checked>
                            <label class="custom-control-label" for="customRadio1">Laki-Laki</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" value="P" name="jenis_kelamin" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio2">Perempuan</label>
                        </div>
                    </div>
                </div>
                <div style="display:flex;justify-content:center;">
                    <input type="submit" value="Simpan" class="form-control btn waves-effect waves-light btn-dark">
                </div>
            <form>
        </div>
    </div>
@endsection