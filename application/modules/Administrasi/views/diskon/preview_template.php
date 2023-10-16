<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            justify-content: center;
        }
        .container {
            position: relative;
            width: 1080px;
        }
        .title {
            position: absolute;
            top: 165px;
            left: 53px;
            width: 550px;
            height: 110px;
            display: flex;
            align-items: center;
        }
        .date {
            position: absolute;
            top: 375px;
            left: 245px;
        }
        .qrcode {
            position: absolute;
            top: 300px;
            left: 975px;
        }
        .qrcode img {
            width: 75px;
        }
        .unduh-btn {
            position: absolute;
            top: 450px;
            left: 47%;
            text-align: center;
        }
        @media print
        {    
            .unduh-btn, .unduh-btn *
            {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="#" id="template" alt="voucher_template" width="1080px"/>
        <div class="title">
            <h1 id="title"></h1>
        </div>
        <div class="date">
            <h4 id="date"></h4>
        </div>
        <div class="qrcode">
            <?php echo img(array('src' => '#', 'id' => 'qrcode')); ?>
        </div>
        <div class="unduh-btn">
            <span>Jumlah file : </span><span id="count">0</span>
            <br><br>
            <button type="button" id="wait" disabled>Menyiapkan Paket...</button>
            <button type="button" id="download" style="display: none"><a href="<?= site_url('Administrasi/Diskon/download_zip').'/'.str_replace([' ','/'],'_',$voucher[0]['nama']) ?>" style="text-decoration:none; color:black">Paket Siap Diunduh!</a></button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/dist/js/canvas2image.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var data = <?= json_encode($voucher); ?>;
            $.each(data, function(i, val){
                $("#template").attr("src", "<?= base_url()."assets/template/" ?>"+val.file_url);
                $("#title").text(val.nama)
                $("#date").text(val.exp_date)
                $("#qrcode").attr("src", "<?= site_url('Administrasi/Diskon/qrcode_template') ?>"+"/"+val.kode_voucher);

                /* upload file */
                html2canvas(document.querySelector('.container'), {
                    onrendered: function(canvas) {
                        var imageDataURL = canvas.toDataURL();
                        var namaFile = val.kode_voucher+'_'+val.file_url;
                        $.ajax({
                            type: "POST",
                            url: "<?= site_url('Administrasi/Diskon/upload_image_voucher') ?>", 
                            data: {
                                image_data: imageDataURL, nama_file: namaFile
                            },
                            success: function(response) {
                                // Tanggapan dari server, lakukan sesuatu jika diperlukan
                                console.log(namaFile + " berhasil diunggah!");
                            },
                            error: function(xhr, status, error) {
                                // Tanggapan error dari server
                                console.log(namaFile + " gagal mengunggah : " + error);
                            }
                        });
                    }
                });
                $("#count").text(i+1)
            });
            window.addEventListener("load", function() {
                $("#download").css("display", "")
                $("#wait").css("display", "none")
            });
        });
    </script>
</body>
</html>