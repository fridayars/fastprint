<section class="content">

	<!-- Default box -->
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Settings</h3>

			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
					<i class="fas fa-minus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fas fa-times"></i></button>
			</div>
		</div>
		<div class="card-body">
            <form action="<?= site_url() . 'Api/Whatsapp/edit_settings/' . $api['id'] ?> ?>" method="post">
			<div class="mb-3 row">
                <div class="col-md-2">
                    <label for="exampleFormControlInput1" class="col-form-label">Access Token</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="<?= $api['access_token'] ?>" name="access_token" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-2">
                    <label for="exampleFormControlInput1" class="col-form-label">Channel ID</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="<?= $api['channel_id'] ?>" name="channel_id" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-2">
                    <label for="exampleFormControlInput1" class="col-form-label">Template ID</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" value="<?= $api['template_id'] ?>" name="template_id" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-block">SIMPAN</button>
                </div>
            </div>
            </form>
		</div>
		<div class="card-footer">

		</div>
	</div>

</section>
</div>