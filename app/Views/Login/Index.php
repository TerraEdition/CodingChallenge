<?= $this->extend('Layout/Main') ?>
<?= $this->section('style') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="card mt-5 w-50">
            <div class="p-4 p-md-5">
                <div class="w-100">
                    <h3 class="mb-4">Login Form</h3>
                </div>
                <?php if (session()->getFlashdata('msg')) {
                    echo showAlert(session()->getFlashdata('msg'), session()->getFlashdata('bg'));
                } ?>
                <form method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?= validorno('username') ?>" id="username"
                            name="username" value="<?= old('username') ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" id="password">
                            <span class="input-group-text" type="button" id="togglePass">
                                <i class="fa-solid fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
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