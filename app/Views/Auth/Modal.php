<!-- Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Başlık -->
            <div class="modal-header">
                <h5 class="modal-title" id="authModalLabel">Giriş Yap veya Kayıt Ol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <!-- Modal İçerik -->
            <div class="modal-body">
                <!-- Sekme Başlıkları -->
                <ul class="nav nav-tabs" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginTabContent" type="button" role="tab" aria-controls="login" aria-selected="true">Giriş Yap</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerTabContent" type="button" role="tab" aria-controls="register" aria-selected="false">Kayıt Ol</button>
                    </li>
                </ul>
                <!-- Sekme İçerikleri -->
                <div class="tab-content mt-3" id="authTabContent">
                    <!-- Giriş Formu -->
                    <div class="tab-pane fade show active" id="loginTabContent" role="tabpanel" aria-labelledby="login-tab">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">E-posta:</label>
                                <input type="email" class="form-control" id="loginEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Şifre:</label>
                                <input type="password" class="form-control" id="loginPassword" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Giriş Yap</button>
                        </form>
                    </div>
                    <!-- Kayıt Formu -->
                    <div class="tab-pane fade" id="registerTabContent" role="tabpanel" aria-labelledby="register-tab">
                        <form id="registerForm">
                            <div class="mb-3">
                                <label for="registerFirstName" class="form-label">Ad:</label>
                                <input type="text" class="form-control" id="registerFirstName" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerLastName" class="form-label">Soyad:</label>
                                <input type="text" class="form-control" id="registerLastName" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerEmail" class="form-label">E-posta:</label>
                                <input type="email" class="form-control" id="registerEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label">Şifre:</label>
                                <input type="password" class="form-control" id="registerPassword" required>
                            </div>
                            <button type="submit" class="btn btn-success">Kayıt Ol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
