<?php

namespace App\Controllers;

use App\Models\BonusesModel;
use App\Models\WorkersModel;

class Worker extends BaseController
{
    protected $workers, $calc;
    function __construct()
    {
        $this->workers = new WorkersModel();
        $this->calc = new BonusesModel();
        helper('url');
        helper('date');
    }
    public function index()
    {
        menuPersmission('worker', 'read');
        $s = [
            'name' => $this->request->getGet('name'),
            'status' => $this->request->getGet('status'),
            'updated_at' => $this->request->getGet('updated_at'),
            'orderBy' => $this->request->getGet('orderBy'),
            'orderSort' => $this->request->getGet('orderSort'),
        ];
        $data = [
            'title' => "Data Buruh",
            'data' => $this->workers->getData($s)->paginate(10, 'workers'),
            'pager' => $this->workers->pager,
            'no' => $this->request->getVar('page_workers') ? $this->request->getVar('page_workers') : 1,
        ];
        return view('Backend/Worker/Index', $data);
    }
    function create()
    {
        menuPersmission('worker', 'create');
        $data = [
            'title' => 'Tambah Data Buruh',
            'validation' => \Config\Services::validation(),
        ];
        return view('Backend/Worker/Create', $data);
    }
    function store()
    {
        menuPersmission('worker', 'create');
        if (!$this->validate(
            [
                'nama' => 'required|max_length[100]|alpha_numeric_punct|is_unique[workers.name]',
                'publish' => 'required|in_list[true,false]',
            ]
        )) {
            return  redirect()->back()->withInput();
        }
        $slug = url_title($this->request->getPost('metode') . ' ' . strtotime(date('Y-m-d H:i:s')), '-', true);
        $data = [
            'name' => $this->request->getPost('nama'),
            'status' => trim($this->request->getPost('publish')),
            'created_by' => session()->get('id'),
            'slug' => trim($slug),
        ];

        try {
            $this->workers->save($data);
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', $th->getMessage());
            session()->setFlashdata('bg', 'alert-danger');
            return  redirect()->to(current_url() . '/create')->withInput();
        }
        session()->setFlashdata('msg', 'Data Buruh <b>' . $data['name'] . '</b> Berhasil di Tambah');
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
        menuPersmission('worker', 'update');
        $data = [
            'title' => 'Tambah Data Buruh',
            'validation' => \Config\Services::validation(),
            'data' => $this->workers->where('slug', $slug)->first(),
        ];
        if (empty($data['data'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('Backend/Worker/Edit', $data);
    }
    function put($slug)
    {
        menuPersmission('worker', 'update');
        $lama = $this->workers->where('slug', $slug)->first();
        if (empty($lama)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        if ($lama['name'] === $this->request->getPost('nama')) {
            $nama = 'required|max_length[100]|alpha_numeric_punct';
        } else {
            $nama = 'required|is_unique[workers.name]|max_length[100]|alpha_numeric_punct';
        }
        $valid = [
            'nama' => $nama,
            'publish' => 'required|in_list[true,false]',
        ];

        if (!$this->validate($valid)) {
            return  redirect()->back()->withInput();
        }
        $slug = url_title($this->request->getPost('metode') . ' ' . strtotime(date('Y-m-d H:i:s')), '-', true);
        $data = [
            'id' => $lama['id'],
            'name' => $this->request->getPost('nama'),
            'status' => trim($this->request->getPost('publish')),
            'updated_by' => session()->get('id'),
            'slug' => trim($slug),
        ];
        try {
            $this->workers->save($data);
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', $th->getMessage());
            session()->setFlashdata('bg', 'alert-danger');
            return  redirect()->to(url('cancel') . '/create')->withInput();
        }
        session()->setFlashdata('msg', 'Data Buruh <b>' . $data['name'] . '</b> Berhasil di Perbarui');
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
        menuPersmission('worker', 'delete');
        $row = $this->workers->where('slug', $this->request->getPost('slug'))->first();
        if (empty($row)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        if ($row['id'] == 1) {
            session()->setFlashdata('msg', 'Data Buruh <b>' . $row['name'] . '</b> Tidak di Izinkan di Hapus');
            session()->setFlashdata('bg', 'alert-danger');
        } else {
            try {
                $fk = $this->calc->where('id_worker', $row['id'])->first();
                if (!empty($fk)) {
                    session()->setFlashdata('msg', 'Data Buruh <b>' . $row['name'] . '</b> Tidak dapat di Hapus dikarenakan Data Masih digunakan');
                    session()->setFlashdata('bg', 'alert-danger');
                } else {
                    $this->workers->delete($row['id'], true);
                    session()->setFlashdata('msg', 'Data Buruh <b>' . $row['name'] . '</b> Berhasil di Hapus');
                    session()->setFlashdata('bg', 'alert-success');
                }
            } catch (\Throwable $th) {
                session()->setFlashdata('msg', 'Data tidak bisa dihapus : ' . $th->getMessage());
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
        $data = $this->workers->where('slug', $slug)->first();
        if ($data['id'] == 1) {
            session()->setFlashdata('msg', 'Data Buruh <b>' . $data['name'] . '</b> Tidak di Izinkan di Non Aktifkan');
            session()->setFlashdata('bg', 'alert-danger');
        } else {
            try {
                $save['id'] = $data['id'];
                $save['status'] = $data['status'] === 'true' ? 'false' : 'true';
                $this->workers->save($save);
            } catch (\Throwable $th) {
                session()->setFlashdata('msg', $th->getMessage());
                session()->setFlashdata('bg', 'alert-danger');
            }
            if ($save['status'] === 'true') {
                session()->setFlashdata('msg', 'Publis Data Buruh <b>' . $data['name'] . '</b> Berhasil di Aktifkan');
                session()->setFlashdata('bg', 'alert-success');
            } else {
                session()->setFlashdata('msg', 'Publis Data Buruh <b>' . $data['name'] . '</b> Berhasil di Matikan');
                session()->setFlashdata('bg', 'alert-success');
            }
        }
        return redirect()->to($this->request->getGet('ref'));
    }

    function exceptWorker()
    {
        $arr = explode(',', $this->request->getGet('worker'));

        return json_encode($this->workers->select('name')->whereNotIn('name', $arr)->where('status', 'true')->limit(10)->find());
    }
}