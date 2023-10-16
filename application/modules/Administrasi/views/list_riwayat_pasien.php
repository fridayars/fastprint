<section class="content">

    <!-- Default box -->
    <div class="card">
        <!-- ini tambahan -->

        <?php if (isset($_SESSION['logged_in'])){?>
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <a type="button" href="#" class="btn btn-block btn-warning btn-sm float-right">Print Riwayat</a>
                </div>

                <?php 
                $b = 'false';
                if (!($member == null || $member == '0')) {
                echo "
                <div class='col-md-3'>
                    <a type='button' target='_blank' href='". base_url()."Administrasi/Pasien/cetakKartuBaru/".$pasien['no_rm']."/".$b."' class='btn btn-block btn-success btn-sm float-right'>Cetak Kartu Depan</a>
                </div>
                <div class='col-md-3'>
                    <a type='button' target='_blank' href='".base_url() ."Administrasi/Pasien/cetakKartuDepan/' class='btn btn-block btn-success btn-sm float-right'>Cetak Kartu Belakang</a>
                </div>
                ";} elseif($member == null || $member == '0'){
                echo "
                <div class='col-md-3'>
                    <a type='button' target='_blank' href='".base_url() ."Administrasi/Pasien/cetakKartuBaru/". $pasien['no_rm']."/m_lama' class='btn btn-block btn-success btn-sm float-right'>Daftarkan Member</a>
                </div>
                ";} ?> 
            </div>
        </div>
        <?php }?>

    <!-- ini tambahan -->
        <table id="example1" class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <td>Nama Pasien</td>
                    <td><?= $pasien['no_rm'] ?> - <?= $pasien['nama'] ?> || (<?= $pasien['tempat_lahir'] ?>, <?= $pasien['tgl_lahir'] ?>)</td>
                </tr>
                <tr>
                    <td>No. ID</td>
                    <td><?= $pasien['ktp_passport'] ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Agama : <?= $pasien['agama'] ?> || Pekerjaan : <?= $pasien['pekerjaan'] ?> || Status Nikah : <?= $pasien['status_pernikahan'] ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?= $pasien['alamat'] . ', ' . $pasien['kota'] ?></td>
                </tr>
                <?php if($_SESSION['role_id'] == 3 || $_SESSION['toko_id'] == 99) { ?>
                    <tr>
                        <td>No. HP || Email</td>
                        <td><?= $pasien['no_hp'] . ' || ' . $pasien['email'] ?> </td>
                    </tr>    
                <?php } ?>
                <!-- ini tambahan -->

                <tr>
                    <td>Poin</td>
                    <td>
                        <?php if ($poin == 0 || $poin == '') {
                            echo ' 0 ';
                        } else {
                            echo $poin['point_treatment'] . " : Rp " . number_format($poin['point_treatment'] * 2500);
                        }?>
                    </td>
                </tr>

                <!-- ini tambahan -->
            </tbody>
        </table>
        <div class="card-header">
            <div class="row">
                <div class="col-md-3">
                    <a href="<?= site_url("Administrasi/Pasien/print_label/".$pasien['new_id']) ?>" class="btn btn-sm btn-primary btn-block" target="_blank" rel="noopener noreferrer">Print Label RM</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="kt_table_1" class="table table-striped- table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th>TGL</th>
                        <th>DOKTER</th>
                        <th>PERAWAT</th>
                        <th>TINDAKAN</th>
                        <th>OBAT</th>
                        <th>POIN</th>
                        <th>CATATAN</th>
                        <th>LOKASI PERIKSA</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- rm treatment migrasi -->
                    <?php
                    foreach ($arr_rm_treatment as $index => $value) {
                        $date = strtotime($value['created_at'])
                    ?>
                        <tr>
                            <td><?= date("Y-m-d", $date) ?></td>
                            <td><?= $value['nama_staff'] ?></td>
                            <td>-</td>
                            <td><?= $value['treatment_name'] ?></td>
                            <td></td>
                            <td> - </td>
                            <td><?= $value['checkup_notes'] ?></td>
                            <td><?php if($value['toko_id'] == 1){ echo "Klinik Malang";} elseif($value['toko_id'] == 2){ echo "Klinik Surabaya";} elseif($value['toko_id'] == 3){ echo "Klinik Bandung";} elseif($value['toko_id'] == 4){ echo "Klinik Sidoarjo";} elseif($value['toko_id'] == 5){ echo "Klinik Bekasi";} elseif($value['toko_id'] == 6){ echo "Klinik Medan";} elseif($value['toko_id'] == 7){ echo "Klinik Depok";}?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <!-- rm obat migrasi -->
                    <?php
                    foreach ($arr_rm_obat as $index => $value) {
                        $date = strtotime($value['created_at'])
                    ?>
                        <tr>
                            <td><?= date("Y-m-d", $date) ?></td>
                            <td>-</td>
                            <td>-</td>
                            <td></td>
                            <td><?= $value['medicine_name'] ?></td>
                            <td> - </td>
                            <td></td>
                            <td><?php if($value['toko_id'] == 1){ echo "Klinik Malang";} elseif($value['toko_id'] == 2){ echo "Klinik Surabaya";} elseif($value['toko_id'] == 3){ echo "Klinik Bandung";} elseif($value['toko_id'] == 4){ echo "Klinik Sidoarjo";} elseif($value['toko_id'] == 5){ echo "Klinik Bekasi";} elseif($value['toko_id'] == 6){ echo "Klinik Medan";} elseif($value['toko_id'] == 7){ echo "Klinik Depok";}?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <?php foreach ($arrpembayaran as $index => $value) { ?>
                        <tr>
                            <td><?= $value['tanggal'] ?></td>
                            <td><?=$value['dokter']?></td>
                            <td><?=$value['perawat']?></td>
                            <td><?php if (is_array(@$arrperawatan2[$value['id']]) || is_object(@$arrperawatan2[$value['id']]))
                                {
                                    foreach($arrperawatan2[$value['id']] as $index2 => $value2){ ?>
                                    - <?= $value2['nama']." x <b>".$value2['jumlah'].'</b><br>' ;?>
                                        <?php  }
                                } ?>
                                </td>    
                            <td><?php  if (is_array(@$arrpenjualan2[$value['id']]) || is_object(@$arrpenjualan2[$value['id']]))
			                        {
                                    foreach($arrpenjualan2[$value['id']] as $index2 => $value2){ ?>
                                    - <?= $value2['nama']." x <b>".$value2['jumlah'].'</b> ('. $value2['cara_pakai'] .')<br>' ;?>
                                        <?php  }
                                } ?>
                            </td>
                            <!-- ini tambahan -->

                            <td>
                            <?php if ($value['point_treatment'] == '' || $value['point_treatment'] == null) {
                                echo ' - ';
                            } else {
                               echo $value['point_treatment'];
                            }?>
                            </td>

                            <!-- ini tambahan -->    
                            <td>
                                <?= ($value['catatan'] != null && $value['catatan'] != '') ? '<b>catatan FO/kasir : </b> <br> '.$value['catatan'].' <br>' : '' ?>
                                <?= ($value['catatan_dokter'] != null && $value['catatan_dokter'] != '') ? '<b>catatan dokter : </b> <br> '.$value['catatan_dokter'].' <br>' : '' ?>
                                <?= ($value['masalah'] != null && $value['masalah'] != '') ? '<b>masalah : </b> <br> '.$value['masalah'].' <br>' : '' ?>
                                <?= ($value['alergi'] != null && $value['alergi'] != '') ? '<b>alergi : </b> <br> '.$value['alergi'].' <br>' : '' ?>
                            </td>
                            <td><?= 'KLINIK '. $value['toko']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
<script type="text/javascript">
    $(document).ready(function() {
        $('#kt_table_1').DataTable({
            "responsive": true,
            "autoWidth": false,
            stateSave: true,
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>
</div>