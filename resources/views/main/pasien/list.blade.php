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
    @if(\Session::has('msg'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Success - </strong> {!! \Session::get('msg') !!}
        </div>
	@endif
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">List Pasien</h4>
            <h6 class="card-subtitle">List pasien yang telah terdaftar</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dokter??[] as $key => $v)
                        <tr>
                            <td>{{$key + $dokter->firstItem()}}</td>
							<td>{{$v->nama}}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            <div style="display: flex;justify-content: center;">
                @if(count($dokter))
                    {{ $dokter->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection