<!DOCTYPE html>
<html>
<head>
	<title>member card</title>
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<style type="text/css">
	
* {
	margin: 0 auto;
    background-color: #1e1f24;
}

#container {
	height: 303px;
	width: 505px;
}

#no_m {
    display: block;
    margin-top: 57px;
    margin-left: 481px;
    font-weight: bold;
    letter-spacing: 6px;
    font-family: 'Montserrat', sans-serif;
    text-transform: uppercase;
    font-size: 23px;
    color: black;
}

#nama {
    display: block;
    margin-top: -115px;
    margin-left: 481px;
    font-weight: bold;
    letter-spacing: 2px;
    font-family: 'Montserrat', sans-serif;
    text-transform: uppercase;
    font-size: 23px;
    color: black;
}

.qr{
    /* height: 149.5px;
    width: 149px;
    z-index: 1;
    display: block;
    margin-top: -389px;
    margin-left: 807px; */

    height: 135.5px;
    width: 135px;
    z-index: 1;
    display: block;
    margin-top: -381.5px;
    margin-left: 813px;
}

.depan {
	/* height: 204px;
	width: 321px; */
    height: 638px;
	width: 1004px;
	z-index: 2;
    border-radius: 30px;
}

</style>
<body>
	<img src="<?php echo base_url()?>assets/image/member_depan.png" class="depan">
    <?php
        echo "<img src='".base_url()."assets/image/".$gambar."' class='qr'>";
    ?>
    <p id="nama"><?= $nama; ?></p>
    <p id="no_m"><?= $kode_member;?></p>
</body>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <?php if ($b == 'true') {
        echo '
        <script>
            $(document).ready(function() {
                window.open("'. base_url() .'Pembayaran_akun/table_lunas", "_blank", "toolbar=0,location=0,menubar=0");
            });
        </script>
        ';
    }elseif ($b == 'false') {
        echo '
        <script>
        </script>
        ';
    }?>
</html>