document.addEventListener('DOMContentLoaded', function() {
    // Navbar'daki butonlar
    var loginButton = document.getElementById('loginButton');
    var registerButton = document.getElementById('registerButton');
    var buyButton = document.getElementById('buyButton');
    var purchaseMessage = document.getElementById('purchaseMessage');

    // Modal ve sekme elemanları
    var authModalEl = document.getElementById('authModal');
    var authModal = new bootstrap.Modal(authModalEl);

    // Kullanıcı oturum durumunu kontrol et
    function checkAuthStatus() {
        if (localStorage.getItem('isLoggedIn')) {
            // Kullanıcı giriş yapmışsa
            loginButton.textContent = 'Çıkış Yap';
            loginButton.onclick = logout;
            registerButton.style.display = 'none'; // Kayıt Ol butonunu gizle
        } else {
            // Kullanıcı giriş yapmamışsa
            loginButton.textContent = 'Giriş Yap';
            loginButton.onclick = showLoginTab;
            registerButton.style.display = 'block';
            registerButton.onclick = showRegisterTab;
        }
    }

    // Satın alma durumunu kontrol et
    function checkPurchaseStatus() {
        if (localStorage.getItem('isPurchased')) {
            purchaseMessage.textContent = 'Satın Alındı';
        } else {
            purchaseMessage.textContent = '';
        }
    }

    // Giriş Yap sekmesini göster
    function showLoginTab() {
        var loginTabTrigger = document.querySelector('#login-tab');
        var loginTab = new bootstrap.Tab(loginTabTrigger);
        loginTab.show();
        authModal.show();
    }

    // Kayıt Ol sekmesini göster
    function showRegisterTab() {
        var registerTabTrigger = document.querySelector('#register-tab');
        var registerTab = new bootstrap.Tab(registerTabTrigger);
        registerTab.show();
        authModal.show();
    }

    // Çıkış yap fonksiyonu
    function logout() {
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('isPurchased');
        checkAuthStatus();
        checkPurchaseStatus();
        // alert('Çıkış yaptınız.'); // Mesajı kaldırdık
    }

    // Giriş formu işlemleri
    var loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Basit bir doğrulama (gerçek uygulamada sunucu doğrulaması gerekir)
        var email = document.getElementById('loginEmail').value;
        var password = document.getElementById('loginPassword').value;

        if (email && password) {
            localStorage.setItem('isLoggedIn', true);
            checkAuthStatus();
            authModal.hide();
            // alert('Giriş başarılı.'); // Mesajı kaldırdık
        } else {
            alert('E-posta ve şifre gereklidir.');
        }
    });

    // Kayıt formu işlemleri
    var registerForm = document.getElementById('registerForm');
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Basit bir kayıt işlemi (gerçek uygulamada sunucuya kayıt gerekir)
        var firstName = document.getElementById('registerFirstName').value;
        var lastName = document.getElementById('registerLastName').value;
        var email = document.getElementById('registerEmail').value;
        var password = document.getElementById('registerPassword').value;

        if (firstName && lastName && email && password) {
            localStorage.setItem('isLoggedIn', true);
            checkAuthStatus();
            authModal.hide();
            // alert('Kayıt ve giriş başarılı.'); // Mesajı kaldırdık
        } else {
            alert('Tüm alanlar gereklidir.');
        }
    });

    // Satın al butonu işlemleri
    buyButton.addEventListener('click', function() {
        if (localStorage.getItem('isLoggedIn')) {
            localStorage.setItem('isPurchased', true);
            checkPurchaseStatus();
            // alert('Ürün satın alındı.'); // Mesajı kaldırdık
        } else {
            showLoginTab(); // Giriş Yap sekmesini aç
        }
    });

    // Sayfa yüklendiğinde oturum ve satın alma durumunu kontrol et
    checkAuthStatus();
    checkPurchaseStatus();
});
