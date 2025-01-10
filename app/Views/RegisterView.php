<?= $this->include('Layout/Header'); ?>
<?= $this->include('Layout/Navbar'); ?>

<div class="container mt-5">
    <h2>Kayıt Ol</h2>

    <!-- Form Validation Mesajları -->
    <?php if(isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors(); ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('register'); ?>" method="post">
        <?= csrf_field(); ?>

        <div class="mb-3">
            <label for="first_name" class="form-label">Ad</label>
            <input
                type="text"
                class="form-control"
                name="first_name"
                id="first_name"
                value="<?= old('first_name'); ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Soyad</label>
            <input
                type="text"
                class="form-control"
                name="last_name"
                id="last_name"
                value="<?= old('last_name'); ?>"
                required
            >
        </div>

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

        <button type="submit" class="btn btn-success">Kayıt Ol</button>
    </form>

    <p class="mt-3">
        Zaten hesabınız var mı? <a href="<?= site_url('login'); ?>">Giriş Yap</a>
    </p>
</div>

<?= $this->include('Layout/Footer'); ?>
