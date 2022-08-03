<!DOCTYPE html>
<html>
<head>
    <title>Data Parkir</title>
</head>
<body>
    <h3>DATA PARKIR</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tiket</th>
                <th>Jenis Kendaraan</th>
                <th>Plat Nomor</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Duration</th>
                <th>Tarif Parkir</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter=1;?>
            @foreach($model as $key => $value)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>{{ $value['kode_tiket'] }}</td>
                    <td>{{ $value['jenis_kendaraan'] }}</td>
                    <td>{{ $value['plat_no'] }}</td>
                    <td>{{ $value['jam_masuk'] }}</td>
                    <td>{{ $value['jam_keluar'] }}</td>
                    <td>{{ $value['duration'] }}</td>
                    <td>{{ $value['tarif_parkir'] }}</td>
                </tr>
                <?php $counter++;?>
            @endforeach
        </tbody>
    </table>
</body>
</html>