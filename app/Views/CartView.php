<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <h2>Sepetim</h2>

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

    <?php if(!empty($cartItems)): ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Varyant</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Toplam</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $grandTotal = 0;
            foreach($cartItems as $item):
                $subtotal = $item['product_price'] * $item['quantity'];
                $grandTotal += $subtotal;
                ?>
                <tr>
                    <td><?= esc($item['product_name']); ?></td>
                    <td><?= esc($item['variant_value']); ?></td>
                    <td><?= esc($item['quantity']); ?></td>
                    <td><?= esc($item['product_price']); ?> ₺</td>
                    <td><?= number_format($subtotal, 2); ?> ₺</td>
                    <td>
                        <a href="<?= site_url('cart/remove/'.$item['cart_id']); ?>" class="btn btn-danger btn-sm">
                            Kaldır
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="text-end"><strong>Genel Toplam:</strong></td>
                <td colspan="2"><strong><?= number_format($grandTotal, 2); ?> ₺</strong></td>
            </tr>
            </tbody>
        </table>

        <a href="<?= site_url('checkout'); ?>" class="btn btn-primary">Siparişi Tamamla</a>
    <?php else: ?>
        <p>Sepetiniz boş.</p>
    <?php endif; ?>
</div>

<?= $this->include('Layout/Footer'); ?>
