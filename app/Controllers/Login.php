<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    protected $login;
    function __construct()
    {
        $this->login = new UsersModel();
    }
    public function index()
    {
        if (db_connect()->getDatabase() == '') {
            session()->setFlashdata('msg', 'Silahkan Lakukan Instalasi Terlebih Dahulu');
            session()->setFlashdata('bg', 'alert-warning');
            return redirect()->to(base_url() . '/install');
        };
        $data = [
            'title' => "Login",
            'validation' => \Config\Services::validation(),
        ];
        return view("Login/Index", $data);
    }
    function post()
    {
        if (!$this->validate(
            [
                'username' => "required",
                'password' => 'required',
            ]
        )) {
            return redirect()->to(base_url())->withInput();
        }
        $account = $this->login->where('username', $this->request->getPost('username'))->first();
        if (!empty($account)) {
            if (password_verify($this->request->getPost('password'), $account['password']) && $account['username'] === $this->request->getPost('username')) {
                if ($account['status'] == 'false') {
                    session()->setFlashdata('msg', 'Akun Anda di Bekukan, Mohon Hubungi Pihak Administrator');
                    session()->setFlashdata('bg', 'alert-danger');
                    return redirect()->to(base_url());
                } else {
                    $this->_loadSession($account);
                    if (!empty($this->request->getGet('ref')) && filter_var($this->request->getGet('ref'), FILTER_VALIDATE_URL)) {
                        return redirect()->to($this->request->getGet('ref'));
                    }
                    return redirect()->to(base_url() . '/home');
                }
            }
        }
        session()->setFlashdata('msg', 'Username atau Password Salah');
        session()->setFlashdata('bg', 'alert-danger');
        return redirect()->to(base_url())->withInput();
    }
    function _loadSession($data)
    {
        session()->set([
            'id' => $data['id'],
            'name' => $data['name'],
            'role' => $data['role'],
        ]);

        session()->setFlashdata('msg', 'Selamat Datang, <b>' . $data['name'] . '</b>');
        session()->setFlashdata('bg', 'alert-success');
    }
    function logout()
    {
        session()->remove(['id', 'name', 'role']);
        session()->setFlashdata('msg', 'Akun  Berhasil Keluar Dari Aplikasi');
        session()->setFlashdata('bg', 'alert-success');
        return redirect()->to(base_url());
    }
}