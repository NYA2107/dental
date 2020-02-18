@extends('../../dashboard')

@section('title')
    Detil Pasien
@endsection

@section('content')
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
<div class="card text-white bg-dark">
    <div class="card-header" style="display:grid;grid-template-columns:1fr auto;">
        <h4 class="mb-0 text-white">
            @if($pasien->jenis_kelamin == 'L')
            <i class="icon-symbol-male"></i>
            @else
            <i class="icon-symble-female"></i> 
            @endif
            {{$pasien->no_rekam_medis}}
        </h4>
        <div>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-edit" style="margin-right:0.3em;"><i class="fas fa-edit text-white"></i></a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt text-white"></i></a>
        </div>
    </div>
    <div class="card-body">
        <?php
            $tanggal_lahir = date_format(date_create($pasien->tanggal_lahir), 'd-m-Y');
            $tanggal = date_format(date_create($pasien->tanggal), 'd-m-Y');

        ?>
        <h3 class="card-title text-white">{{$pasien->nama}}</h3>
        <p class="card-text">@if($pasien->jenis_kelamin == 'L')Laki-laki @else Perempuan @endif , Seorang <code>{{$pasien->pekerjaan}}</code> yang lahir pada tanggal <code>{{$tanggal_lahir}}</code> didaftarkan sebagai pasien pada tanggal <code>{{$tanggal}}</code></p>
        <p class="card-text">Alamat : <code>{{$pasien->alamat}}</code></p>
        <a href="{{route('antrian-add-json', ['id'=>$pasien->id])}}" class="btn btn-light">Tambah Ke Antrian</a>
        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-kunjungan" class="btn btn-secondary">Berkunjung</a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-3">Data Pasien</h4>
        <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
            <li class="nav-item">
                <a href="#kunjungan" data-toggle="tab" aria-expanded="false" class="nav-link active">
                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                    <span class="d-none d-lg-block">Kunjungan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#odontogram" data-toggle="tab" aria-expanded="true" class="nav-link">
                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                    <span class="d-none d-lg-block">Odontogram</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#file_storage" data-toggle="tab" aria-expanded="false" class="nav-link">
                    <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                    <span class="d-none d-lg-block">File Pasien</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="kunjungan">
                @if(!$kunjungan->isEmpty())
                <div id="accordion" class="custom-accordion mb-4">
                    <div class="card mb-0">
                        <div class="card-header" id="headingOne">
                            <h5 class="m-0">
                                <a class="custom-accordion-title d-block pt-2 pb-2 collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Filter <span class="float-right"><i class="mdi mdi-chevron-down accordion-arrow"></i></span>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                            <div class="card-body">
                                <form method="get" action="{{route('pasien-kunjungan-search', $pasien->id)}}">
                                    {{ csrf_field() }}
                                    <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:1em">
                                        <div style="grid-column:1/2">
                                            <label class="form-control-label">Tanggal</label>
                                            <input type="date" value="{{$tanggal}}" class="form-control" name="tanggal">
                                        </div>
                                        <div style="grid-column:2/3">
                                            <label class="form-control-label">Diagnosa</label>
                                            <textarea placeholder="Masukan diagnosa" name="diagnosa" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div style="display:flex;justify-content:center;margin-top:1em;">
                                        <input type="submit" value="Filter Kunjungan" class="form-control btn waves-effect waves-light btn-dark">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end card-->
                </div>        
                <div style="display:grid;grid-template-columns:1fr 1fr; grid-column-gap:1em;">
                    @foreach($kunjungan??[] as $key => $v)
                    <div class="card text-white bg-dark">
                        <?php
                            $tanggal = date_format(date_create($v->tanggal), 'd-m-Y');

                        ?>
                        <div class="card-header" style="display:grid;grid-template-columns:1fr auto;">
                            <h4 class="mb-0 text-white">
                                {{$tanggal}} - Dokter : {{$v->dokter->nama}}
                            </h4>
                            <div>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-kunjungan-edit-{{$v->id}}" style="margin-right:0.3em;"><i class="fas fa-edit text-white"></i></a>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-kunjungan-delete-{{$v->id}}"><i class="fas fa-trash-alt text-white"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text m-0">Anamnesa : <code>{{$v->anamnesa}}</code></p>
                            <p class="card-text m-0">Diagnosa : <code>{{$v->diagnosa}}</code></p>
                            <p class="card-text m-0">Tindakan : <code>{{$v->tindakan}}</code></p>
                            <p class="card-text m-0">Biaya : <code>@currency($v->biaya)</code></p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div style="display: flex;justify-content: center;">
                    @if(count($kunjungan))
                        {{ $kunjungan->links() }}
                    @endif
                </div>
                @else
                <p style="text-align:center;">Tidak ada data yang ditampilkan</p>
                @endif
            </div>
            <div class="tab-pane show" id="odontogram">
                  <div id="odontogram-diagram"></div>
            </div>
            <div class="tab-pane" id="file_storage">
                <div id="accordion" class="custom-accordion mb-4">
                    <div class="card mb-0">
                        <div class="card-header" id="headingOne">
                            <h5 class="m-0">
                                <a class="custom-accordion-title d-block pt-2 pb-2 collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Upload File <span class="float-right"><i class="mdi mdi-chevron-down accordion-arrow"></i></span>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                            <div class="card-body">
                                <form method="post" action="{{route('pasien-upload')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$pasien->id}}" class="form-control" name="id_pasien">
                                    <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:1em">
                                        <div style="grid-column:1/3">
                                            <label class="form-control-label">Keterangan</label>
                                            <textarea placeholder="Masukan keterangan" name="keterangan" class="form-control"></textarea>
                                        </div>
                                        <div style="grid-column:1/2">
                                            <label class="form-control-label">Tanggal</label>
                                            <input type="date" value="{{$tanggal}}" class="form-control" name="tanggal">
                                        </div>
                                        <div style="grid-column:2/3">
                                            <label class="form-control-label">File</label>
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="inputGroupFile01">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display:flex;justify-content:center;margin-top:1em;">
                                        <input type="submit" value="Upload File" class="form-control btn waves-effect waves-light btn-dark">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end card-->
                </div>
                @if(!$file->isEmpty())
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th width="50">#</th>
                                <th>Keterangan</th>
                                <th>Nama File</th>
                                <th>Tanggal</th>
                                <th width="250">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($file??[] as $key => $v)
                            <tr>
                                <td>{{$key + $file->firstItem()}}</td>
                                <td>{{$v->keterangan}}</td>
                                <td>{{$v->file_name}}</td>
                                <td>{{$v->tanggal}}</td>
                                <td style="display:grid;grid-template-columns:1fr 1fr;grid-gap:1em;">
                                    <a class="btn btn-light" href="{{ route('pasien-view-file', $v->id)}}" target="_blank"><i class="fas fa-eye"></i></a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-file-delete-{{$v->id}}"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div style="display: flex;justify-content: center;">
                    @if(count($file))
                        {{ $file->links() }}
                    @endif
                </div>
                @else
                <p style="text-align:center;">Tidak ada data yang ditampilkan</p>
                @endif

            </div>
        </div>

    </div>
</div>

<!-- ALL MODAL -->
@foreach($file??[] as $key => $k)
<div id="modal-file-delete-{{$k->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-danger">
                <h4 class="modal-title" id="danger-header-modalLabel">Delete Kunjungan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="post" action="{{route('pasien-remove-file')}}">
                <div class="modal-body">
                    <p>Apakah anda yakin akan menghapus file dengan keterangan <code>{{$k->keterangan}}</code> yang ditambahkan pada tanggal <code>{{$k->tanggal}}</code>?</p>
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="id_pasien" value="{{$pasien->id}}">
                <input type="hidden" name="id" value="{{$k->id}}">
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Batal</button>
                    <input type="submit" value="Ya" class="btn btn-danger">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endforeach

@foreach($kunjungan??[] as $key => $k)
<div id="modal-kunjungan-delete-{{$k->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-danger">
                <h4 class="modal-title" id="danger-header-modalLabel">Delete Kunjungan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="post" action="{{route('kunjungan-remove')}}">
                <div class="modal-body">
                    <p>Apakah anda yakin akan menghapus kunjungan dengan anamnesa <code>{{$k->anamnesa}}</code> yang ditambahkan pada tanggal <code>{{$k->tanggal}}</code>?</p>
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$k->id}}">
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Batal</button>
                    <input type="submit" value="Ya" class="btn btn-danger">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endforeach

@foreach($kunjungan??[] as $key => $v)
<div id="modal-kunjungan-edit-{{$v->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dark-header-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title" id="dark-header-modalLabel">Edit Kunjungan - {{$pasien->nama}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('kunjungan-edit')}}">
                    {{ csrf_field() }}
                    <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:1em">
                        <input type="hidden" name="id" value="{{$v->id}}">
                        <input type="hidden" name="id_pasien" value="{{$pasien->id}}">
                        <div style="grid-column:1/2">
                            <label class="form-control-label">Tanggal</label>
                            <input type="date" value="{{$v->tanggal}}" class="form-control" name="tanggal">
                        </div>
                        <div class="grid-column:2/3">
                            <label for="dokter">Dokter</label>
                            <select class="form-control" name="id_dokter" id="dokter">
                                @foreach($dokter as $o)
                                    <option {{$v->id_dokter == $o->id?'selected':''}} value="{{$o->id}}">{{$o->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="grid-column:1/3">
                            <label class="form-control-label">Anamnesa</label>
                            <textarea placeholder="Masukan anamnesa" name="anamnesa" class="form-control">{{$v->anamnesa}}</textarea>
                        </div>
                        <div style="grid-column:1/3">
                            <label class="form-control-label">Diagnosa</label>
                            <textarea placeholder="Masukan diagnosa" name="diagnosa" class="form-control">{{$v->diagnosa}}</textarea>
                        </div>
                        <div style="grid-column:1/3">
                            <label class="form-control-label">Tindakan</label>
                            <textarea placeholder="Masukan tindakan" name="tindakan" class="form-control">{{$v->tindakan}}</textarea>
                        </div>
                        
                        <div style="grid-column:1/3">
                            <label class="form-control-label">Biaya</label>
                            <input type="number" value="{{$v->biaya}}" class="form-control" name="biaya">
                        </div>
                    </div>
                    <div style="display:flex;justify-content:center;margin-top:1em;">
                        <input type="submit" value="Simpan" class="form-control btn waves-effect waves-light btn-dark">
                    </div>
                </form>
                <!-- End Form Add Kunjungan -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endforeach

<div id="modal-kunjungan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dark-header-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title" id="dark-header-modalLabel">Tambah Kunjungan - {{$pasien->nama}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <!-- Form Add Kunjungan -->
            <div class="card-body">
                <form method="post" action="{{route('kunjungan-store')}}">
                    {{ csrf_field() }}
                    <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:1em">
                        <input type="hidden" name="id_pasien" value="{{$pasien->id}}">
                        <div style="grid-column:1/2">
                            <label class="form-control-label">Tanggal</label>
                            <input type="date" value="{{$tanggal}}" class="form-control" name="tanggal">
                        </div>
                        <div class="grid-column:2/3">
                            <label for="dokter">Dokter</label>
                            <select class="form-control" name="id_dokter" id="dokter">
                                @foreach($dokter as $v)
                                    <option value="{{$v->id}}">{{$v->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="grid-column:1/3">
                            <label class="form-control-label">Anamnesa</label>
                            <textarea placeholder="Masukan anamnesa" name="anamnesa" class="form-control"></textarea>
                        </div>
                        <div style="grid-column:1/3">
                            <label class="form-control-label">Diagnosa</label>
                            <textarea placeholder="Masukan diagnosa" name="diagnosa" class="form-control"></textarea>
                        </div>
                        <div style="grid-column:1/3">
                            <label class="form-control-label">Tindakan</label>
                            <textarea placeholder="Masukan tindakan" name="tindakan" class="form-control"></textarea>
                        </div>
                        
                        <div style="grid-column:1/3">
                            <label class="form-control-label">Biaya</label>
                            <input type="number" class="form-control" name="biaya">
                        </div>
                    </div>
                    <div style="display:flex;justify-content:center;margin-top:1em;">
                        <input type="submit" value="Simpan" class="form-control btn waves-effect waves-light btn-dark">
                    </div>
                </form>
                <!-- End Form Add Kunjungan -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="modal-delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-danger">
                <h4 class="modal-title" id="danger-header-modalLabel">Delete - {{$pasien->nama}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="post" action="{{route('pasien-remove')}}">
                <div class="modal-body">
                    <p>Apakah anda yakin akan menghapus <code>{{$pasien->nama}}</code> dengan nomor rekam medis <code>{{$pasien->no_rekam_medis}}</code>?</p>
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$pasien->id}}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <input type="submit" value="Ya" class="btn btn-danger">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dark-header-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-dark">
                <h4 class="modal-title" id="dark-header-modalLabel">Edit Pasien - {{$pasien->nama}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="post" action="{{route('pasien-edit')}}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$pasien->id}}">
                <div style="padding:1em;margin:1em;display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr 1fr; grid-gap:1em;">
                    <div style="grid-column:1/7;">
                        <label class="form-control-label">No Rekam Medis</label>
                        <input type="text" value="{{$pasien->no_rekam_medis}}" class="form-control" name="no_rekam_medis" placeholder="Masukan no rekam medis">
                    </div>
                    <div style="grid-column:1/7;">
                        <label class="form-control-label">Nama</label>
                        <input type="text" value="{{$pasien->nama}}" class="form-control" name="nama" placeholder="Masukan nama">
                    </div>
                    <div style="grid-column:1/3;">
                        <label class="form-control-label">Tanggal Lahir</label>
                        <input type="date" value="{{$pasien->tanggal_lahir}}" class="form-control" name="tanggal_lahir" placeholder="Masukan tanggal lahir">
                    </div>
                    <div style="grid-column:3/5;">
                        <label class="form-control-label">Pekerjaan</label>
                        <input type="text" value="{{$pasien->pekerjaan}}" class="form-control" name="pekerjaan" placeholder="Masukan pekerjaan">
                    </div>
                    <div style="grid-column:5/7;">
                        <label class="form-control-label">Tanggal</label>
                        <input type="date" value="{{$pasien->tanggal}}" name="tanggal" class="form-control">
                    </div>
                    <div style="grid-column:1/7;">
                        <label class="form-control-label">Alamat</label>
                        <textarea type="date" placeholder="Masukan alamat" name="alamat" class="form-control">{{$pasien->alamat}}</textarea>
                    </div>
                    <div style="grid-column:1/7">
                        <label class="form-control-label">Jenis Kelamin</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" value="L" name="jenis_kelamin" class="custom-control-input" {{$pasien->jenis_kelamin == 'L'?'checked':''}}>
                            <label class="custom-control-label" for="customRadio1">Laki-Laki</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" value="P" name="jenis_kelamin" class="custom-control-input" {{$pasien->jenis_kelamin == 'P'?'checked':''}}>
                            <label class="custom-control-label" for="customRadio2">Perempuan</label>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:center;grid-column:1/7">
                        <input type="submit" value="Simpan" class="form-control btn waves-effect waves-light btn-dark">
                    </div>
                </div>
                
            <form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="{{url('react/babel.min.js')}}"></script>
<script src="{{url('react/lodash.min.js')}}"></script>
<script crossorigin src="{{url('react/react.production.min.js')}}"></script>
<script crossorigin src="{{url('react/react-dom.production.min.js')}}"></script>
<script src="{{url('react/axios.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/react-tiny-popover@4.0.0/dist/Popover.min.js"></script>
<script type="text/babel"> 

    const colorLib = {
        lightGrey:'#e2e2e2',
        grey:'#757575',
        normal:'white',
        belum_erupsi:'#49b0ff',
        sudah_dicabut:'#ff4c8d',
        sudah_goyah:'#4fff4c',
        tambalan:'#ff4c4c',
        karies:'#c34cff',
        gigi_tiruan:'#ffd84c',
        gigi_sehat:'#4cdbff',
        none:'white'
    }

    const categoryList = [
        {
            
        }
    ]

    const Container = (props) =>{
        let style = {
            display:'grid',
            gridTemplateColumns:'1fr',
            gridGap:'1em'
        }
        return(
            <div style={style}>
                {props.children}
            </div>
        )
    }

    const DiagramContainer = (props) => {
        let style = {
            display:'grid',
            gridTemplateColumns:'1fr 1fr',
            gridGap:'1em'
        }
        return(
            <div style={style}>
                {props.children}
            </div>
        )
    }
    const LeftContainer = (props) => {
        let style = {
            display:'flex',
            justifyContent:'flex-end'
        }
        return(
            <div style={style}>
                {props.children}
            </div>
        )
    }

    const RightContainer = (props) => {
        let style = {
            display:'flex',
            justifyContent:'flex-start'
        }
        return(
            <div style={style}>
                {props.children}
            </div>
        )
    }

    const Gigi = (props) =>{
        let gridTemplate = props.gridTemplate?props.gridTemplate:'10px 20px 10px'
        let innerPadding = props.innerPadding?props.innerPadding:'1px'
        let {gigi, onClick, depan, kiri, tengah, kanan, belakang, block} = props
        if(block != 'none'){
            depan = block
            kiri = block
            tengah = block
            kanan = block
            belakang = block
        }
        let style = {
            display:'grid',
            gridTemplateColumns:gridTemplate,
            gridTemplateRows:gridTemplate,
            margin:'0.5em',
            padding:`${innerPadding}`,
            border:`1px solid ${colorLib.grey}`, 
            cursor:'pointer',
            backgroundColor:colorLib.lightGrey
        }

        const handleClick = () =>{
            props.onClick(props)
        }

        const Depan = (props) =>{
            let style = {
                gridColumn:'2/3',
                gridRow:'1/2',
                backgroundColor:props.color
            }
            return(
                <div style={style}></div>
            )
        }

        const Kiri = (props) =>{
            let style = {
                gridColumn:'1/2',
                gridRow:'2/3',
                backgroundColor:props.color
            }
            return(
                <div style={style}></div>
            )
        }

        const Tengah = (props) =>{
            let style = {
                gridColumn:'2/3',
                gridRow:'2/3',
                display:'flex',
                justifyContent:'center',
                alignItems:'center',
                backgroundColor:props.color,
                color:'blue'
            }
            return(
                <div style={style}>{props.children}</div>
            )
        }

        const Kanan = (props) =>{
            let style = {
                gridColumn:'3/4',
                gridRow:'2/3',
                backgroundColor:props.color
            }
            return(
                <div style={style}></div>
            )
        }

        const Belakang = (props) =>{
            let style = {
                gridColumn:'2/3',
                gridRow:'3/4',
                backgroundColor:props.color
            }
            return(
                <div style={style}></div>
            )
        }
        return(
            <div onClick={handleClick} style={style}>
                <Depan color={_.get(colorLib, depan)}/>
                <Kiri color={_.get(colorLib, kiri)}/>
                <Tengah color={_.get(colorLib, tengah)}>{gigi}</Tengah>
                <Kanan color={_.get(colorLib, kanan)}/>
                <Belakang color={_.get(colorLib, belakang)}/>
            </div>
        )
    }

    class App extends React.Component{

        // Belum Erupsi, Sudah Dicabut, Sudah Goyah, Tambalan, Karies, Gigi Tiruan, Gigi Sehat, Normal
        state={
            selected:{
                gigi:'-',
                depan:{text:'Normal', id:'normal'},
                kiri:{text:'Normal', id:'normal'},
                tengah:{text:'Normal', id:'normal'},
                kanan:{text:'Normal', id:'normal'},
                belakang:{text:'Normal', id:'normal'},
                block:{text:'', id:'none'}
            },
            data:[18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28,55,54,53,52,51,61,62,63,64,65,85,84,83,82,81,71,72,73,74,75,48,47,46,45,44,43,42,41,31,32,33,34,35,36,37,38].map(v =>{
                return {
                    gigi:v,
                    depan:{text:'Normal', id:'normal'},
                    kiri:{text:'Normal', id:'normal'},
                    tengah:{text:'Normal', id:'normal'},
                    kanan:{text:'Normal', id:'normal'},
                    belakang:{text:'Normal', id:'normal'},
                    block:{text:'', id:'none'}
                }
            }),
            detailSelected:{
                bagian:'block',
                kategori:'normal',
            }
        }

        async componentDidMount(){
            let {status, data} = await this.getOdontogram()
            if(_.isEqual(status, 200)){
                await this.setState({data:data.odontogram, idPasien:data.idPasien})
            }
            
        }
        getOdontogram = async () =>{
            let response = await axios.get("{{route('odontogram-get-json', ['id_pasien'=>$pasien->id]),}}")
            return response
        }

        setOdontogram = async (data) =>{
            let {status_code} = await axios.post("{{route('odontogram-set-json')}}", data)
            return status_code
        }
        // Belum Erupsi, Sudah Dicabut, Sudah Goyah, Tambalan, Karies, Gigi Tiruan, Gigi Sehat, Normal
        handleClick = (value) =>{
            let mapText = {
                normal:'Normal',
                belum_erupsi:'Belum Erupsi',
                sudah_dicabut:'Sudah Dicabut',
                sudah_goyah:'Sudah Goyah',
                tambalan:'Tambalan',
                karies:'Karies',
                gigi_tiruan:'Gigi Tiruan',
                gigi_sehat:'Gigi Sehat',
                none:'-'
            }
            console.log(value)
            let temp = JSON.parse(JSON.stringify(value))
            temp.depan = {id:temp.depan, text:_.get(mapText, temp.depan)}
            temp.kiri = {id:temp.kiri, text:_.get(mapText, temp.kiri)}
            temp.tengah = {id:temp.tengah, text:_.get(mapText, temp.tengah)}
            temp.kanan = {id:temp.kanan, text:_.get(mapText, temp.kanan)}
            temp.belakang = {id:temp.belakang, text:_.get(mapText, temp.belakang)}
            temp.block = {id:temp.block, text:_.get(mapText, temp.block)}
            this.setState({selected:temp})
        }

        handleChangeDetail = (e) =>{
            const {detailSelected} = this.state
            const {value, name} = e.target
            let temp = JSON.parse(JSON.stringify(detailSelected))
            _.set(temp, name, value)
            this.setState({detailSelected:temp})
        }

        getGigi= (gigi) =>{
            const {data} = this.state
            const {} = JSON.parse(JSON.stringify(data))
            let index = _.findIndex(data, v =>{
                return gigi == v.gigi
            })
            return data[index]
        }

        detailGigiContainer = {
            diplay:'flex',
            justifyContent:'center'
        }
        detailGigiStyle = {
            width:'220px'
        }
        containerDetailGigiStyle = {
            display:'flex',
            justifyContent:'center'
        }

        keteranganStyle = {
            marginTop:'1px',
            marginBottom:'1px',
            width:'100%',
        }
        keteranganHeaderStyle = {
            fontWeight:'bold',
            width:'100%',
        }
        containerKeteranganStyle = {
            display:'flex',
            flexWrap:'wrap',
            alignItems:'center',
            alignContent:'center',
            width:'300px'
        }

        containerActionStyle = {
            margin:'1em',
            borderLeft:`1px solid ${colorLib.lightGrey}`,
            paddingLeft:'1em',
            display:'flex',
            flexWrap:'wrap',
            width:'250px'
        }

        containerLegendStyle = {
            margin:'1em',
            borderLeft:`1px solid ${colorLib.lightGrey}`,
            paddingLeft:'1em',
            display:'flex',
            flexWrap:'wrap',
            alignContent:'center',
            width:'150px',
        }
        // Belum Erupsi, Sudah Dicabut, Sudah Goyah, Tambalan, Karies, Gigi Tiruan, Gigi Sehat, Normal
        getCategoryStyle = (category)=>{
            return {
                backgroundColor:_.get(colorLib, category),
                margin:'1px',
                width:'100%'
            }
        }

        getCategoryLabelStyle = (category)=>{
            return {
                backgroundColor:_.get(colorLib, category),
                margin:'1px',
                paddingLeft:'1em',
                paddingRight:'1em',
            }
        }

        getLabelCategory = (id, text) =>{
            return(
                <span className="text-white" style={this.getCategoryLabelStyle(id)}>{text}</span>
            )
        }

        handleSave = async () =>{
            let mapText = {
                normal:'Normal',
                sudah_dicabut:'Sudah Dicabut',
                belum_erupsi:'Belum Erupsi',
                sudah_goyah:'Sudah Goyah',
                tambalan:'Tambalan',
                karies:'Karies',
                gigi_tiruan:'Gigi Tiruan',
                gigi_sehat:'Gigi Sehat',
                normal:'Normal',
                none:'-'
            }
            const {selected, detailSelected, data} = this.state
            let tempSelected = JSON.parse(JSON.stringify(selected))
            let tempSelectedDetail = JSON.parse(JSON.stringify(detailSelected))
            let tempData = JSON.parse(JSON.stringify(data))
            let idGigi = tempSelected.gigi
            let index = _.findIndex(tempData, (v)=>{
                return v.gigi == idGigi
            })
            _.set(tempData[index], tempSelectedDetail.bagian, {id:tempSelectedDetail.kategori, text:_.get(mapText, tempSelectedDetail.kategori)})
            let resp = await axios.post("{{route('odontogram-set-json')}}", {
                id_pasien:"{{$pasien->id}}",
                odontogram:tempData,
            })

            if(_.get(resp,'data.msg', '') == 'success'){
                alert("Berhasil menyimpan perubahan")
                let {status, data} = await this.getOdontogram()
                if(_.isEqual(status, 200)){
                    await this.setState({data:data.odontogram, idPasien:data.idPasien, selected:JSON.parse(JSON.stringify(data.odontogram[index]))})
                }
            }
        }
        
        render(){
            const {selected, detailSelected} = this.state
            return(
                <div>
                    <div style={this.containerDetailGigiStyle}>
                        <div style={this.detailGigiStyle}>
                            <Gigi 
                                depan={selected.depan.id}
                                kiri={selected.kiri.id}
                                tengah={selected.tengah.id}
                                kanan={selected.kanan.id}
                                belakang={selected.belakang.id}
                                block={selected.block.id}
                                gigi={selected.gigi}
                                gridTemplate={`50px 100px 50px`}
                                innerPadding='1px'
                            />
                        </div>
                        <div style={this.containerKeteranganStyle}>
                            <p style={this.keteranganHeaderStyle}>Keterangan</p>
                            <p style={this.keteranganStyle}>Semua Bagian : {this.getLabelCategory(selected.block.id, selected.block.text)}</p>
                            <p style={this.keteranganStyle}>Depan : {this.getLabelCategory(selected.depan.id, selected.depan.text)}</p>
                            <p style={this.keteranganStyle}>Kiri : {this.getLabelCategory(selected.kiri.id, selected.kiri.text)}</p>
                            <p style={this.keteranganStyle}>Tengah : {this.getLabelCategory(selected.tengah.id, selected.tengah.text)}</p>
                            <p style={this.keteranganStyle}>Kanan : {this.getLabelCategory(selected.kanan.id, selected.kanan.text)}</p>
                            <p style={this.keteranganStyle}>Belakang : {this.getLabelCategory(selected.belakang.id, selected.belakang.text)}</p>
                        </div>
                        {selected.gigi == '-'?null:
                        <div style={this.containerActionStyle}>
                            Pilih Bagian : 
                            <select onChange={this.handleChangeDetail} className="form-control" name="bagian">
                                <option value="block">Semua Bagian</option>
                                <option value="depan">Depan</option>
                                <option value="kiri">Kiri</option>
                                <option value="tengah">Tengah</option>
                                <option value="kanan">Kanan</option>
                                <option value="belakang">Belakang</option>
                            </select>
                            
                            Pilih Kategori : 
                            <select onChange={this.handleChangeDetail} name="kategori" className="form-control">
                                <option value="normal">Normal</option>
                                <option value="belum_erupsi">Belum Erupsi</option>
                                <option value="sudah_dicabut">Sudah Dicabut</option>
                                <option value="sudah_goyah">Sudah Goyah</option>
                                <option value="tambalan">Tambalan</option>
                                <option value="karies">Karies</option>
                                <option value="gigi_tiruan">Gigi Tiruan</option>
                                <option value="gigi_sehat">Gigi Sehat</option>
                                <option value="none">---</option>
                            </select>

                            <button onClick={this.handleSave} className="btn btn-dark">Simpan</button>
                        </div>
                        }
                        <div style={this.containerLegendStyle}>
                            <p style={this.keteranganHeaderStyle}>Legend</p>
                            <p style={this.getCategoryStyle('sudah_dicabut')} className="badge text-white">Sudah Dicabut</p>
                            <p style={this.getCategoryStyle('belum_erupsi')} className="badge text-white">Belum Erupsi</p>
                            <p style={this.getCategoryStyle('sudah_goyah')} className="badge text-white">Sudah Goyah</p>
                            <p style={this.getCategoryStyle('tambalan')} className="badge text-white">Tambalan</p>
                            <p style={this.getCategoryStyle('karies')} className="badge text-white">Karies</p>
                            <p style={this.getCategoryStyle('gigi_tiruan')} className="badge text-white">Gigi Tiruan</p>
                            <p style={this.getCategoryStyle('gigi_sehat')} className="badge text-white">Gigi Sehat</p>
                        </div>
                    </div>
                    <Container>
                        <DiagramContainer>
                            <LeftContainer>
                                {[18,17,16,15,14,13,12,11].map(v=>{
                                    return (
                                        <Gigi 
                                            onClick={this.handleClick} 
                                            depan={this.getGigi(v).depan.id}
                                            kiri={this.getGigi(v).kiri.id}
                                            tengah={this.getGigi(v).tengah.id}
                                            kanan={this.getGigi(v).kanan.id}
                                            belakang={this.getGigi(v).belakang.id}
                                            block={this.getGigi(v).block.id}
                                            gigi={v}
                                        />
                                    )
                                })}
                            </LeftContainer>
                            <RightContainer>
                                {[21,22,23,24,25,26,27,28].map(v=>{
                                    return (
                                        <Gigi 
                                            onClick={this.handleClick} 
                                            depan={this.getGigi(v).depan.id}
                                            kiri={this.getGigi(v).kiri.id}
                                            tengah={this.getGigi(v).tengah.id}
                                            kanan={this.getGigi(v).kanan.id}
                                            belakang={this.getGigi(v).belakang.id}
                                            block={this.getGigi(v).block.id}
                                            gigi={v}
                                        />
                                    )
                                })}
                            </RightContainer>
                            <LeftContainer>
                                {[55,54,53,52,51].map(v=>{
                                    return (
                                        <Gigi 
                                            onClick={this.handleClick} 
                                            depan={this.getGigi(v).depan.id}
                                            kiri={this.getGigi(v).kiri.id}
                                            tengah={this.getGigi(v).tengah.id}
                                            kanan={this.getGigi(v).kanan.id}
                                            belakang={this.getGigi(v).belakang.id}
                                            block={this.getGigi(v).block.id}
                                            gigi={v}
                                        />
                                    )
                                })}
                            </LeftContainer>
                            <RightContainer>
                                {[61,62,63,64,65].map(v=>{
                                    return (
                                        <Gigi 
                                            onClick={this.handleClick} 
                                            depan={this.getGigi(v).depan.id}
                                            kiri={this.getGigi(v).kiri.id}
                                            tengah={this.getGigi(v).tengah.id}
                                            kanan={this.getGigi(v).kanan.id}
                                            belakang={this.getGigi(v).belakang.id}
                                            block={this.getGigi(v).block.id}
                                            gigi={v}
                                        />
                                    )
                                })}
                            </RightContainer>
                            <LeftContainer>
                                {[85,84,83,82,81].map(v=>{
                                    return (
                                        <Gigi 
                                            onClick={this.handleClick} 
                                            depan={this.getGigi(v).depan.id}
                                            kiri={this.getGigi(v).kiri.id}
                                            tengah={this.getGigi(v).tengah.id}
                                            kanan={this.getGigi(v).kanan.id}
                                            belakang={this.getGigi(v).belakang.id}
                                            block={this.getGigi(v).block.id}
                                            gigi={v}
                                        />
                                    )
                                })}
                            </LeftContainer>
                            <RightContainer>
                                {[71,72,73,74,75].map(v=>{
                                    return (
                                        <Gigi 
                                            onClick={this.handleClick} 
                                            depan={this.getGigi(v).depan.id}
                                            kiri={this.getGigi(v).kiri.id}
                                            tengah={this.getGigi(v).tengah.id}
                                            kanan={this.getGigi(v).kanan.id}
                                            belakang={this.getGigi(v).belakang.id}
                                            block={this.getGigi(v).block.id}
                                            gigi={v}
                                        />
                                    )
                                })}
                            </RightContainer>
                            <LeftContainer>
                                {[48,47,46,45,44,43,42,41].map(v=>{
                                    return (
                                        <Gigi 
                                            onClick={this.handleClick} 
                                            depan={this.getGigi(v).depan.id}
                                            kiri={this.getGigi(v).kiri.id}
                                            tengah={this.getGigi(v).tengah.id}
                                            kanan={this.getGigi(v).kanan.id}
                                            belakang={this.getGigi(v).belakang.id}
                                            block={this.getGigi(v).block.id}
                                            gigi={v}
                                        />
                                    )
                                })}
                                
                            </LeftContainer>
                            <RightContainer>
                                {[31,32,33,34,35,36,37,38].map(v=>{
                                    return (
                                        <Gigi 
                                            onClick={this.handleClick} 
                                            depan={this.getGigi(v).depan.id}
                                            kiri={this.getGigi(v).kiri.id}
                                            tengah={this.getGigi(v).tengah.id}
                                            kanan={this.getGigi(v).kanan.id}
                                            belakang={this.getGigi(v).belakang.id}
                                            block={this.getGigi(v).block.id}
                                            gigi={v}
                                        />
                                    )
                                })}
                            </RightContainer>
                        </DiagramContainer>
                    </Container>
                </div>
            )
        }
    }
    ReactDOM.render(<App/>, document.getElementById('odontogram-diagram'))
</script>
@endsection