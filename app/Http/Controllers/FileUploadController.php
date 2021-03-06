<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use phpseclib\Crypt\RSA;
use phpseclib\Crypt\AES;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
  
    public function index()
    {
        return view('filewelcome');
    }

    public function encrypt()
    {
        return view('encrypt');
    }

    public function decrypt()
    {
        return view('decrypt');
    }

    public function encrypt_AES(String $data_in, $encryption_key)
    {
        $encryption_key = openssl_random_pseudo_bytes(64);
        Storage::put('/image/enc_key', $encryption_key);
        $iv   = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $data = openssl_encrypt($data_in, 'aes-256-cbc', $encryption_key, 0, $iv);
        $out  = openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        Storage::put('/image/out.png', $out);
    }

    public function store()
    {
        if (request()->has('textToUpload')) {
            request()->validate([
             'textToUpload'      => 'required|string|min:1|max:750',
             'textEncryptionKey' => 'required|string|min:2|max:128',
         ]);

            $in             = request()->textToUpload;
            $encryption_key = request()->textEncryptionKey;
            self::encrypt_AES($in, $encryption_key);
        }

        if (request()->has('fileToUpload')) {
            request()->validate([
                 'fileToUpload'      => 'required|mimes:jpeg,png,jpg,zip,pdf,doc,docx|max:2048',
                 'fileEncryptionKey' => 'required|string|min:2|max:128',
             ]);

            $in             = file_get_contents(request()->fileToUpload);
            $encryption_key = request()->fileEncryptionKey;
            self::encrypt_AES($in, $encryption_key);
            return response()->download(storage_path().'/app/image/out.png', 'ecnrypted_image.png')->deleteFileAfterSend();
        }
    }
}
