    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/apex-charts/apex-charts.css') ?>" />

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/libs/select2/select2.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Page CSS -->
    <!-- DataTables CSS -->
    <link href="<?= base_url('assets/vendor/libs/dataTables/dataTables.bootstrap5.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Helpers -->
    <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>



    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <style>
        /* trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        } */
        body {
            min-height: 100vh;
            background: linear-gradient(#005690 25vh, #f5f5f9 0);
        }

        input.form-control.border-secondary.is-invalid {
            border-color: #dc3545 !important;
            /* merah */
        }

        select.form-control.border-secondary.is-invalid {
            border-color: #dc3545 !important;
            /* merah */
        }

        select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='gray' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            padding-right: 2rem;
            appearance: none;
            /* Remove default arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        /* Custom styles for Select2 Bootstrap 5 */
        .select2-container--bootstrap-5 .select2-selection {
            background-color: #ffffff;
            border: 2px solid #eee;
            border-radius: 0.2rem;
            padding: 0.375rem 0.75rem;
            min-height: 40px;
            /* Add arrow styling */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234a3144' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            padding-right: 2.25rem;
        }

        /* Focus state - when dropdown is opened */
        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border: 1px solid #005690;
            background-color: #ffffff;
        }

        /* Dropdown border */
        .select2-container--bootstrap-5 .select2-dropdown {
            border: 1px solid #005690;
            background-color: #ffffff;
        }

        /* Selected option background in dropdown */
        .select2-container--bootstrap-5 .select2-results__option--selected {
            background-color: #005690;
            color: #6f6c6f;
        }

        /* Hover state of options in dropdown */
        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: #b4ccff;
            color: black;
        }

        /* Selected item in the select box */
        .select2-container--bootstrap-5 .select2-selection__rendered {
            color: black;
            line-height: 1.5;
            padding: 0;
            background-color: #ffffff;
        }

        /* Placeholder color */
        .select2-container--bootstrap-5 .select2-selection__placeholder {
            color: black;
        }

        .select2-results__option[aria-selected="true"] {
            background-color: #005690 !important;
            color: #ffffff !important;
        }
    </style>