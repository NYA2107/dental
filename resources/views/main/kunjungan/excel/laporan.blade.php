<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    if (DateTime::createFromFormat('Y-m-d', $from) !== FALSE) {
        $from = date_format(date_create($from), 'd-m-Y');
        $to = date_format(date_create($to), 'd-m-Y');
    }
    
?>
<table>
    <thead>
        <tr>
            <th colspan="6" style="font-size:18pt; text-align:center;"><strong>Laporan Kunjungan Home Dental Care</strong></th>
        </tr>
        <tr>
            <th colspan="6" style="font-size:18pt; text-align:center;"><strong>Tanggal : {{$from}} sampai {{$to}}</strong></th>
        </tr>
        <tr>
            <th colspan="6" style="font-size:18pt; text-align:center;"><strong>Dokter : {{$dokter}}</strong></th>
        </tr>
    </thead>
</table>

<table>
    <thead>
        <tr>
            <th style="border:1px solid #000000"><strong>No RM</strong></th>
            <th style="border:1px solid #000000"><strong>Nama</strong></th>
            <th style="border:1px solid #000000"><strong>Diagnosa</strong></th>
            <th style="border:1px solid #000000"><strong>Tindakan</strong></th>
            <th style="border:1px solid #000000"><strong>Tanggal</strong></th>
            <th style="border:1px solid #000000"><strong>Biaya</strong></th>
        </tr>
    </thead>
    <tbody>
    @foreach($kunjungan as $v)
        <?php
            $tanggal = date_format(date_create($v->tanggal), 'd-m-Y');
        ?>
        <tr>
            <td style="border:1px solid #000000">{{ $v->pasien->no_rekam_medis }}</td>
            <td style="border:1px solid #000000">{{ $v->pasien->nama }}</td>
            <td style="border:1px solid #000000">{{ $v->diagnosa }}</td>
            <td style="border:1px solid #000000">{{ $v->tindakan }}</td>
            <td style="border:1px solid #000000">{{ $tanggal }}</td>
            <td style="border:1px solid #000000">{{ $v->biaya }}</td>
        </tr>
    @endforeach
        <tr>
        </tr>
        <tr>
            <td colspan="2"><strong>Summary</strong></td>
        </tr>
        <tr>
            <td style="border:1px solid #000000"><strong>Total Pemasukan</strong></td>
            <td style="border:1px solid #000000">{{$totalBiaya}}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000000"><strong>Total Kunjungan</strong></td>
            <td style="border:1px solid #000000">{{$totalKunjungan}}</td>
        </tr>
    </tbody>
</table>