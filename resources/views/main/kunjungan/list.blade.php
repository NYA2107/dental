@extends('../../dashboard')

@section('title')
    List Kunjungan
@endsection

@section('content')
@if(!$kunjungan->isEmpty())
<div class="card" style="margin-bottom:1em;">
    <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr auto">
            <div>
                <h4 class="card-title">Filter Kunjungan</h4>
                <h6 class="card-subtitle">Filter kunjungan berdasarkan range tanggal</h6>
            </div>
            <div>
                <a class="btn" href="{{route('kunjungan-list')}}"><span class="float-right"><i class="fas fa-undo"></i> Refresh</span></a>
            </div> 
        </div>
        <form method="get" action="{{route('kunjungan-filter')}}" enctype="multipart/form-data">
            <div style="display:grid;grid-template-columns:1fr 1fr;grid-gap:1em">
                <div style="grid-column:1/2">
                    <label class="form-control-label">Dari Tanggal</label>
                    <input type="date" value="{{$from??''}}" class="form-control" name="from">
                </div>
                <div style="grid-column:2/3">
                    <label class="form-control-label">Sampai Tanggal</label>
                    <input type="date" value="{{$to??''}}" class="form-control" name="to">
                </div>
                
            </div>
            <?php
                $id_dokter = $id_dokter??'SEMUA'
            ?>
            <div style="margin-top:1em">
                    <label for="dokter">Dokter</label>
                    <select class="form-control" name="id_dokter" id="dokter">
                        <option value="SEMUA">Semua</option>
                        @foreach($dokter as $o)
                            <?php
                            $selected = ''; 
                                if($id_dokter == $o->id){
                                    $selected = 'selected';
                                }else{
                                    $selected = '';
                                }
                            ?>
                            <option {{$selected}} value="{{$o->id}}">{{$o->nama}}</option>
                        @endforeach
                        
                    </select>
                </div>
            <div style="display:flex;justify-content:center;margin-top:1em;">
                <input type="submit" value="Set Filter" class="form-control btn waves-effect waves-light btn-dark">
            </div>
        </form>
    </div>
</div>
<div id="accordion" class="custom-accordion mb-4">
    <div class="card mb-0">
        <div class="card-header" id="headingOne">
            <h5 class="m-0">
                <a class="custom-accordion-title d-block pt-2 pb-2 collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Export <span class="float-right"><i class="mdi mdi-chevron-down accordion-arrow"></i></span>
                </a>
            </h5>
        </div>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
            <div class="card-body">
                <div style="display:grid;grid-template-columns:9em 9em 1fr 1fr 1fr;grid-gap:1em">
                    <form style="grid-column:1/2" method="post" action="{{route('kunjungan-excel')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="from" value="{{$from??''}}">
                        <input type="hidden" name="to" value="{{$to??''}}">
                        <input type="hidden" name="id_dokter" value="{{$id_dokter??''}}">
                        <input type="submit" class="btn btn-success text-white" value="Export to Excel">
                    </form>
                    <form style="grid-column:2/3" method="post" action="{{route('kunjungan-pdf')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="from" value="{{$from??''}}">
                        <input type="hidden" name="to" value="{{$to??''}}">
                        <input type="hidden" name="id_dokter" value="{{$id_dokter??''}}">
                        <input type="submit" class="btn btn-success text-white" value="Export to Pdf">
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end card-->
</div>  

<div class="card">
    <div class="card-body">
        <p>Dokter : <code>{{$id_dokter??'Semua'}}</code></p>
        <p>Menampilkan : <code>{{$totalKunjungan??''}}</code> Kunjungan</p>
        <p>Total Pemasukan : <code>@currency($totalBiaya)</code></p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr; grid-column-gap:1em;">
    @foreach($kunjungan??[] as $key => $v)
    <div class="card text-white bg-dark">
        <?php
            $tanggal = date_format(date_create($v->tanggal), 'd-m-Y');
        ?>
        <div class="card-header" style="display:grid;grid-template-columns:1fr auto;">
            <h4 class="mb-0 text-white">
                {{$v->pasien->no_rekam_medis}} - {{$v->pasien->nama}}
            </h4>
        </div>
        <div class="card-body">
            <p class="card-text m-0">Tanggal Kunjungan : <code>{{$tanggal}}</code></p>
            <p class="card-text m-0">Dokter : <code>{{$v->dokter->nama}}</code></p>
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
<div style="width:100%;display:flex;justify-content:center;">
    <a class="btn" href="{{route('kunjungan-list')}}"><span class="float-right"><i class="fas fa-undo"></i> Refresh</span></a>
</div>
@endif
</div>
@endsection