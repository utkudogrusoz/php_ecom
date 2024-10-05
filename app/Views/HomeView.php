<?= $this->include('Layout/Header') ?>

<?= $this->include('Layout/Navbar') ?>

<div class="container mt-5">
    <h1>Hoş Geldiniz!</h1>
    <button id="buyButton" class="btn btn-primary">Satın Al</button>
    <p id="purchaseMessage" class="mt-3"></p>
</div>


<!-- Giriş ve Kayıt Modali -->
<?= $this->include('Auth/Modal') ?>

<?= $this->include('Layout/Footer') ?>
