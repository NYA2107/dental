@extends('../../dashboard')

@section('title')
    Tambah Pasien
@endsection

@section('content')
    <div class="card">
        @if(\Session::has('msg'))
            <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Success - </strong> {!! \Session::get('msg') !!}
            </div>
        @endif
        <div class="card-body">
            <h4 class="card-title">Tambah Pasien</h4>
            <h6 class="card-subtitle">Tambahkan pasien</h6>
            <form method="get" action="{{route('pasien-search')}}">
                {{ csrf_field() }}
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;">
                        <div style="margin:1em">
                            <label class="form-control-label">No Rekam Medis</label>
                            <input type="text" class="form-control" placeholder="Masukan no rekam medis">
                        </div>
                        <div style="margin:1em">
                            <label class="form-control-label">Nama</label>
                            <input type="text" class="form-control" placeholder="Masukan nama pasien">
                        </div>
                        <div style="margin:1em">
                            <label class="form-control-label">Usia</label>
                            <input type="text" class="form-control" placeholder="Masukan usia pasien">
                        </div>
                </div>
                <div style="display:flex;justify-content:center;">
                    <input type="submit" value="Cari Pasien" class="form-control btn waves-effect waves-light btn-primary">
                </div>
            <form>
        </div>
    </div>
@endsection