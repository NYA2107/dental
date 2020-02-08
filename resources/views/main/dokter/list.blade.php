@extends('../../dashboard')

@section('title')
    Tambah Dokter
@endsection

@section('content')

    @foreach($dokter??[] as $key => $v)
    <div id="modal-edit-{{$v->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dark-header-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-dark">
                    <h4 class="modal-title" id="dark-header-modalLabel">Edit Dokter - {{$v->nama}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{route('dokter-edit')}}">
                    <div class="modal-body">   
                        {{ csrf_field() }}
                        <input type="hidden" value="{{$v->id}}" name="id">
                        <div style="padding:1em;width:100%;">
                            <h5 class="mt-0">Nama Dokter</h5>
                            <input type="text" value="{{$v->nama}}" name="nama" class="form-control" placeholder="Masukan nama dokter">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-dark">
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="modal-delete-{{$v->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-danger">
                    <h4 class="modal-title" id="danger-header-modalLabel">Delete - {{$v->nama}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="post" action="{{route('dokter-remove')}}">
                    <div class="modal-body">
                        <p>Apakah anda yakin akan menghapus <code>{{$v->nama}}</code>?</p>
                    </div>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$v->id}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <input type="submit" value="Ya" class="btn btn-danger">
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    @endforeach

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tambah Dokter</h4>
            <h6 class="card-subtitle">Tuliskan nama dokter lalu klik tambah dokter untuk menambahkan dokter</h6>
            <form method="post" action="{{route('dokter-store')}}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="text" name="nama" class="form-control" placeholder="Masukan nama dokter">
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" value="Tambah Dokter" class="btn waves-effect waves-light btn-primary" placeholder="name@example.com">
                    </div>
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
            <h4 class="card-title">List Dokter</h4>
            <h6 class="card-subtitle">List dokter yang telah ditambahkan</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama</th>
                            <th width="250">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dokter??[] as $key => $v)
                        <tr>
                            <td>{{$key + $dokter->firstItem()}}</td>
                            <td>{{$v->nama}}</td>
                            <td style="display:grid;grid-template-columns:1fr 1fr;grid-gap:1em;">
                                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modal-edit-{{$v->id}}"><i class="far fa-edit"></i> Edit</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{$v->id}}"><i class="far fa-trash-alt"></i> Delete</button>
                            </td>
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