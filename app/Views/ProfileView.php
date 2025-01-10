<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <h2>Profilim</h2>

    <?php if(!empty($user)): ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <?= esc($user['first_name']) . ' ' . esc($user['last_name']); ?>
                </h5>
                <p class="card-text">
                    E-posta: <?= esc($user['email']); ?>
                </p>
                <p class="card-text">
                    Kayıt Tarihi: <?= esc($user['created_at'] ?? ''); ?>
                </p>
                <a href="<?= site_url('orders'); ?>" class="btn btn-primary">Siparişlerim</a>
            </div>
        </div>
    <?php else: ?>
        <p>Kullanıcı bilgileri bulunamadı.</p>
    <?php endif; ?>
</div>

<?= $this->include('Layout/Footer'); ?>
