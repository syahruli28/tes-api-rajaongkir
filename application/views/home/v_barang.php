<div class="container">
    <div class="row mt-5 mb-5">  
        <div class="col-md-12">
            <a href="<?= base_url();?>home/halamanKeranjang">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
            (<?= $this->cart->total_items();?>)                      
            </a>
        </div>
    </div>

    <div class="row">
        <?php foreach ($barang as $b) : ?>
        <div class="col-md-4">      
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="<?= base_url('assets/img/') . html_escape($b['gambar_barang']); ?>" alt="Card image cap" height="240">
                <div class="card-body">
                    <h5 class="card-title"><?= html_escape($b['nama_barang']);?></h5>
                    <p class="card-text text-muted"><?= "Rp " . number_format(html_escape($b['harga_barang']),0,'.','.') ;?></p>
                    <p class="card-text">NI kelinci bagus.</p>
                    <a href="<?= base_url();?>home/tambah_ke_keranjang/<?= $b['id_barang'];?>" class="btn btn-primary">Masukan ke keranjang</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>