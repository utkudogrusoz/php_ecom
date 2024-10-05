// public/assets/js/main.js

document.addEventListener('DOMContentLoaded', function() {
    // Navbar'daki butonlar
    var loginButton = document.getElementById('loginButton');
    var registerButton = document.getElementById('registerButton');
    var buyButton = document.getElementById('buyButton');
    var purchaseMessage = document.getElementById('purchaseMessage');

    // Modal ve sekme elemanları
    var authModalEl = document.getElementById('authModal');
    var authModal = new bootstrap.Modal(authModalEl);

    // CSRF token'ını meta etiketinden al
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Kullanıcı oturum durumunu kontrol et
    function checkAuthStatus() {
        // Oturum kontrolü için sunucuya istek atacağız
        fetch('/codeigniter/checkAuthStatus')
            .then(response => response.json())
            .then(data => {
                if (data.isLoggedIn) {
                    // Kullanıcı giriş yapmışsa
                    loginButton.textContent = 'Çıkış Yap';
                    loginButton.onclick = logout;
                    registerButton.style.display = 'none';
                } else {
                    // Kullanıcı giriş yapmamışsa
                    loginButton.textContent = 'Giriş Yap';
                    loginButton.onclick = showLoginTab;
                    registerButton.style.display = 'block';
                    registerButton.onclick = showRegisterTab;
                }
            });
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
        fetch('/codeigniter/logout')
            .then(() => {
                checkAuthStatus();
            });
    }

    // Giriş formu işlemleri
    var loginForm = document.getElementById('loginForm');
    var loginError = document.getElementById('loginError');

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(loginForm);
        console.log(formData)

        fetch('/codeigniter/login', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    checkAuthStatus();
                    authModal.hide();
                    loginError.textContent = '';
                } else {
                    loginError.textContent = data.message;
                }
            });
    });

    // Kayıt formu işlemleri
    var registerForm = document.getElementById('registerForm');
    var registerError = document.getElementById('registerError');

    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(registerForm);

        fetch('/codeigniter/register', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    checkAuthStatus();
                    authModal.hide();
                    registerError.textContent = '';
                } else {
                    registerError.textContent = data.message;
                }
            });
    });

    // Satın al butonu işlemleri
    buyButton.addEventListener('click', function() {
        fetch('/codeigniter/checkAuthStatus')
            .then(response => response.json())
            .then(data => {
                if (data.isLoggedIn) {
                    // Satın alma işlemini gerçekleştirin
                    purchaseMessage.textContent = 'Satın alındı!';
                } else {
                    showLoginTab(); // Giriş Yap sekmesini aç
                }
            });
    });

    // Sayfa yüklendiğinde oturum durumunu kontrol et
    checkAuthStatus();
});
