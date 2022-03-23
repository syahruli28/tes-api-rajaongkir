<div class="row mt-5">
    <div class="container">
        <div class="card">
            <h5 class="card-header mb-3">Setting Lokasi Toko</h5>

        <?= form_open();?>
        <?php foreach($toko as $t ):?>
        <div class="col-lg-12">
            <div class="form-group">
                <label for="namatoko">Nama Toko</label>
                <input type="text" name="namatoko" class="form-control" id="namatoko" value="<?= $t['nama_toko'];?>">
                <small class="form-text text-danger"><?= form_error('namatoko'); ?></small>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <select id="provinsi" name="provinsi" class="form-control">
                </select>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="lokasitoko">Lokasi Toko</label>
                <select id="lokasitoko" name="lokasitoko" class="form-control">
                    <option value="<?= $t['lokasi'];?>"><?= $t['lokasi'];?></option>
                </select>
                <small class="form-text text-danger"><?= form_error('lokasitoko'); ?></small>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="alamattoko">Alamat Toko</label>
                <input type="text" name="alamattoko" class="form-control" id="alamattoko" value="<?= $t['alamat_toko'];?>">
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label for="notelp">No. Telp Toko</label>
                <input type="text" name="notelp" class="form-control" id="notelp" value="<?= $t['no_telpon'];?>">
                <small class="form-text text-danger"><?= form_error('notelp'); ?></small>
            </div>
        </div>

        <div class="col-lg-12">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
        <?php endforeach;?>
        <?= form_close();?>
        </div>
    </div>
</div>

<script src="<?= base_url();?>assets/js/jquery-3.5.1.min.js"></script>
<script>
    
    $(document).ready(function(){

        // memanggil data provinsi (API Rajaongkir)
        $.ajax({
            type: "POST",
            url: "<?= base_url('rajaongkir/provinsi');?>",
            success: function(hasil_provinsi) {
                // console.log(hasil_provinsi);
                $("select[name=provinsi]").html(hasil_provinsi);
            }
        });

        // memanggil data kota (API Rajaongkir)
        $("select[name=provinsi]").on("change", function(){
            var id_provinsi_terpilih = $("option:selected", this).attr("id_provinsi");

            $.ajax({
                type: "POST",
                url: "<?= base_url('rajaongkir/kota');?>",
                data: 'id_provinsi=' + id_provinsi_terpilih,
                success: function(hasil_kota){
                    // console.log(hasil_kota);
                    $("select[name=lokasitoko]").html(hasil_kota);
                }
            });
        });
    });
</script>