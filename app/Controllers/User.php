<?php

namespace App\Controllers;

use App\Models\BonusesModel;
use App\Models\UsersModel;
use App\Models\WorkersModel;

class User extends BaseController
{
    protected $users, $calc, $worker;
    function __construct()
    {
        $this->users = new UsersModel();
        $this->calc = new BonusesModel();
        $this->worker = new WorkersModel();
        helper('url');
        helper('date');
    }
    public function index()
    {
        menuPersmission('user', 'read');
        $s = [
            'name' => $this->request->getGet('name'),
            'username' => $this->request->getGet('username'),
            'role' => $this->request->getGet('role'),
            'status' => $this->request->getGet('status'),
            'updated_at' => $this->request->getGet('updated_at'),
            'orderBy' => $this->request->getGet('orderBy'),
            'orderSort' => $this->request->getGet('orderSort'),
        ];
        $data = [
            'title' => "Data Pengguna",
            'data' => $this->users->getData($s)->paginate(10, 'users'),
            'pager' => $this->users->pager,
            'no' => $this->request->getVar('page_users') ? $this->request->getVar('page_users') : 1,
        ];
        return view('Backend/User/Index', $data);
    }
    function create()
    {
        menuPersmission('user', 'create');
        $data = [
            'title' => 'Tambah Data Pengguna',
            'validation' => \Config\Services::validation(),
        ];
        return view('Backend/User/Create', $data);
    }
    function store()
    {
        menuPersmission('user', 'create');
        if (!$this->validate(
            [
                'nama' => 'required|max_length[100]|alpha_numeric_punct|is_unique[users.name]',
                'username' => 'required|max_length[100]|alpha_numeric_punct|is_unique[users.username]',
                'password' => 'required|valid_password',
                'publish' => 'required|in_list[true,false]',
                'peran' => 'required|in_list[1,2]',
            ]
        )) {
            return  redirect()->back()->withInput();
        }
        $slug = url_title($this->request->getPost('metode') . ' ' . strtotime(date('Y-m-d H:i:s')), '-', true);
        $data = [
            'name' => $this->request->getPost('nama'),
            'status' => trim($this->request->getPost('publish')),
            'username' => trim($this->request->getPost('username')),
            'password' => trim($this->request->getPost('password')),
            'role' => trim($this->request->getPost('peran')),
            'created_by' => session()->get('id'),
            'slug' => trim($slug),
        ];

        try {
            $this->users->save($data);
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', $th->getMessage());
            session()->setFlashdata('bg', 'alert-danger');
            return  redirect()->to(current_url() . '/create')->withInput();
        }
        session()->setFlashdata('msg', 'Data Pengguna <b>' . $data['name'] . '</b> Berhasil di Tambah');
        session()->setFlashdata('bg', 'alert-success');
        $btn = $this->request->getPost('savenewBtn') ? $this->request->getPost('savenewBtn') : $this->request->getPost('saveBtn');
        if ($btn == 'Simpan dan Tambah Baru') {
            return redirect()->to(current_url() . '/create');
        } else {
            return redirect()->to(current_url());
        }
    }
    function edit($slug)
    {
        menuPersmission('user', 'update');
        $data = [
            'title' => 'Tambah Data Pengguna',
            'validation' => \Config\Services::validation(),
            'data' => $this->users->where('slug', $slug)->first(),
        ];
        if (empty($data['data'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('Backend/User/Edit', $data);
    }
    function put($slug)
    {
        menuPersmission('user', 'update');
        $lama = $this->users->where('slug', $slug)->first();
        if (empty($lama)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        if ($lama['name'] === $this->request->getPost('nama')) {
            $nama = 'required|max_length[100]|alpha_numeric_punct';
        } else {
            $nama = 'required|is_unique[users.name]|max_length[100]|alpha_numeric_punct';
        }
        if ($lama['username'] === $this->request->getPost('username')) {
            $username = 'required|max_length[100]|alpha_numeric_punct';
        } else {
            $username = 'required|is_unique[users.username]|max_length[100]|alpha_numeric_punct';
        }
        $valid = [
            'nama' => $nama,
            'username' => $username,
            'publish' => 'required|in_list[true,false]',
            'peran' => 'required|in_list[1,2]',
        ];
        if (!empty($this->request->getPost('password'))) {
            $valid['password'] = 'required|valid_password';
        }

        if (!$this->validate($valid)) {
            return  redirect()->back()->withInput();
        }
        $slug = url_title($this->request->getPost('metode') . ' ' . strtotime(date('Y-m-d H:i:s')), '-', true);
        $data = [
            'id' => $lama['id'],
            'name' => $this->request->getPost('nama'),
            'status' => trim($this->request->getPost('publish')),
            'username' => trim($this->request->getPost('username')),
            'role' => trim($this->request->getPost('peran')),
            'updated_by' => session()->get('id'),
            'slug' => trim($slug),
        ];
        if (!empty($this->request->getPost('password'))) {
            $data['password'] = password_hash(trim($this->request->getPost('password')), PASSWORD_DEFAULT);
        }
        try {
            $this->users->save($data);
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', $th->getMessage());
            session()->setFlashdata('bg', 'alert-danger');
            return  redirect()->to(url('cancel') . '/create')->withInput();
        }
        session()->setFlashdata('msg', 'Data Pengguna <b>' . $data['name'] . '</b> Berhasil di Perbarui');
        session()->setFlashdata('bg', 'alert-success');
        $btn = $this->request->getPost('savenewBtn') ? $this->request->getPost('savenewBtn') : $this->request->getPost('saveBtn');
        if ($btn == 'Simpan dan Tambah Baru') {
            return redirect()->to(url('cancel') . '/create');
        } else {
            return redirect()->to(url('cancel'));
        }
    }
    function trash()
    {
        menuPersmission('user', 'delete');
        $row = $this->users->where('slug', $this->request->getPost('slug'))->first();
        if (empty($row)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        if ($row['id'] == 1) {
            session()->setFlashdata('msg', 'Data Pengguna <b>' . $row['name'] . '</b> Tidak di Izinkan di Hapus');
            session()->setFlashdata('bg', 'alert-danger');
        } else {
            try {
                $fk = $this->calc->where('created_by', $row['id'])->orWhere('updated_by', $row['id'])->first();
                $fk2 = $this->worker->where('created_by', $row['id'])->orWhere('updated_by', $row['id'])->first();
                if (!empty($fk) || !empty($fk2)) {
                    session()->setFlashdata('msg', 'Data Pengguna <b>' . $row['name'] . '</b> Tidak dapat di Hapus dikarenakan Data Masih digunakan');
                    session()->setFlashdata('bg', 'alert-danger');
                } else {
                    $this->users->delete($row['id'], true);
                    session()->setFlashdata('msg', 'Data Pengguna <b>' . $row['name'] . '</b> Berhasil di Hapus');
                    session()->setFlashdata('bg', 'alert-success');
                }
            } catch (\Throwable $th) {
                session()->setFlashdata('msg', $th->getMessage());
                session()->setFlashdata('bg', 'alert-danger');
            }
        }
        if (empty($this->request->getPost('ref')) || !filter_var($this->request->getPost('ref'), FILTER_VALIDATE_URL)) {
            return redirect()->to(current_url());
        } else {
            return redirect()->to($this->request->getPost('ref'));
        }
    }
    function status($slug)
    {
        if (empty($this->request->getGet('ref')) || !filter_var($this->request->getGet('ref'), FILTER_VALIDATE_URL)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        $data = $this->users->where('slug', $slug)->first();
        if ($data['id'] == 1) {
            session()->setFlashdata('msg', 'Data Pengguna <b>' . $data['name'] . '</b> Tidak di Izinkan di Non Aktifkan');
            session()->setFlashdata('bg', 'alert-danger');
        } else {
            try {
                $save['id'] = $data['id'];
                $save['status'] = $data['status'] === 'true' ? 'false' : 'true';
                $this->users->save($save);
            } catch (\Throwable $th) {
                session()->setFlashdata('msg', $th->getMessage());
                session()->setFlashdata('bg', 'alert-danger');
            }
            if ($save['status'] === 'true') {
                session()->setFlashdata('msg', 'Publis Data Pengguna <b>' . $data['name'] . '</b> Berhasil di Aktifkan');
                session()->setFlashdata('bg', 'alert-success');
            } else {
                session()->setFlashdata('msg', 'Publis Data Pengguna <b>' . $data['name'] . '</b> Berhasil di Matikan');
                session()->setFlashdata('bg', 'alert-success');
            }
        }
        return redirect()->to($this->request->getGet('ref'));
    }
}