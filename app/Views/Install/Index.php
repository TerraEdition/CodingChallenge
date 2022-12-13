<?= $this->extend('Layout/Main') ?>
<?= $this->section('style') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="card mt-5 w-50">
            <div class="p-4 p-md-5">
                <div class="w-100">
                    <?= $validation->listErrors() ?>
                    <h3 class="mb-4">Install Form</h3>
                </div>
                <?php if (session()->getFlashdata('msg')) {
                    echo showAlert(session()->getFlashdata('msg'), session()->getFlashdata('bg'));
                } ?>
                <form method="POST" autocomplete="off">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="host" class="form-label">Host</label>
                        <input type="text" class="form-control <?= validorno('host') ?>" id="host" name="host"
                            value="<?= old('host', 'localhost') ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= $validation->getError('host') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?= validorno('username') ?>" id="username"
                            name="username" value="<?= old('username', 'root') ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= validorno('password') ?>" id="password"
                            name="password" value="<?= old('password') ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="database" class="form-label">Database</label>
                        <input type="text" class="form-control <?= validorno('database') ?>" id="database"
                            name="database" value="<?= old('database') ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= $validation->getError('database') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="port" class="form-label">Port</label>
                        <input type="text" class="form-control <?= validorno('port') ?>" id="port" name="port"
                            value="<?= old('port', '3306') ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= $validation->getError('port') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Setup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<?= script_tag("JS/Page/Login/Index.js") ?>
<?= $this->endSection() ?>