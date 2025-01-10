<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <h2>Sipariş Detayı (ID: <?= esc($order['id']); ?>)</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Sipariş Tarihi:</strong> <?= esc($order['created_at']); ?></p>
            <p><strong>Toplam Tutar:</strong> <?= number_format($order['total_amount'], 2); ?> ₺</p>
        </div>
    </div>

    <?php if(!empty($lineItems)): ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Beden / Numara</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Ara Toplam</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach($lineItems as $item):
                $subtotal = isset($item['subtotal']) ? $item['subtotal'] : 0;
                $total += $subtotal;
                ?>
                <tr>
                    <td><?= esc($item['product_name'] ?? ''); ?></td>
                    <td><?= esc($item['variant_value'] ?? ''); ?></td>
                    <td><?= esc($item['quantity'] ?? ''); ?></td>
                    <td><?= esc($item['unit_price'] ?? ''); ?> ₺</td>
                    <td><?= number_format($subtotal, 2); ?> ₺</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="text-end"><strong>Genel Toplam:</strong></td>
                <td><strong><?= number_format($total, 2); ?> ₺</strong></td>
            </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p>Kalem bilgisi bulunamadı.</p>
    <?php endif; ?>
</div>

<?= $this->include('Layout/Footer'); ?>
