<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Sol taraf: Sayfa İsmi -->
        <a class="navbar-brand" href="<?= site_url('/'); ?>"><img src="<?= base_url('/public/assets/images/logo.png'); ?>"
                                                                  width="150" height="150" alt=""></a>

        <!-- Mobil menü için buton -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Sağ tarafa hizalanan menü -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> <!-- Sağ tarafa hizalama -->
                <?php if (session()->get('logged_in')): ?>
                    <!-- Sepetim -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('cart'); ?>">Sepetim</a>
                    </li>

                    <!-- Hesabım Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hesabım
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="<?= site_url('profile'); ?>">Profilim</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('orders'); ?>">Siparişlerim</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('favorites'); ?>">Favorilerim</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('logout'); ?>">Çıkış Yap</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Giriş Yap ve Kayıt Ol -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('login'); ?>">Giriş Yap</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('register'); ?>">Kayıt Ol</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
