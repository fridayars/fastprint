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
        <img src="<?= base_url().'assets/template/'.$file_url ?>" alt="voucher_template" width="1080px"/>
        <div class="title">
            <h1><?= $nama ?></h1>
        </div>
        <div class="date">
            <h4><?= $exp_date ?></h5>
        </div>
        <div class="qrcode">
            <?php echo img(array('src' => site_url('Administrasi/Diskon/qrcode_template/' . $kode_voucher))); ?>
        </div>
        <div class="unduh-btn">
            <button type="button">Download</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/dist/js/canvas2image.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        document.querySelector('button').addEventListener('click', function() {
            $(".unduh-btn").hide()
            html2canvas(document.querySelector('.container'), {
                onrendered: function(canvas) {
                    /* download */
                    return Canvas2Image.saveAsPNG(canvas);
                }
            });
            setTimeout(() => {
                $(".unduh-btn").show()
            }, 3000);
        });
    </script>
</body>
</html>