<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function register()
    {
        // GET isteğinde kayıt formu gösterilir
        return view('RegisterView');
    }

    public function registerPost()
    {
        // POST isteğinden gelen form verisini işleyelim
        $rules = [
            'first_name' => 'required|min_length[2]',
            'last_name'  => 'required|min_length[2]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'password'   => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return view('RegisterView', [
                'validation' => $this->validator
            ]);
        }

        // Validasyon başarılı ise kullanıcı kaydını yap
        $userModel = new UserModel();
        $userModel->insert([
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            // Dikkat: Şifreyi düz (plain text) alıyoruz, Model içinde hash'lenecek
            'password'   => $this->request->getPost('password')
        ]);

        return redirect()->to('/login');
    }

    public function login()
    {
        // GET isteğinde login formu gösterilir
        return view('LoginView');
    }

    public function loginPost()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return view('LoginView', [
                'validation' => $this->validator
            ]);
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        // Veritabanındaki hash'lenmiş şifreyle karşılaştır
        if ($user && password_verify($password, $user['password'])) {
            // Oturum aç
            $this->session->set([
                'user_id'    => $user['id'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'email'      => $user['email'],
                'logged_in'  => true
            ]);

            return redirect()->to('/');
        } else {
            return view('LoginView', [
                'loginError' => 'Geçersiz e-posta veya şifre.'
            ]);
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }
}
