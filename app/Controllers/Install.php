<?php

namespace App\Controllers;

class Install extends BaseController
{
    public function index()
    {
        try {
            $xml = simplexml_load_file(APPPATH . "/../note.xml");
            if ($xml->install == 'false') {
                return redirect()->to(base_url());
            }
        } catch (\Throwable $th) {
            return redirect()->to(base_url());
        }
        $data = [
            'title' => "Install",
            'validation' => \Config\Services::validation(),
        ];
        return view('Install/Index', $data);
    }

    public function store()
    {

        if (!$this->validate(
            [
                'host' => 'required',
                'username' => 'required',
                'database' => 'required',
                'port' => 'required|integer|numeric',
            ]
        )) {
            return  redirect()->back()->withInput();
        }
        try {
            $con = mysqli_connect($this->request->getPost('host'), $this->request->getPost('username'), $this->request->getPost('password'));
            mysqli_query($con, 'CREATE DATABASE IF NOT EXISTS ' . $this->request->getPost('database'));
            $table = mysqli_query($con, 'SHOW TABLES FROM ' . $this->request->getPost('database'));
            if (mysqli_num_rows($table) > 0) {
                session()->setFlashdata('msg', 'Database sudah digunakan atau tidak kosong');
                session()->setFlashdata('bg', 'alert-danger');
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', 'Koneksi ke database tidak ditemukan');
            session()->setFlashdata('bg', 'alert-danger');
            return redirect()->back()->withInput();
        }
        try {
            $this->_write_env();
        } catch (\Throwable $e) {
            session()->setFlashdata('msg', 'Terjadi kesalahan file permission');
            session()->setFlashdata('bg', 'alert-danger');
            return redirect()->back()->withInput();
        }
        try {
            ini_set('max_execution_time', '0');
            ini_set('memory_limit', '-1');
            $migrate = \Config\Services::migrations();
            $migrate->latest();
            unlink(APPPATH . "/../note.xml");
        } catch (\Throwable $e) {
            session()->setFlashdata('msg', 'Terjadi Kesalahan Pada Saat Memuat Query, Mohon coba lagi');
            session()->setFlashdata('bg', 'alert-danger');
            return redirect()->back()->withInput();
        }
        session()->setFlashdata('msg', 'Instalasi Berhasil <ol><li>Administrtor : admin => 1122</li>
        <li>Regular User : user => 1122</li></ol>');
        session()->setFlashdata('bg', 'alert-success');
        return redirect()->to(base_url());
    }


    function _write_env()
    {
        $text = "
database.default.hostname = " .  $this->request->getPost('host') . "
database.default.database = " .  $this->request->getPost('database') . "
database.default.username = " .  $this->request->getPost('username') . "
database.default.password = " .  $this->request->getPost('password') . "
database.default.port = " .  $this->request->getPost('port') . "
database.default.DBDriver = MySQLi
";
        if (file_put_contents(APPPATH . '/../.env', $text)) {
            return true;
        } else {
            return false;
        };
    }
}