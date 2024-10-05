<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        helper(["url", "form"]);
    }

    public function showRegisterPage()
    {
        return view('Auth/RegisterView');
    }

    public function showLoginPage()
    {
        return view('Auth/LoginView');
    }

    public function register()
    {
        $userModel = new UserModel();

        // Formdan gelen verileri kontrol edin
        $firstName = $this->request->getPost('first_name');
        $lastName = $this->request->getPost('last_name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($firstName)) {
            return redirect()->back()->with('error', 'İsim boş olamaz.');
        }

        $data = [
            'first_name'    => $firstName,
            'last_name'     => $lastName,
            'email'         => $email,
            'password' => $password
        ];

        // Veritabanına kaydetme
        if ($userModel->insert($data)) {
            return redirect()->to('/login')->with('message', 'Kullanıcı başarıyla oluşturuldu.');
        } else {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }


    // Kullanıcı giriş işlemi
    public function login()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // E-posta ile kullanıcıyı bulma
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // Şifreyi doğrulama
            if (password_verify($password, $user['password'])) {
                // Kullanıcıyı oturumda saklama
                session()->set([
                    'user_id'    => $user['id'],
                    'first_name' => $user['first_name'],
                    'is_logged_in' => true,
                ]);

                return redirect()->to('/dashboard')->with('message', 'Giriş başarılı.');
            } else {
                return redirect()->back()->with('error', 'Geçersiz şifre.');
            }
        } else {
            return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');
        }
    }

    // Oturumdan çıkış işlemi
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
