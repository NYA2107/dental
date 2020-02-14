@extends('../../dashboard')

@section('title')
    Pasien
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Filter Pasien</h4>
            <h6 class="card-subtitle">Cari pasien berdasarkan nama, nomer rekam medis atau usia pasien (form boleh dikosingi atau pilih beberapa)</h6>
            <form method="get" action="{{route('pasien-search')}}">
                {{ csrf_field() }}
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;">
                        <div style="margin:1em">
                            <label class="form-control-label">No Rekam Medis</label>
                            <input type="text" name="no_rekam_medis" class="form-control" placeholder="Masukan no rekam medis">
                        </div>
                        <div style="margin:1em">
                            <label class="form-control-label">Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukan nama pasien">
                        </div>
                        <div style="margin:1em">
                            <label class="form-control-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>
                </div>
                <div style="display:flex;justify-content:center;">
                    <input type="submit" value="Cari Pasien" class="form-control btn waves-effect waves-light btn-primary">
                </div>
            <form>
        </div>
    </div>
    @if(\Session::has('msg'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Success - </strong> {!! \Session::get('msg') !!}
        </div>
	@endif
    <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:1em;">
        
        @foreach($pasien??[] as $key => $v)
        <div class="card text-white bg-dark">
            <div class="card-header" style="display:grid;grid-template-columns:1fr auto;">
                <h4 class="mb-0 text-white">
                    @if($v->jenis_kelamin == 'L')
                    <i class="icon-symbol-male"></i>
                    @else
                    <i class="icon-symble-female"></i> 
                    @endif
                    {{$v->no_rekam_medis}}
                </h4>
                <!-- <div>
                    <a href="{{route('pasien-detail', $v->id)}}" style="margin-right:0.3em;"><i class="fas fa-edit text-white"></i></a>
                    <a href="javascript:void(0)"><i class="fas fa-trash-alt text-white"></i></a>
                </div> -->
            </div>
            <div class="card-body">
                <?php
                    $tanggal_lahir = date_format(date_create($v->tanggal_lahir), 'd-m-Y');
                    $tanggal = date_format(date_create($v->tanggal), 'd-m-Y');

                ?>
                <h3 class="card-title text-white">{{$v->nama}}</h3>
                <p class="card-text">@if($v->jenis_kelamin == 'L')Laki-laki @else Perempuan @endif , <code>{{$v->pekerjaan}}</code> yang lahir pada tanggal <code>{{$tanggal_lahir}}</code> didaftarkan sebagai pasien pada tanggal <code>{{$tanggal}}</code></p>
                <p class="card-text">Alamat : <code>{{$v->alamat}}</code></p>
                <a href="javascript:void(0)" class="btn btn-light">Tambah Ke Antrian</a>
                <a href="javascript:void(0)" class="btn btn-secondary">Berkunjung</a>
                <a href="{{route('pasien-detail', $v->id)}}" class="btn btn-primary">Detail</a>
            </div>
        </div>
        @endforeach
    </div>
    <div style="display: flex;justify-content: center;">
        @if(count($pasien))
            {{ $pasien->links() }}
        @endif
    </div>
@endsection