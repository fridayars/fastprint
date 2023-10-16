<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .flex{
            display:flex;
            justify-content:center;
            align-items:center;
        }
        @page {
            margin: 0;
        }
        body{
            margin: 0;
        }
        th {
        vertical-align: top;
        text-align: left;
        padding:2px;
        }
        table{
            padding:0;
        }
        img{
            width: 50px;
        }
    </style>
</head>
<body>
    <div class="flex">
        <table style="width:350px; border: 0px solid; font-size:12px; height:180px">
            <tr style="font-size:18px !important;">
                <th width="70px" style="vertical-align: middle">NO. RM</th>
                <th style="vertical-align: middle">:</th>
                <th style="vertical-align: middle"><?= $pasien['no_rm'] ?>
                </th style="vertical-align: middle">
                <th style="padding: 0 !important; vertical-align: middle; text-align: right">
                    <?php echo img(array('src' => site_url('Administrasi/Pasien/qrcode_label/' . $pasien['no_rm']))); ?>
                </th>
            </tr>
            <tr>
                <th>NAMA</th>
                <th>:</th>
                <th colspan="2"><?= $pasien['nama'] ?></th>
            </tr>
            <tr>
                <th>NO. ID</th>
                <th>:</th>
                <th colspan="2"><?= $pasien['ktp_passport'] ?></th>
            </tr>
            <tr>
                <th>TTL</th>
                <th>:</th>
                <th colspan="2"><?= $pasien['tempat_lahir'] ?>, <?= date("d-m-Y", strtotime($pasien['tgl_lahir'])); ?> (<?= $y ?><sup>th</sup>, <?= $m ?><sup>bl</sup>) <?= $pasien['jenis_kelamin'] ?></th>
            </tr>
            <tr>
                <th>ALAMAT</th>
                <th>:</th>
                <th colspan="2" style="font-size:10px"><?= $pasien['alamat'] . ", ". $desa . ", " . $kecamatan . ", " . $kabkota . ", " . $provinsi ?></th>
            </tr>
        </table>
    </div>
</body>
</html>
<script>
    window.print()
</script>