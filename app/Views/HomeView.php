<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <div class="row">
        <!-- Kategori Listesi -->
        <div class="col-md-3">
            <h4>Kategoriler</h4>
            <ul class="list-group">

                <!-- Tümü -->
                <li
                        class="list-group-item position-relative
            <?= empty($currentCategory) ? 'active' : '' ?>"
                >
                    <!-- Metin -->
                    Tümü
                    <!-- stretched-link: tüm liste öğesini tıklanabilir hale getirir -->
                    <a href="<?= site_url('/'); ?>"
                       class="stretched-link"
                       style="text-decoration: none; color: inherit;">
                    </a>
                </li>

                <!-- Diğer Kategoriler -->
                <?php if(!empty($categories)): ?>
                    <?php foreach($categories as $cat): ?>
                        <li
                                class="list-group-item position-relative
                <?= (isset($currentCategory) && $currentCategory == $cat['name']) ? 'active' : '' ?>"
                        >
                            <!-- Kategori adı (yazıyı direk koyuyoruz) -->
                            <?= esc($cat['name']); ?>

                            <!-- stretched-link, tüm <li> alanını link yapar -->
                            <a
                                    href="<?= site_url('category/'.$cat['id']); ?>"
                                    class="stretched-link"
                                    style="text-decoration: none; color: inherit;"
                            ></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>

            </ul>
        </div>

        <!-- Ürün Listeleme Alanı -->
        <div class="col-md-9">
            <?php if(!empty($currentCategory)): ?>
                <h2><?= esc($currentCategory); ?> Kategorisindeki Ürünler</h2>
            <?php else: ?>
                <h2>Tüm Ürünler</h2>
            <?php endif; ?>

            <div class="row mt-4">
                <?php if(!empty($products)): ?>
                    <?php foreach($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 position-relative">
                                <a style="color: inherit; text-decoration: none;"
                                        href="<?= site_url('product/'.$product['id']); ?>"
                                >  <img
                                        src="<?= base_url('/public/assets/images/').$product["image"] ?>"
                                        class="card-img-top"
                                        alt="Ürün Görseli"
                                >


                                <div class="card-body">
                                    <h5 class="card-title"><?= esc($product['name']); ?></h5>
                                    <p class="card-text">Fiyat: <?= esc($product['price']); ?> ₺</p>

                                </a>
                                </div>
                                <?php if(session()->get('logged_in')): ?>
                                    <?php if(isset($userFavorites[$product['id']])): ?>
                                        <!-- Favoriden Kaldır Butonu -->
                                        <a
                                                href="<?= site_url('favorites/remove/'.$userFavorites[$product['id']]); ?>"
                                                class="btn btn-danger btn-sm"
                                        >
                                            Favorilerden Kaldır
                                        </a>
                                    <?php else: ?>
                                        <!-- Favorilere Ekle Butonu -->
                                        <a
                                                href="<?= site_url('favorites/add/'.$product['id']); ?>"
                                                class="btn btn-warning btn-sm"
                                        >
                                            Favorilere Ekle
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="text-muted">
                                        Favorilere eklemek için
                                        <a href="<?= site_url('login'); ?>">giriş yap</a>.
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Bu kategoriye ait ürün bulunmuyor.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->include('Layout/Footer'); ?>
