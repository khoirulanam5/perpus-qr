<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="<?= base_url('assets/') ?>" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= esc($title ?? 'Dashboard') ?></title>

    <meta name="description" content="<?= esc($appSetting->description ?? '') ?>" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="<?= base_url('images/logo/' . ($appSetting->logo ?? 'logo.png')) ?>" />

    <?= $this->include('admin/layouts/partials/styles') ?>
    <?= $this->renderSection('styles') ?>

    <script src="<?= base_url('assets/js/config.js') ?>"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Sidebar -->
            <?= $this->include('admin/layouts/partials/sidebar') ?>
            <!-- /Sidebar -->

            <div class="layout-page">
                <!-- Navbar -->
                <?= $this->include('admin/layouts/partials/navbar') ?>
                <!-- /Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?= $this->renderSection('content') ?>
                    </div>

                    <?= $this->include('admin/layouts/partials/footer') ?>

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- /Content wrapper -->

            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <?= $this->include('admin/layouts/partials/scripts') ?>
    <?= $this->renderSection('scripts') ?>
</body>

</html>