

document.addEventListener('DOMContentLoaded', function () {

    // Kullanıcı oturum durumunu kontrol et
    function checkAuth(callback) {
        fetch(BASE_URL + 'checkAuthStatus')
            .then(response => response.json())
            .then(data => {

                if (data.isLoggedIn) {
                    console.log(data.isLoggedIn);
                    // Kullanıcı giriş yapmışsa callback çalıştır
                    if (callback && typeof callback === 'function') {
                        callback();
                    }
                } else {
                    // Kullanıcı giriş yapmamışsa login popup aç
                    showLoginTab();
                }
            });
    }

    // Giriş Yap sekmesini göster
    function showLoginTab() {
        const loginTabTrigger = document.querySelector('#login-tab');
        const loginTab = new bootstrap.Tab(loginTabTrigger);
        loginTab.show();
        const authModalEl = document.getElementById('authModal');
        const authModal = new bootstrap.Modal(authModalEl);
        authModal.show();
    }

    // Sepete ekleme butonları
    document.querySelectorAll('.addToCart').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            checkAuth(() => {
                // Kullanıcı giriş yapmışsa sepete ekleme işlemini başlat
                alert('Ürün sepete eklendi! (Product ID: ' + productId + ')');
                // Burada sepete ekleme işlemi için fetch ile istek gönderebilirsiniz
            });
        });
    });
});
