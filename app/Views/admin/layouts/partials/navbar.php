<nav class="layout-navbar shadow bg-white navbar-static container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-left d-flex align-items-center" style="width: 100%">
        <ul class="navbar-nav flex-row align-items-center">
            <li class="nav-item lh-1 me-3">
                <a href="javascript:void(0);" class="text-dark fw-bold">
                    PERPUSTAKAAN ANAK ZAMAN DESA NALUMSARI
                    <!-- <span class="fw-semibold text-secondary"> / <?= esc($title ?? '') ?></span> -->
                </a>
            </li>
        </ul>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item lh-1 me-3">
                <a href="javascript:void(0);" class="text-dark fw-semibold">Hi!

                    <span><?= esc(session('user_name') ?? 'GUEST') ?></span>
                </a>
            </li>

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <div class="position-relative d-inline-block" style="width: 40px; height: 40px;">
                            <img src="<?= base_url('assets/img/avatars/' . '5.png') ?>" alt="Avatar"
                                class="rounded-circle w-100 h-100 object-fit-cover" />
                        </div>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <div class="position-relative d-inline-block"
                                            style="width: 40px; height: 40px;">
                                            <img src="<?= base_url('assets/img/avatars/5.png') ?>" alt="Avatar"
                                                class="rounded-circle w-100 h-100 object-fit-cover" />
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">

                                    <span class="fw-semibold d-block"><?= esc(session('user_username') ?? 'GUEST') ?></span>
                                    <small class="text-muted"><?= esc(session('user_role') ?? 'GUEST') ?></small>

                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li class="cursor-pointer">
                        <form action="<?= base_url('logout') ?>" method="get" class="dropdown-item"
                            style="text-decoration: none;">
                            <button type="submit"
                                class="btn btn-link text-decoration-none p-0 m-0 d-flex align-items-center">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>