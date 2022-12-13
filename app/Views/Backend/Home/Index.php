<?= $this->extend('Layout/Main') ?>
<?= $this->section('style') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?= $this->include('Layout/Nav') ?>
<div class="container mt-5 pt-5">
    <?php if (session()->getFlashdata('msg')) {
        echo showAlert(session()->getFlashdata('msg'), session()->getFlashdata('bg'));
    } ?>
    <div class="card p-4">
        Halaman Dashboard
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<?= script_tag("JS/Page/Login/Index.js") ?>
<?= $this->endSection() ?>