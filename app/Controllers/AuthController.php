<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{

    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new User();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan username, bukan email
        $user = $model->where('username', $username)->first();

        if ($user) {
            if ($password == $user->password) {
                $session->set([
                    'user_id' => $user->id,
                    'user_name' => $user->nama,
                    'user_username' => $user->username,
                    'user_role' => $user->role,
                    'isLoggedIn' => true
                ]);
                if ($user->role == 'anggota') {
                    return redirect()->to('presensi')->with('success', 'Login berhasil');
                }
                return redirect()->to('dashboard')->with('success', 'Login berhasil');
            } else {
                return redirect()->back()->with('error', 'Password salah');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
