<div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <h4 class="berita-text">Form Pemesanan</h4>
                <hr>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <!-- keranjang belanja -->
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th class="text-uppercase">No</th>
                        <th class="text-uppercase">Nama</th>
                        <th class="text-uppercase">Jumlah</th>
                        <th class="text-uppercase">Berat</th>
                        <th class="text-uppercase">Harga</th>
                        <th class="text-uppercase">Subtotal</th>
                        <!-- <th scope="col">Aksi</th> -->
                    </tr>
                    
                    <?php $no=1;$tot_berat=0;?>
                    <?php foreach($this->cart->contents() as $item ):?>
                    <?php 
                    $barang = $this->Barang_model->getBarangById($item['id']);
                    $berat = $item['qty'] * $barang['berat_barang'];
                    $tot_berat = $tot_berat + $berat;
                    ?>
                    <tr>
                        <td><?= $no++;?></td>
                        <td><?= $item['name'];?></td>
                        <td><?= $item['qty'];?></td>
                        <td><?= $barang['berat_barang'] * $item['qty'];?> Gram </td>
                        <td>Rp <?= number_format($item['price'],0,',','.') ;?></td>
                        <td>Rp <?= number_format($item['subtotal'],0,',','.');?></td>
                    </tr>
                    <?php endforeach;?>
                        
                </table>
                <!-- keranjang belanja -->
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-8">
            <?= form_open();?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <select id="provinsi" name="provinsi" class="form-control">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kota">Kota/Kabupaten</label>
                            <select id="kota" name="kota" class="form-control">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ekspedisi">Ekspedisi</label>
                            <select id="ekspedisi" name="ekspedisi" class="form-control">
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="paket">Paket</label>
                            <select id="paket" name="paket" class="form-control">
                            </select>
                        </div>
                    </div>
                <?= form_close();?>                            
                </div>
                
            </div>

            
            <div class="col-4">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Subtotal : </th>
                            <td>Rp. <?= number_format($this->cart->total(),0,',','.') ;?></td>
                        </tr>
                        <tr>
                            <th>Total Berat : </th>
                            <td><?= $tot_berat;?> Gram </td>
                        </tr>
                        <tr>
                            <th>Ongkir : </th>
                            <td><label id="ongkir"> - </label></td>
                        </tr>
                        <tr>
                            <th>Total Bayar : </th>
                            <td><label id="total_bayar"> - </label></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- <div class="col-md-4">
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
            </div> -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div align="right">
                    <a href="<?= base_url();?>home/halamanKeranjang" class="btn btn-sm btn-warning">Kembali ke keranjang belanja</a>
                    <a href="<?= base_url();?>home/halamanCheckout" class="btn btn-sm btn-primary">Checkout</a>
                </div>
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

        // lakukan perubahan setiap milih provinsi
        // memanggil data kota (API Rajaongkir)
        $("select[name=provinsi]").on("change", function(){
            var id_provinsi_terpilih = $("option:selected", this).attr("id_provinsi");

            $.ajax({
                type: "POST",
                url: "<?= base_url('rajaongkir/kota');?>",
                data: 'id_provinsi=' + id_provinsi_terpilih,
                success: function(hasil_kota){
                    // console.log(hasil_kota);
                    $("select[name=kota]").html(hasil_kota);
                }
            });
        });

        // lakukan perubahan setiap milih kota
        $("select[name=kota]").on("change", function(){
            $.ajax({
                type: "POST",
                url: "<?= base_url('rajaongkir/ekspedisi');?>",
                
                success: function(hasil_ekspedisi){
                    // console.log(hasil_kota);
                    $("select[name=ekspedisi]").html(hasil_ekspedisi);
                }
            });
        });

        // lakukan perubahan setiap milih ekspedisi
        $("select[name=ekspedisi]").on("change", function(){
            // dapatkan nama ekspedisi terpilih
            var namaEkspedisi = $("select[name=ekspedisi]").val();
            // dapatkan id kota terpilih
            var idKotaTerpilih = $("option:selected", "select[name=kota]").attr('id_kota');
            // dapatkan total berat
            var totalBerat = <?= $tot_berat;?>;
            // alert(totalBerat);
            $.ajax({
                type: "POST",
                url: "<?= base_url('rajaongkir/paket');?>",
                // kirimkan datanya (berat, idkota dll)
                data: 'dataekspedisi='+namaEkspedisi+'&datakota='+idKotaTerpilih+'&databerat='+totalBerat,
                success: function(hasil_paket){
                    // console.log(hasil_kota);
                    $("select[name=paket]").html(hasil_paket);
                }
            });
        });

        // lakukan perubahan setiap milih paket
        $("select[name=paket]").on("change", function(){
            // ambil total ongkir dari controller rajaongkir
            var hargaOngkir = $("option:selected", this).attr('ongkir');
            // format rupiah
            var reverse = hargaOngkir.toString().split('').reverse().join(''),
                rp_ongkir = reverse.match(/\d{1,3}/g);
                rp_ongkir = rp_ongkir.join(',').split('').reverse().join('');
            // ubah nilai id ongkir
            $("#ongkir").html("Rp. "+ rp_ongkir)

            // buat variabel total bayar dari penjumlahan harga ongkir dan harga belanja
            var toBayar = parseInt(hargaOngkir) + parseInt(<?= $this->cart->total();?>);
            // format rupiah
            var reverse2 = toBayar.toString().split('').reverse().join(''),
                rp_bayar = reverse2.match(/\d{1,3}/g);
                rp_bayar = rp_bayar.join(',').split('').reverse().join('');
            // ubah nilai id ongkir
            $("#total_bayar").html("Rp. "+ rp_bayar)
        });

    });
</script>