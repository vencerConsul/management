<?php 

namespace App\Traits;

require_once '../Library/phpqrcode-master/qrlib.php';

use QRcode;

trait QRCodeTrait
{
    public function generateQRCode($data, $file)
    {
        QRcode::png($data, $file);
        return response()->file($file);
    }
}