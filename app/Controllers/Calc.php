<?php

namespace App\Controllers;

use App\Models\BonusesModel;
use App\Models\WorkersModel;

class Calc extends BaseController
{
    protected $calc, $worker;
    function __construct()
    {
        $this->calc = new BonusesModel();
        $this->worker = new WorkersModel();
        helper('url');
        helper('date');
    }
    public function index()
    {
        menuPersmission('bonuses', 'read');
        $s = [
            'updated_at' => $this->request->getGet('updated_at'),
            'total' => $this->request->getGet('total'),
            'orderBy' => $this->request->getGet('orderBy'),
            'orderSort' => $this->request->getGet('orderSort'),
        ];
        $data = [
            'title' => "Perhitungan Bonus",
            'data' => $this->calc->getData($s)->paginate(10, 'bonuses'),
            'pager' => $this->calc->pager,
            'no' => $this->request->getVar('page_bonuses') ? $this->request->getVar('page_bonuses') : 1,
        ];
        return view('Backend/Calc/Index', $data);
    }
    function create()
    {
        menuPersmission('bonuses', 'create');
        if (is_array(old('nama'))) {
            $worker = count(old('nama'));
        } else {
            $worker = 3;
        }
        $data = [
            'title' => 'Tambah Perhitungan Bonus',
            'validation' => \Config\Services::validation(),
            'worker' => $worker,
        ];
        return view('Backend/Calc/Create', $data);
    }
    function store()
    {
        menuPersmission('bonuses', 'create');

        $valid['pembayaran'] = ['label' => 'Total Pembayaran', 'rules' => 'required|integer|numeric|is_natural_no_zero'];
        if (is_array($this->request->getPost('nama'))) {
            foreach ($this->request->getPost('nama') as $k => $r) {
                $valid['nama.' . $k] = ['label' => "Nama Buruh", 'rules' => 'required|max_length[100]|alpha_numeric_punct|differs[nama]', 'errors' => ['differs' => "Terdapat Duplikat Nama pada Form"]];
                $valid['persen.' . $k] = ['label' => "Persentase", 'rules' => 'required|integer|numeric|is_natural_no_zero'];
            }
        }

        if (!$this->validate(
            $valid
        )) {
            return  redirect()->back()->withInput();
        }
        $slug = url_title(strtotime(date('Y-m-d H:i:s')), '-', true);

        $totalPersen = array_sum($this->request->getPost('persen'));
        if ($totalPersen < 100 || $totalPersen > 100) {
            session()->setFlashdata('msg', "Persen Pembagian Bonus di Tidak Valid");
            session()->setFlashdata('bg', 'alert-warning');
            return  redirect()->to(current_url() . '/create')->withInput();
        }
        foreach ($this->request->getPost('nama') as $k => $r) {
            $worker = $this->worker->select('id')->where('name', $r)->first();
            if (empty($worker)) {
                session()->setFlashdata('msg', "Nama Buruh " . $r . " Tidak di Temukan");
                session()->setFlashdata('bg', 'alert-warning');
                return  redirect()->to(current_url() . '/create')->withInput();
            }
            $data[$k] = [
                'id_worker' => $worker['id'],
                'percent' => trim($this->request->getPost('persen')[$k]),
                'result' => $this->request->getPost('pembayaran') * trim($this->request->getPost('persen')[$k]) / 100,
                'created_by' => session()->get('id'),
                'slug' => trim($slug),
            ];
        }
        try {
            $this->calc->insertBatch($data);
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', $th->getMessage());
            session()->setFlashdata('bg', 'alert-danger');
            return  redirect()->to(current_url() . '/create')->withInput();
        }
        session()->setFlashdata('msg', 'Perhitungan Bonus Berhasil di Tambah');
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
        menuPersmission('bonuses', 'update');
        $a = $this->calc->select('workers.name,bonuses.percent')->where('bonuses.slug', $slug)->join('workers', 'workers.id = bonuses.id_worker')->find();
        if (empty($a)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        if (is_array(old('nama'))) {
            $worker = count(old('nama'));
        } else {
            $worker = count($a);
        }
        $data = [
            'title' => 'Tambah Perhitungan Bonus',
            'validation' => \Config\Services::validation(),
            'data' => $a,
            'worker' => $worker,
            'total' => $this->calc->select('sum(result) as res')->where('slug', $slug)->first(),
        ];
        return view('Backend/Calc/Edit', $data);
    }
    function put($slug)
    {
        menuPersmission('bonuses', 'update');
        $lama = $this->calc->select('bonuses.id')->where('bonuses.slug', $slug)->join('workers', 'workers.id = bonuses.id_worker')->find();
        $valid['pembayaran'] = ['label' => 'Total Pembayaran', 'rules' => 'required|integer|numeric|is_natural_no_zero'];
        if (is_array($this->request->getPost('nama'))) {
            foreach ($this->request->getPost('nama') as $k => $r) {
                $valid['nama.' . $k] = ['label' => "Nama Buruh", 'rules' => 'required|max_length[100]|alpha_numeric_punct|differs[nama]', 'errors' => ['differs' => "Terdapat Duplikat Nama pada Form"]];
                $valid['persen.' . $k] = ['label' => "Persentase", 'rules' => 'required|integer|numeric|is_natural_no_zero'];
            }
        }
        if (!$this->validate(
            $valid
        )) {
            return  redirect()->back()->withInput();
        }
        $totalPersen = array_sum($this->request->getPost('persen'));
        if ($totalPersen < 100 || $totalPersen > 100) {
            session()->setFlashdata('msg', "Persen Pembagian Bonus di Tidak Valid");
            session()->setFlashdata('bg', 'alert-warning');
            return  redirect()->to(current_url())->withInput();
        }
        try {
            if (count($lama) > count($this->request->getPost('nama'))) {
                for ($a = count($lama); $a > count($this->request->getPost('nama')); $a--) {
                    $this->calc->delete($lama[$a - 1]['id']);
                }
            }
            foreach ($this->request->getPost('nama') as $k => $r) {
                $worker = $this->worker->select('id')->where('name', $r)->first();
                if (empty($worker)) {
                    session()->setFlashdata('msg', "Nama Buruh " . $r . " Tidak di Temukan");
                    session()->setFlashdata('bg', 'alert-warning');
                    return  redirect()->to(current_url())->withInput();
                }
                if ($k < count($lama)) {
                    $data = [
                        'id' => $lama[$k]['id'],
                        'id_worker' => $worker['id'],
                        'percent' => trim($this->request->getPost('persen')[$k]),
                        'result' => $this->request->getPost('pembayaran') * trim($this->request->getPost('persen')[$k]) / 100,
                        'created_by' => session()->get('id'),
                        'slug' => trim($slug),
                    ];
                } else {
                    $data = [
                        'id_worker' => $worker['id'],
                        'percent' => trim($this->request->getPost('persen')[$k]),
                        'result' => $this->request->getPost('pembayaran') * trim($this->request->getPost('persen')[$k]) / 100,
                        'created_by' => session()->get('id'),
                        'slug' => trim($slug),
                    ];
                }
                $this->calc->save($data);
                session()->setFlashdata('msg', 'Perhitungan Bonus Berhasil di Perbarui');
                session()->setFlashdata('bg', 'alert-success');
            }
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', $th->getMessage());
            session()->setFlashdata('bg', 'alert-danger');
            return  redirect()->to(current_url())->withInput();
        }
        $btn = $this->request->getPost('savenewBtn') ? $this->request->getPost('savenewBtn') : $this->request->getPost('saveBtn');
        if ($btn == 'Simpan dan Tambah Baru') {
            return redirect()->to(url('cancel') . '/create');
        } else {
            return redirect()->to(url('cancel'));
        }
    }
    function trash()
    {
        try {
            $row = $this->calc->where('slug', $this->request->getPost('slug'))->find();
            foreach ($row as $r) {
                $this->calc->delete($r, true);
            }
        } catch (\Throwable $th) {
            session()->setFlashdata('msg', $th->getMessage());
            session()->setFlashdata('bg', 'alert-danger');
        }
        session()->setFlashdata('msg', 'Perhitungan Bonus Berhasil di Hapus');
        session()->setFlashdata('bg', 'alert-success');
        if (empty($this->request->getPost('ref')) || !filter_var($this->request->getPost('ref'), FILTER_VALIDATE_URL)) {
            return redirect()->to(current_url());
        } else {
            return redirect()->to($this->request->getPost('ref'));
        }
    }

    function detail($slug)
    {
        return json_encode(
            [
                'data' => $this->calc->select('workers.name,bonuses.percent,bonuses.result,bonuses.slug')->where('bonuses.slug', $slug)->join('workers', 'workers.id = bonuses.id_worker')->find(),
                'total' => $this->calc->select('sum(result) as res')->where('slug', $slug)->first()['res'],
                'delete' => session()->get('role') == 2 ? true : false,
            ]
        );
    }
}