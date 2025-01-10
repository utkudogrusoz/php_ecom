<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <h2>Siparişlerim</h2>

    <?php if(session()->has('success')): ?>
        <div class="alert alert-success">
            <?= session('success'); ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($orders)): ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Sipariş ID</th>
                <th>Tarih</th>
                <th>Tutar</th>
                <th class="text-center">İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($orders as $order): ?>
                <tr>
                    <td><?= esc($order['id']); ?></td>
                    <td><?= esc($order['created_at']); ?></td>
                    <td><?= number_format($order['total_amount'], 2); ?> ₺</td>
                    <td class="text-center">
                        <a
                                href="<?= site_url('orders/detail/'.$order['id']); ?>"
                                class="btn btn-info btn-sm"
                        >
                            View Detail
                        </a>
                    </td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Henüz siparişiniz bulunmuyor.</p>
    <?php endif; ?>
</div>

<?= $this->include('Layout/Footer'); ?>
