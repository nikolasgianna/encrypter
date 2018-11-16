<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DecryptController extends Controller
{
    public function decrypt_view()
    {
        return view('decrypt');
    }

    public function decrypt_AES(String $data_in, $encryption_key)
    {
        // $encryption_key = openssl_random_pseudo_bytes(64);
        // Storage::put('/image/enc_key', $encryption_key);
        // $iv   = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $iv = file_get_contents(storage_path().'/app/image/iv');
        // $data = openssl_encrypt($data_in, 'aes-256-cbc', $encryption_key, 0, $iv);
        $out  = openssl_decrypt($data_in, 'aes-256-cbc', $encryption_key, 0, $iv);
        Storage::put('/image/out.png', $out);
    }

    public function upload()
    {
        if (request()->has('textToUpload')) {
            request()->validate([
         'textToUpload'      => 'required|string|min:1|max:750',
         'textEncryptionKey' => 'required|string|min:2|max:128',
     ]);

            $in             = request()->textToUpload;
            $encryption_key = request()->textEncryptionKey;
            // $encryption_key = file_get_contents(storage_path().'/app/image/enc_key');
            // self::decrypt_AES($in, $encryption_key);
            // $encryption_key = openssl_random_pseudo_bytes(64);
            // Storage::put('/image/enc_key', $encryption_key);
            // $iv   = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $iv = file_get_contents(storage_path().'/app/image/iv');
            // $data = openssl_encrypt($in, 'aes-256-cbc', $encryption_key, 0, $iv);
            $out  = openssl_decrypt($in, 'aes-256-cbc', $encryption_key, 0, $iv);
            Storage::put('/image/out.txt', $out);
            return response()->download(storage_path().'/app/image/out.txt', 'ecnrypted_image.txt')->deleteFileAfterSend();
        }

        if (request()->has('fileToUpload')) {
            request()->validate([
             // 'fileToUpload'      => 'required|mimes:jpeg,png,jpg,zip,pdf,doc,docx, enc|max:2048',
             'fileToUpload'      => 'required|file|max:2048',
             'fileEncryptionKey' => 'required|string|min:2|max:128',
         ]);

            $in             = file_get_contents(request()->fileToUpload);
            $encryption_key = request()->fileEncryptionKey;
            self::decrypt_AES($in, $encryption_key);
            return response()->download(storage_path().'/app/image/out.png', 'ecnrypted_image.png')->deleteFileAfterSend();
        }
    }
}
