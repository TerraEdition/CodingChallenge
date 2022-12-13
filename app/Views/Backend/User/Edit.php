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
        <form class="form form-vertical" action="<?= current_url() ?>" method="post" autocomplete="off">
            <?= csrf_field() ?>
            <input name="_method" value="PUT" type="hidden" />
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
                                value="<?= old('nama', $data['name']) ?>" name="nama">
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                <?= $validation->getError('nama') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">Username <?= symRequired(1) ?>
                            </label>
                            <input type="text" id="username" class="form-control <?= validorno('username') ?>"
                                value="<?= old('username', $data['username']) ?>" name="username">
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                <?= $validation->getError('username') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <?= symRequired(1) ?>
                            </label>
                            <input type="password" id="password" class="form-control <?= validorno('password') ?>"
                                value="<?= old('password') ?>" name="password">
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                <?= $validation->getError('password') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="peran">Peran <?= symRequired(1) ?>
                            </label>
                            <select name="peran" id="peran" class="form-control <?= validorno('peran') ?>">
                                <option value="1" <?= old('peran', $data['role']) == '1' ? 'selected' : '' ?>>Regular
                                    User
                                </option>
                                <option value="2" <?= old('peran', $data['role']) == '2' ? 'selected' : '' ?>>
                                    Administrator</option>
                            </select>
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                <?= $validation->getError('peran') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-3">
                        <?= box_publish(old('publish', $data['status'])) ?>
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