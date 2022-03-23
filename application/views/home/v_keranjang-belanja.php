<div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <h4 class="berita-text">Keranjang Belanja Anda</h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- keranjang belanja -->
                <?php echo form_open('Home/updatecart'); ?>
                <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <th class="text-uppercase" width="75px">Jumlah</th>
                            <th class="text-uppercase">Nama</th>
                            <th class="text-uppercase">Berat</th>
                            <th class="text-uppercase">Harga</th>
                            <th class="text-uppercase">Sub Total</th>
                            <th class="text-uppercase">Opsi</th>
                            <!-- <th scope="col">Aksi</th> -->
                        </tr>

                        <?php $i = 1; ?>
                        <?php foreach($this->cart->contents() as $item ):?>
                        <?php $barang = $this->Barang_model->getBarangById($item['id']);?>
                        
                        <tr>
                            <td>
                                <?php 
                                echo form_input(array(
                                    'name' => $i . '[qty]',
                                    'value' => $item['qty'],
                                    'maxlength' => '3',
                                    'min' => '0',
                                    'size' => '5',
                                    'type' => 'number',
                                    'class' => 'form-control'
                                ));
                                ?>
                            </td>
                            <td><?= $item['name'];?></td>
                            <td><?= $barang['berat_barang']* $item['qty'];?> Gram</td>
                            <td>Rp <?= number_format($item['price'],0,',','.') ;?></td>
                            <td>Rp <?= number_format($item['price'] * $item['qty'],0,',','.') ;?></td>
                            <!-- rowid udah pasti ada -->
                            <td><a href="<?= base_url('Home/hapussb/'. $item['rowid']);?>">Hapus</a></td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach;?>
                        
                        <tr>
                            <td colspan="4" class="text-uppercase">Jumlah total</td>
                            <td>Rp <?= number_format($this->cart->total(),0,',','.') ;?></td>
                            <td></td>
                        </tr>
                </table>
                <button type="submit" class="btn btn-primary btn-flat mb-3">Update Keranjang</button>
                <?= form_close(); ?>
                <!-- keranjang belanja -->
            </div>
        </div>
        
        <?php if($this->cart->total_items() == '0'):?>
            <div class="alert alert-danger">
                <p>Keranjang belanja Anda masih kosong.</p>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <p>* Pemesanan pada Rafa Rabbit's Pet Shop hanya berlaku untuk wilayah JABODETABEK.</p>
            </div>
        <?php endif;?>
        

        <div align="right">
            <?php if($this->cart->total_items() == '0'):?>
                <button onclick="alert('Keranjang belanja Anda masih kosong.')" class="btn btn-sm btn-danger">Hapus Keranjang</button>
                    <button onclick="alert('Keranjang belanja Anda masih kosong.')" class="btn btn-sm btn-success">Pesan</button>
            <?php else: ?>
                    <a href="<?= base_url();?>home/hapusKeranjang" class="btn btn-sm btn-danger">Hapus Keranjang</a>
                    <a href="<?= base_url();?>home/formPemesanan" class="btn btn-sm btn-success">Pesan</a>
            <?php endif;?>        
        </div>

    </div>