<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme shadow-lg">
    <div class="app-brand demo">
        <a href="<?= base_url('/') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?= base_url('images/logo/logo.png') ?>" alt="Logo" style="width: 40px; border-radius: 50%;">
            </span>
            <div class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase" style="font-size: 1rem;">PERPUSTAKAAN
                <br>
                Anak Zaman
            </div>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <?php if (session()->get('user_role') == 'pustakawan') { ?>
            <li class="menu-item <?= url_is('/dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('/dashboard') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dashboard" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/perpustakaan') ? 'active' : '' ?>">
                <a href="<?= base_url('/perpustakaan') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-reader" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Perpustakaan</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/buku*') && !url_is('/buku_masuk*')  && !url_is('/buku_keluar*') ? 'active' : '' ?>">
                <a href="<?= base_url('/buku') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-book-bookmark" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Buku</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/peminjaman*') ? 'active' : '' ?>">
                <a href="<?= base_url('/peminjaman') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-transfer-alt" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Peminjaman</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/denda*') ? 'active' : '' ?>">
                <a href="<?= base_url('/denda') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bi bi-exclamation-diamond-fill" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Denda</div>
                    <!-- <i class="bi bi-exclamation-diamond-fill"></i> -->
                </a>
            </li>
            <li class="menu-item <?= url_is('/anggota*') ? 'active' : '' ?>">
                <a href="<?= base_url('/anggota') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-pin" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Anggota</div>
                </a>
            </li>

            <li class="menu-item <?= url_is('/presensi*') ? 'active' : '' ?>">
                <a href="<?= base_url('/presensi') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-check-circle" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Presensi Anggota</div>
                </a>
            </li>

            <li class="menu-item <?= url_is('/rak*') || url_is('/tema*') || url_is('/pengaturan-denda*') ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-analyse" style="font-size: 1rem"></i>
                    <div data-i18n="Layouts">Master Data</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= url_is('/rak*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/rak') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Rak</div>
                        </a>
                    </li>
                    <li class="menu-item <?= url_is('/tema*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/tema') ?>" class="menu-link text-dark">
                            <div data-i18n="Without navbar">Tema</div>
                        </a>
                    </li>

                    <li class="menu-item <?= url_is('/pengaturan-denda*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/pengaturan-denda') ?>" class="menu-link text-dark">
                            <div data-i18n="Without navbar">Pengaturan Denda</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item <?= url_is('/buku_masuk*') ? 'active' : '' ?>">
                <a href="<?= base_url('/buku_masuk') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-book-add" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Buku Masuk</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/buku_keluar*') ? 'active' : '' ?>">
                <a href="<?= base_url('/buku_keluar') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-book" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Buku Keluar</div>
                </a>
            </li>

            <li class="menu-item <?= url_is('/user*') ? 'active' : '' ?>">
                <a href="<?= base_url('/user') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-circle" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data User</div>
                </a>
            </li>

            <li class="menu-item <?= url_is('/report*')  ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-download" style="font-size: 1rem"></i>
                    <div data-i18n="Layouts">Report</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= url_is('/report/buku_masuk*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/report/buku_masuk') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Buku Masuk</div>
                        </a>
                    </li>
                    <li class="menu-item <?= url_is('/report/buku_keluar*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/report/buku_keluar') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Buku Keluar</div>
                        </a>
                    </li>
                    <li class="menu-item <?= url_is('/report/peminjaman*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/report/peminjaman') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Peminjaman</div>
                        </a>
                    </li>
                    <li class="menu-item <?= url_is('/report/denda*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/report/denda') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Denda</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php  } ?>
        <?php if (session()->get('user_role') == 'anggota') { ?>
            <li class="menu-item <?= url_is('/presensi*') ? 'active' : '' ?>">
                <a href="<?= base_url('/presensi') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-check-circle" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Presensi</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/buku*') && !url_is('/buku_masuk*')  && !url_is('/buku_keluar*') ? 'active' : '' ?>">
                <a href="<?= base_url('/buku') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-book-bookmark" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Buku</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/peminjaman*') ? 'active' : '' ?>">
                <a href="<?= base_url('/peminjaman') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-transfer-alt" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Peminjaman</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/denda*') ? 'active' : '' ?>">
                <a href="<?= base_url('/denda') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bi bi-exclamation-diamond-fill" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Data Denda</div>
                    <!-- <i class="bi bi-exclamation-diamond-fill"></i> -->
                </a>
            </li>
        <?php  } ?>
        <?php if (session()->get('user_role') == 'kepala') { ?>
            <li class="menu-item <?= url_is('/dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('/dashboard') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-dashboard" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/perpustakaan') ? 'active' : '' ?>">
                <a href="<?= base_url('/perpustakaan') ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-reader" style="font-size: 1rem"></i>
                    <div data-i18n="Analytics">Perpustakaan</div>
                </a>
            </li>
            <li class="menu-item <?= url_is('/report*')  ? 'active open' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-download" style="font-size: 1rem"></i>
                    <div data-i18n="Layouts">Report</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= url_is('/report/buku_masuk*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/report/buku_masuk') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Buku Masuk</div>
                        </a>
                    </li>
                    <li class="menu-item <?= url_is('/report/buku_keluar*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/report/buku_keluar') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Buku Keluar</div>
                        </a>
                    </li>
                    <li class="menu-item <?= url_is('/report/peminjaman*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/report/peminjaman') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Peminjaman</div>
                        </a>
                    </li>
                    <li class="menu-item <?= url_is('/report/denda*') ? 'active' : '' ?>">
                        <a href="<?= base_url('/report/denda') ?>" class="menu-link text-dark">
                            <div data-i18n="Without menu">Denda</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</aside>