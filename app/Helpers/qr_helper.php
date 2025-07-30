<?php

use Endroid\QrCode\Builder\Builder;

if (!function_exists('generate_qr_base64')) {
    function generate_qr_base64($text)
    {
        $result = Builder::create()
            ->data($text)
            ->size(150)
            ->margin(5)
            ->build();

        return 'data:image/png;base64,' . base64_encode($result->getString());
    }
}
