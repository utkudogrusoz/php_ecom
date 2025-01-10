<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <h2>Giriş Yap</h2>

    <!-- Hata mesajı -->
    <?php if(isset($loginError)): ?>
        <div class="alert alert-danger">
            <?= esc($loginError); ?>
        </div>
    <?php endif; ?>

    <!-- Form Validation Mesajları -->
    <?php if(isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors(); ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('login'); ?>" method="post">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label for="email" class="form-label">E-posta</label>
            <input
                type="email"
                class="form-control"
                name="email"
                id="email"
                value="<?= old('email'); ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Şifre</label>
            <input
                type="password"
                class="form-control"
                name="password"
                id="password"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">Giriş Yap</button>
    </form>

    <p class="mt-3">
        Hesabınız yok mu? <a href="<?= site_url('register'); ?>">Kayıt Ol</a>
    </p>
</div>

<?= $this->include('Layout/Footer'); ?>
