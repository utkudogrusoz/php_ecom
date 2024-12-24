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

    public function register()
    {
        $userModel = new UserModel();

        $data = [
            'first_name' => $this->request->getVar('first_name'),
            'last_name' => $this->request->getVar('last_name'),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ];

        if ($userModel->where('email', $data['email'])->first()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Bu e-posta zaten kayıtlı.']);
        }

        $userModel->save($data);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Kayıt başarılı.']);
    }

    public function login()
    {
        $userModel = new UserModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session = session();
                $session->set('isLoggedIn', true);
                $session->set('user', $user);

                return $this->response->setJSON(['status' => 'success', 'message' => 'Giriş başarılı.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Hatalı şifre.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Kullanıcı bulunamadı.']);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to('/');
    }

    public function checkAuthStatus()
    {
        $session = session();
        $isLoggedIn = $session->get('isLoggedIn');
        $user = $session->get('user');

        return $this->response->setJSON([
            'isLoggedIn' => $isLoggedIn ? true : false,
            'user' => $isLoggedIn ? $user : null
        ]);
    }

}
