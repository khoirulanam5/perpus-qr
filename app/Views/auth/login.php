<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="<?= base_url('assets/') ?>" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login | Perpustakaan Anak Zaman</title>

    <meta name="description" content="<?= esc($appSetting->description ?? '') ?>" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="<?= base_url('images/logo/' . ($appSetting->logo ?? 'logo.png')) ?>" />

    <?= $this->include('admin/layouts/partials/styles') ?>
    <?= $this->renderSection('styles') ?>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background: linear-gradient(-135deg, #19cb74 10%, #308cff 90%, #2570e6 100%);
            font-family: sans-serif;
        }

        main {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <script src="<?= base_url('assets/js/config.js') ?>"></script>
</head>

<body>
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center align-items-center py-4">
                                <a href="/" class="logo d-flex align-items-center w-auto">
                                    <img src="<?= base_url('images/logo/logo.png') ?>" alt="Perpustakaan Anak Zaman Logo" height="80" style="display: block;">
                                    <h4 class="d-none d-lg-block mb-0 ms-2 text-white fw-bold ">
                                        Perpustakaan Anak Zaman <br>
                                        Desa Nalumsari
                                    </h4>
                                </a>
                            </div>

                            <div class="card mb-3 shadow-lg">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <?php if (session()->has('error')) : ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <span class="fw-semibold" style="color: #be1c00 !important">
                                                Username atau password salah
                                            </span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form class="row g-3 " action="/login" method="POST">
                                        <?= csrf_field(); ?>
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="username" class="form-control"
                                                    value="" id="yourUsername" required
                                                    placeholder="Username">
                                                <div class="invalid-feedback">Please enter your username.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                value="" id="yourPassword" required
                                                placeholder="Password">
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button class="btn btn-primary w-100 fw-bold" type="submit">LOGIN</button>
                                        </div>
                                    </form>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

    <?= $this->include('admin/layouts/partials/scripts') ?>
    <?= $this->renderSection('scripts') ?>
</body>

</html>