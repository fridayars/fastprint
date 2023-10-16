<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h5>Penyesuaian Stok Awal</h5>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Bulan</label>
                    <select name="bulan" id="pilihBulan" ng-model="cBulan" class="form-control">
                        <option></option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Tahun</label>
                    <select name="tahun" id="pilihTahun" class="form-control">
                        <option></option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Produk</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="id_barang" id="id_obat">
                        <?= $arrobat; ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>&nbsp;</label>
                    <button type="button" class="form-control btn btn-primary" onclick="FormEdit()">Cari Stok</button>
                </div>
            </div>
        </div>
        <div class="card-header" id="formEdit">
            
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Penyesuaian Stok Akhir</h5>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Produk</label>
                    <select class="form-control select2bs4" style="width: 100%;" name="id_barang" id="id_obat2">
                        <?= $arrobat; ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>&nbsp;</label>
                    <button type="button" class="form-control btn btn-primary" onclick="StokAkhir()">Cari Stok</button>
                </div>
            </div>
        </div>
        <div class="card-header" id="stokAkhir">
            
        </div>
    </div>

</section>
</div>

<script type="text/javascript">
    function FormEdit()
    {
        bulan = $('#pilihBulan').val()
        tahun = $('#pilihTahun').val()
        id_produk = $('#id_obat').val()
        $.ajax({
            type: "POST",
            data: "bulan=" + bulan +
            "&tahun=" + tahun +
            "&id_barang=" + id_produk,
            url: "<?php echo site_url('Administrasi/Stok_apotek/edit_stok') ?>",
            cache: false,
            success: function(msg) {
                $('#formEdit').html(msg);
            }
        });
    }

    function StokAkhir()
    {
        id_produk = $('#id_obat2').val()
        $.ajax({
            type: "POST",
            data: "id_barang=" + id_produk,
            url: "<?php echo site_url('Administrasi/Stok_apotek/edit_stok2') ?>",
            cache: false,
            success: function(msg) {
                $('#stokAkhir').html(msg);
            }
        });
    }
</script>