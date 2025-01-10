<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">

    <!-- Hata Mesajı (Stok yetersiz vb.) -->
    <?php if(session()->has('error')): ?>
        <div class="alert alert-danger">
            <?= session('error'); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($product) && $product): ?>
        <div class="row">
            <div class="col-md-6">
                <img
                        src="<?= base_url('/public/assets/images/').$product["image"] ?>"
                        class="img-fluid img-thumbnail"
                        alt="Ürün Görseli"
                        style="height: auto"
                >
            </div>
            <div class="col-md-6">
                <h3><?= esc($product['name']); ?></h3>
                <p>Fiyat: <?= esc($product['price']); ?> ₺</p>

                <?php if(!empty($variants)): ?>
                    <form action="<?= site_url('cart/add'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label for="variant_id" class="form-label">Beden / Numara</label>
                            <select name="variant_id" id="variant_id" class="form-select" required>
                                <?php foreach($variants as $v): ?>
                                    <option value="<?= $v['id']; ?>">
                                        <?= esc($v['variant_value']); ?>
                                        (Stok: <?= esc($v['stock']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Adet</label>
                            <input
                                    type="number"
                                    name="quantity"
                                    id="quantity"
                                    class="form-control"
                                    min="1"
                                    value="1"
                                    required
                            >
                        </div>

                        <button type="submit" class="btn btn-success">
                            Sepete Ekle
                        </button>

                        <?php if(session()->get('logged_in')): ?>
                            <?php if($favoriteId): ?>
                                <a
                                        href="<?= site_url('favorites/remove/'.$favoriteId); ?>"
                                        class="btn btn-danger"
                                >
                                    Favoriden Kaldır
                                </a>
                            <?php else: ?>
                                <a
                                        href="<?= site_url('favorites/add/'.$product['id']); ?>"
                                        class="btn btn-warning"
                                >
                                    Favoriye Ekle
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-muted">Favorilere eklemek için <a href="<?= site_url('login'); ?>">giriş yap</a>.</p>
                        <?php endif; ?>

                    </form>
                <?php else: ?>
                    <p>Bu ürün için beden/numara varyantı bulunmuyor.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <p>Ürün bulunamadı.</p>
    <?php endif; ?>

</div>

<?= $this->include('Layout/Footer'); ?>
