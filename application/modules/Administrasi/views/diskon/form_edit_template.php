<section class="content">
    <!-- Horizontal Form -->
    <div class="card card-info">
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger" role="alert" id="error-alert" style="margin-bottom: 30px">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <span class="glyphicon glyphicon-exclamation-sign"></span>
                <strong>Failed! </strong> <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="card-header">
            <h3 class="card-title"><?= $title ?></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label for="kategori">Nama Template</label>
                    <input type="text" name="nama_template" required class="form-control" value="<?= $template['nama_template'] ?>">
                </div>
                <div class="form-group">
                    <label for="kategori">Gambar Template</label>
                    <input type="file" name="file_url" class="form-control" accept="image/png, image/jpeg, image/jpg" id="imgInp">
                    <code>max size 2mb, file accept : png, jpeg, jpg.</code>
                    <br>
                    <img id="blah" src="<?= base_url().'assets/template/'.$template['file_url'] ?>" alt="Preview Template" height="200px"/>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Edit Template</button>
                </div>
            </div>
            <!-- /.card-body -->
        </form>
    </div>
</section>
</div>
<script type="text/javascript">
    $(document).ready(function() {
		$("#error-alert").fadeTo(5000, 500).slideUp(500, function(){
            $("#error-alert").slideUp(500);
            <?php unset($_SESSION['error']) ?>
        });

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    });
</script>