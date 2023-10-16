<!DOCTYPE html>
<html>
<head>
	<title>member card</title>
</head>
<style type="text/css">
	
* {
	margin: 0 auto;
    background-color: #1e1f24;
}

#container {
	height: 303px;
	width: 505px;
}

.qr{
	/* height: 49.5px;
    width: 50px;
    z-index: 1;
    display: block;
    margin-top: -87px;
    margin-left: 16px; */
    height: 125px;
    width: 126px;
    z-index: 1;
    display: block;
    margin-top: -244px;
    margin-left: 56px;
}

.belakang {
	/* height: 204px;
	width: 321px; */
    height: 638px;
	width: 1004px;
	z-index: 2;
    border-radius: 30px;
}

</style>
<body>
    <?php if($_SESSION['toko_id'] == 1){?>
	<img src="<?php echo base_url()?>assets/image/member_belakang.png" class="belakang">
    <?php echo "<img src='".base_url()."assets/image/ig_mlg.png' class='qr'>"; } elseif($_SESSION['toko_id'] == 2){?>
    <img src="<?php echo base_url()?>assets/image/member_belakang_sby.png" class="belakang">
    <?php echo "<img src='".base_url()."assets/image/ig_sby.png' class='qr'>"; } elseif($_SESSION['toko_id'] == 3){?>
    <img src="<?php echo base_url()?>assets/image/member_belakang_bdg.png" class="belakang">
    <?php echo "<img src='".base_url()."assets/image/ig_bdg.png' class='qr'>"; } elseif($_SESSION['toko_id'] == 4){?>
    <img src="<?php echo base_url()?>assets/image/member_belakang_sda.png" class="belakang">
    <?php echo "<img src='".base_url()."assets/image/ig_sda.png' class='qr'>"; } elseif($_SESSION['toko_id'] == 5){?>
    <img src="<?php echo base_url()?>assets/image/member_belakang_bks.png" class="belakang">
    <?php echo "<img src='".base_url()."assets/image/ig_bks.png' class='qr'>"; } elseif($_SESSION['toko_id'] == 6){?>
    <img src="<?php echo base_url()?>assets/image/member_belakang_mdn.png" class="belakang">
    <?php echo "<img src='".base_url()."assets/image/ig_mdn.png' class='qr'>"; } elseif($_SESSION['toko_id'] == 7){?>
    <img src="<?php echo base_url()?>assets/image/member_belakang_dpk.png" class="belakang">
    <?php echo "<img src='".base_url()."assets/image/ig_dpk.png' class='qr'>"; } elseif($_SESSION['toko_id'] == 8){?>
    <img src="<?php echo base_url()?>assets/image/member_belakang_ygk.jpg" class="belakang">
    <?php echo "<img src='".base_url()."assets/image/ig_ygk.png' class='qr'>"; }?>
</body>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script>
        $(document).ready(function() {
            // window.print();
        });
    </script>
</html>