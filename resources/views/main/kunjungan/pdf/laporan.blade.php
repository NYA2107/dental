<!DOCTYPE html>
<html>
<head>
<style>
*{
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #101A26;
  color: white;
}
</style>
</head>
<body>
<?php
    if (DateTime::createFromFormat('Y-m-d', $from) !== FALSE) {
        $from = date_format(date_create($from), 'd-m-Y');
        $to = date_format(date_create($to), 'd-m-Y');
    }
?>
<h1 style="text-align:center">Laporan Kunjungan Home Dental Care</h1>
<h3 style="text-align:center">{{$from}} Sampai {{$to}}</h1>
<table id="customers">
    <tr>
        <th><strong>No RM</strong></th>
        <th><strong>Nama</strong></th>
        <th><strong>Tindakan</strong></th>
        <th><strong>Tanggal</strong></th>
        <th><strong>Biaya</strong></th>
    </tr>
    @foreach($kunjungan as $v)
    <?php
        $tanggal = date_format(date_create($v->tanggal), 'd-m-Y');

    ?>
    <tr>
        <td>{{ $v->pasien->no_rekam_medis }}</td>
        <td>{{ $v->pasien->nama }}</td>
        <td>{{ $v->tindakan }}</td>
        <td>{{ $tanggal }}</td>
        <td>@currency($v->biaya)</td>
    </tr>
    @endforeach
</table>

<br>
<h4>Summary</h4>
<table id="customers">
    <tr>
        <th><strong>Total Kunjungan</strong></th>
        <th><strong>Total Pemasukan</strong></th>
    </tr>
    <tr>
        <td>{{ $totalKunjungan }}</td>
        <td>@currency($totalBiaya)</td>
    </tr>
</table>

</body>
</html>