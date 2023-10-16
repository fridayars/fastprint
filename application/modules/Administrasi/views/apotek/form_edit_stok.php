<form action="<?= site_url() . 'Administrasi/Stok_apotek/edit_stok_awal/'.$row['id_stock'] ?>" method="post">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Nama Produk</label>
            <input class="form-control" type="text" name="input[nama]" readonly value="<?= $row['nama'] ?>">
        </div>
        <div class="form-group col-md-2">
            <label>Stok Awal</label>
            <input class="form-control" type="text" name="input[stok_awal]" readonly value="<?= $row['jumlah'] ?>">
        </div>
        <div>
            <label>&nbsp;</label><br>
            <label>-</label>
        </div>
        <div class="form-group col-md-2">
            <label>Pengurangan Stok</label>
            <input class="form-control" type="number" name="input[stok_edit]" value="" required>
        </div>
        <div class="form-group col-md-4">
            <label>Keterangan</label>
            <input class="form-control" type="text" name="input[keterangan]" value="" required>
        </div>
        <input class="form-control" type="hidden" name="input[id_barang]" value="<?= $row['id_barang'] ?>">
        <div class="form-group col-md">
            <label>&nbsp;</label>
            <button type="submit" class="form-control btn btn-warning">Edit Stok</button>
        </div>
    </div>
</form>
