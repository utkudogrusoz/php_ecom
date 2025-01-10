<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <h2>Favorilerim</h2>

    <?php if(session()->has('error')): ?>
        <div class="alert alert-danger">
            <?= session('error'); ?>
        </div>
    <?php endif; ?>

    <?php if(session()->has('success')): ?>
        <div class="alert alert-success">
            <?= session('success'); ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($favorites)): ?>
        <div class="row">
            <?php foreach($favorites as $fav): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img
                            src="<?= base_url('/public/assets/images/'.$fav['product_image']); ?>"
                            class="card-img-top"
                            alt="Ürün Görseli"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($fav['product_name']); ?></h5>
                            <p class="card-text">Fiyat: <?= esc($fav['product_price']); ?> ₺</p>
                        </div>
                        <div class="card-footer text-center">
                            <a
                                href="<?= site_url('favorites/remove/'.$fav['fav_id']); ?>"
                                class="btn btn-danger btn-sm"
                            >
                                Favoriden Kaldır
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Henüz favorilerinizde ürün bulunmuyor.</p>
    <?php endif; ?>
</div>

<?= $this->include('Layout/Footer'); ?>
