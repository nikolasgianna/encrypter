<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class EncryptController extends Controller
{
    const zipFileName = 'AllDocuments.zip';

    public function encrypt_view()
    {
        return view('encrypt');
    }

    public function encrypt_AES(String $data_in, $encryption_key)
    {
        // $encryption_key = openssl_random_pseudo_bytes(64);
        Storage::put('/image/enc_key', $encryption_key);
        $iv   = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        Storage::put('/image/iv', $iv);

        $data = openssl_encrypt($data_in, 'aes-256-cbc', $encryption_key, 0, $iv);
        // Storage::put('/image/data', $data);
        // $out  = openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        Storage::put('/image/out.enc', $data);
    }

    public function upload()
    {
        if (request()->has('textToUpload')) {
            request()->validate([
           'textToUpload'      => 'required|string|min:1|max:750',
           'textEncryptionKeyText' => 'required_without:textEncryptionKeyFile|string|nullable|max:128',
           'textEncryptionKeyFile' => 'empty_with:textEncryptionKeyText|file|max:2048',
       ]);

            $in = request()->textToUpload;
            if (request()->textEncryptionKeyText == null) {
                request()->textEncryptionKeyFile->store('image');
                $enc_key = Storage::get('/image/'.request()->textEncryptionKeyFile->hashName());
            } else {
                $enc_key = request()->textEncryptionKeyText;
            }
            // self::encrypt_AES($in, $enc_key);

            // return response()->download(storage_path().'/app/image/out.enc', 'ecnrypted_text.enc')->deleteFileAfterSend();
        }

        if (request()->has('fileToUpload')) {
            request()->validate([
               'fileToUpload'      => 'required|mimes:jpeg,png,jpg,zip,pdf,doc,docx|max:2048',
               'fileEncryptionKeyText' => 'required_without:fileEncryptionKeyFile|string|nullable|max:128',
               'fileEncryptionKeyFile'      => 'empty_with:fileEncryptionKeyText|file|max:2048',
             ]);

            $in             = file_get_contents(request()->fileToUpload);
            if (request()->fileEncryptionKeyText == null) {
                request()->fileEncryptionKeyFile->store('image');
                $enc_key = Storage::get('/image/'.request()->fileEncryptionKeyFile->hashName());
            } else {
                $enc_key = request()->fileEncryptionKeyText;
            }
            // self::encrypt_AES($in, $enc_key);
            // return response()->download(storage_path().'/app/image/out.enc', 'ecnrypted_image.enc')->deleteFileAfterSend();
        }
        self::encrypt_AES($in, $enc_key);
        $zipFileName = 'AllDocuments.zip';
        $zip = new ZipArchive;
        if ($zip->open(storage_path().'/app/image/' . $zipFileName, ZipArchive::CREATE) === true) {
            // Add File in ZipArchive
            $zip->addFile(storage_path().'/app/image/out.enc', 'encrypted_data.enc');
            $zip->addFile(storage_path().'/app/image/iv', 'iv');
            $zip->addFile(storage_path().'/app/image/enc_key', 'enc_key');
            // Close ZipArchive
            $zip->close();
        }
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath=storage_path().'/app/image/' .$zipFileName;
        if (file_exists($filetopath)) {
            return response()->download($filetopath, $zipFileName, $headers)->deleteFileAfterSend();
        }
    }
}
