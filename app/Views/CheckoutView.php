<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <h2>Siparişi Tamamla</h2>

    <p>
        Ödeme ve teslimat bilgilerinizi girin (örnek sayfa).
        Normalde burada kredi kartı bilgileri, adres, fatura bilgisi vb. olabilir.
    </p>

    <!-- Örnek form -->
    <form action="<?= site_url('orders/complete'); ?>" method="post">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label for="address" class="form-label">Adres</label>
            <textarea
                class="form-control"
                name="address"
                id="address"
                rows="3"
                placeholder="Ör: İstanbul, Beşiktaş..."
                required
            ></textarea>
        </div>

        <div class="mb-3">
            <label for="payment_method" class="form-label">Ödeme Yöntemi</label>
            <select class="form-select" name="payment_method" id="payment_method">
                <option value="credit_card">Kredi Kartı</option>
                <option value="bank_transfer">Havale/EFT</option>
                <option value="cod">Kapıda Ödeme</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Onayla ve Siparişi Tamamla</button>
    </form>
</div>

<?= $this->include('Layout/Footer'); ?>
