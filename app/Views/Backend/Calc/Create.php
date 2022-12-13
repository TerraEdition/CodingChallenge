<?= $this->extend('Layout/Main') ?>
<?= $this->section('style') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?= $this->include('Layout/Nav') ?>
<div class="container my-5 py-5">
    <div class="card p-4">
        <h3><?= $title ?></h3>
        <?php if (session()->getFlashdata('msg')) {
            echo showAlert(session()->getFlashdata('msg'), session()->getFlashdata('bg'));
        } ?>
        <form class="form form-vertical" action="<?= url('cancel') ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>
            <div class="card-header">
                <div class="btnHeader">
                    <div class="d-flex flex-wrap justify-content-between gap-2">
                        <div class="d-flex justify-content-start flex-wrap gap-2">
                            <?= saveBtn() ?>
                            <?= saveCreateBtn() ?>
                            <?= cancelBtn(force: true) ?>
                        </div>
                    </div>
                    <div class="progress h-100 mt-2">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <input type="number" class="form-control w-25"
                        placeholder="Masukkan Jumlah Buruh yang Ingin di Tambahkan" id="s">
                    <button class="btn btn-outline-primary" type="button" id="addWorker">Tambah Buruh</button>
                </div>
                <div class="form-group">
                    <label for="pembayaran">Pembayaran
                    </label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control  <?= validorno('pembayaran') ?>" name="pembayaran"
                            id="pembayaran" value="<?= old('pembayaran') ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= $validation->getError('pembayaran') ?>
                        </div>
                    </div>
                </div>
                <div id="notifSum" class="text-danger"></div>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Nama Buruh</td>
                            <td>Persen (%)</td>
                            <td>Hasil (Rp.)</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody id="listWorker">

                        <?php
                        for ($i = 0; $i < $worker; $i++) {
                        ?>
                        <tr>
                            <td>
                                <input type="text" class="form-control <?= validorno('nama.' . $i) ?>" name="nama[]"
                                    id="nama" value="<?= old('nama.' . $i) ?>" list="namaList<?= $i ?>">
                                <datalist id="namaList<?= $i ?>">
                                </datalist>
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= $validation->getError('nama.' . $i) ?>
                                </div>
                            </td>
                            <td>
                                <input type="number" class="form-control  <?= validorno('persen.' . $i) ?>"
                                    name="persen[]" id="persen" value="<?= old('persen.' . $i) ?>" min='0' max='100'>
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= $validation->getError('persen.' . $i) ?>
                                </div>
                            </td>
                            <td>

                            </td>
                            <td>
                                <?php
                                    if ($i > 2) { ?>
                                <button class="btn btn-outline-danger" type='button' id="removeWorker"><i
                                        class="fa-solid fa-trash"></i></button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="card-footer">
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= script_tag('JS/Form.js') ?>
<?= script_tag('JS/Page/Calc/Form.js') ?>
<?= $this->endSection() ?>