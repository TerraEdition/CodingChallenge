<nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                if (session()->get('role') == '2') { ?>
                <li class="nav-item">
                    <a class="nav-link <?= uri(1) == 'user' ? 'active' : '' ?>" href="<?= base_url() ?>/user">Data
                        Pengguna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri(1) == 'worker' ? 'active' : '' ?>" href="<?= base_url() ?>/worker">Data
                        Buruh</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link <?= uri(1) == 'calc' ? 'active' : '' ?>"
                        href="<?= base_url() ?>/calc">Perhitungan Bonus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>