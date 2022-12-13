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
        <form class="form form-vertical" action="<?= url('cancel') ?>" method="post">
            <?= csrf_field() ?>
            <div class="card-header">
                <div class="btnHeader">
                    <div class="d-flex flex-wrap justify-content-between">
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
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-9 mb-3">
                        <div class="form-group">
                            <label for="nama">Nama <?= symRequired(1) ?>
                            </label>
                            <input type="text" id="nama" class="form-control <?= validorno('nama') ?>"
                                value="<?= old('nama') ?>" name="nama">
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                <?= $validation->getError('nama') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-3">
                        <?= box_publish(old('publish', 'true')) ?>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= script_tag('JS/Form.js') ?>
<?= $this->endSection() ?>