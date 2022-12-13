<?= $this->extend('Layout/Main') ?>
<?= $this->section('style') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?= $this->include('Layout/Nav') ?>
<div class="container my-5 py-5">
    <div class="card p-4">
        <h3> <?= $title ?></h3>
        <div class="card-header">
            <?= createBtn() ?>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('msg')) {
                echo showAlert(session()->getFlashdata('msg'), session()->getFlashdata('bg'));
            } ?>
            <div class="table-responsive">
                <table class='table table-striped' id="table1">
                    <thead>
                        <form method="get" action="">
                            <tr>
                                <th>
                                    <input type="hidden" name="orderBy" value="<?= @$_GET['orderBy'] ?>">
                                    <input type="hidden" name="orderSort" value="<?= @$_GET['orderSort'] ?>">
                                </th>
                                <th><input type="text" name="name" value="<?= @$_GET['name'] ?>" class="form-control"
                                        autocomplete="off"></th>
                                <th>
                                    <select name="status" class="form-control">
                                        <option value="" <?= @$_GET['status'] == '' ? 'selected' : '' ?>>-</option>
                                        <option value="true" <?= @$_GET['status'] == 'true' ? 'selected' : '' ?>>Ya
                                        </option>
                                        <option value="false" <?= @$_GET['status'] == 'false' ? 'selected' : '' ?>>Tidak
                                        </option>
                                    </select>
                                </th>
                                <th><input type="date" name="updated_at" value="<?= @$_GET['updated_at'] ?>"
                                        class="form-control"></th>
                                <th>
                                    <input class="btn btn-outline-secondary" type="submit" value="Cari">
                                </th>
                            </tr>
                        </form>
                        <tr>
                            <th id="sort" data-col="workers.id" data-sort="<?= sortStat() ?>">#
                                <?= sortIcon('workers.id') ?></th>
                            <th id="sort" data-col="workers.name" data-sort="<?= sortStat() ?>">
                                Nama <?= sortIcon('workers.name') ?></th>
                            <th id="sort" data-col="workers.status" data-sort="<?= sortStat() ?>">Status
                                <?= sortIcon('workers.status') ?></th>
                            <th id="sort" data-col="workers.updated_at" data-sort="<?= sortStat() ?>">Tanggal
                                Modifikasi <?= sortIcon('workers.updated_at') ?></th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1 + (10 * ($no - 1));
                        foreach ($data as $r) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= status($r['status'], $r['slug']) ?></td>
                            <td><?= date_indo($r['updated_at'], true) ?></td>
                            <td>
                                <?= editBtn($r['slug']) ?>
                                <?= deleteBtn($r['slug'], current_url()) ?>
                            </td>
                        </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            </div>
            <?= $pager->links('workers', 'default_bootstrap') ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<?= script_tag('JS/Table.js') ?>
<?= script_tag('JS/Redirect.js') ?>

<?= $this->endSection() ?>