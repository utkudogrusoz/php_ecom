<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = $this->session->get('user_id');
        $data['user'] = $userModel->find($userId);

        return view('ProfileView', $data);
    }
}
