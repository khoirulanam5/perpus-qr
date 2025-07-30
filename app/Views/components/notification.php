<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <span class="fw-semibold" style="color: #be1c00 !important">
            <!-- <?= session('error') ?> -->
        </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('success')) : ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <span class="fw-semibold" style="color: #276e00 !important">
            <?= session('success') ?>
        </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>