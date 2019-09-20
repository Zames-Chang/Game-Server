<?php

namespace App\Http\Controllers;

use Endroid\QrCode\QrCode;

class QrCodeController extends Controller
{
    public function showImage()
    {
        $timestamp = time();
        $hashKey = md5(env('TASK_VKEY', 'ThisIsDefaultKey') . '+' . $timestamp);

        $qrCode = new QrCode();
        $qrCode->setText($hashKey . '+' . $timestamp);
        $qrCode->setSize(250);
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(10);

        $data = [
            'image' => $qrCode->writeDataUri(),
            'timestamp' => time(),
        ];
        return view('qrcode', $data);
    }
}
