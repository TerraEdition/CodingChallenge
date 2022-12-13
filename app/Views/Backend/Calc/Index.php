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
                                <th><input type="hidden" name="orderBy" value="<?= @$_GET['orderBy'] ?>"> <input
                                        type="hidden" name="orderSort" value="<?= @$_GET['orderSort'] ?>"></th>
                                <th><input type="number" name="total" value="<?= @$_GET['total'] ?>"
                                        class="form-control"></th>
                                <th><input type="date" name="updated_at" value="<?= @$_GET['updated_at'] ?>"
                                        class="form-control"></th>
                                <th>
                                    <input class="btn btn-outline-secondary" type="submit" value="Cari">
                                </th>
                            </tr>
                        </form>
                        <tr>
                            <th id="sort" data-col="bonuses_tb.id" data-sort="<?= sortStat() ?>">#
                                <?= sortIcon('bonuses_tb.id') ?></th>
                            <th id="sort" data-col="total" data-sort="<?= sortStat() ?>">Total Buruh
                                <?= sortIcon('total') ?></th>
                            <th id="sort" data-col="bonuses_tb.updated_at" data-sort="<?= sortStat() ?>">Tanggal
                                Modifikasi <?= sortIcon('bonuses_tb.updated_at') ?></th>
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
                            <td><?= $r['total'] ?> Orang</td>
                            <td><?= date_indo($r['updated_at'], true) ?></td>
                            <td>
                                <?php if (session()->get('role') == '2') {
                                        echo editBtn($r['slug']);
                                    } ?>
                                <div type="button" class="badge bg-info rounded-pill" data-slug="<?= $r['slug'] ?>"
                                    id="detailBtn">
                                    <i class="fa-solid fa-circle-info"></i> Detail
                                </div>
                            </td>
                        </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            </div>
            <?= $pager->links('bonuses', 'default_bootstrap') ?>
        </div>
    </div>
</div>
<div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel">Detail Perhitungan Bonus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" placeholder="Pencarian" id="s">
                <table class="table" id="detailTable">
                    <thead>
                        <tr>
                            <td>Nama Buruh</td>
                            <td>Persentase (%)</td>
                            <td>Hasil (Rp.)</td>
                        </tr>
                    </thead>
                    <tbody id="generateData"></tbody>
                    <tfoot id="titleBonuses"></tfoot>
                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<?= script_tag('JS/Table.js') ?>
<?= script_tag('JS/Redirect.js') ?>
<?= script_tag('JS/Page/Calc/Index.js') ?>
<?= $this->endSection() ?>