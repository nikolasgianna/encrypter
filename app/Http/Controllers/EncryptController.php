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

    public function encrypt_text_view()
    {
        return view('encrypt_text');
    }

    public function encrypt_file_view()
    {
        return view('encrypt_file');
    }

    public function upload_text()
    {
        request()->validate([
           'textToUpload'      => 'required|string|min:1|max:750',
           'userEncryptionKeyText' => 'required_without_all:userEncryptionKeyFile,randomEncryptionKey|string|nullable|max:128',
           'userEncryptionKeyFile' => 'empty_with:userEncryptionKeyText|file|max:2048',
           'randomEncryptionKey' => 'string|nullable|max:4',
       ]);

        $request = request();

        $response = $this->zip_it($this->handle_req($request));
        if (!is_null($response)) {
            return $response;
        }
    }

    public function upload_file()
    {
        request()->validate([
           'fileToUpload' => 'required|mimes:jpeg,png,jpg,zip,pdf,doc,docx|max:2048',
           'userEncryptionKeyText' => 'required_without_all:userEncryptionKeyFile,randomEncryptionKey|string|nullable|max:128',
           'userEncryptionKeyFile' => 'empty_with:userEncryptionKeyText|file|max:2048',
           'randomEncryptionKey' => 'string|nullable|max:4',
       ]);
        $request = request();

        $response = $this->zip_it($this->handle_req($request));
        if (!is_null($response)) {
            return $response;
        }
    }

    public function handle_req(Request $request)
    {
        $store_enc = false;
        if (request()->has('textToUpload')) {
            $in = request()->textToUpload;
        } elseif (request()->has('fileToUpload')) {
            $in = file_get_contents(request()->fileToUpload);
        }
        if (request()->randomEncryptionKey != null) {
            $store_enc = true;
            $enc_key = openssl_random_pseudo_bytes(64);
            Storage::put('/image/enc_key', $enc_key);
        } else {
            if (request()->userEncryptionKeyText == null) {
                $enc_key = file_get_contents(request()->userEncryptionKeyFile);
            } else {
                $enc_key = request()->userEncryptionKeyText;
            }
        }
        $this->encrypt_AES($in, $enc_key);
        return $store_enc;
    }

    public function encrypt_AES(String $data_in, $encryption_key)
    {
        $iv   = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        Storage::put('/image/iv', $iv);
        $data = openssl_encrypt($data_in, 'aes-256-cbc', $encryption_key, 0, $iv);
        Storage::put('/image/out.enc', $data);
    }

    public function zip_it($store_encryption_key)
    {
        $zipFileName = 'AllDocuments.zip';
        $zip = new ZipArchive;
        if ($zip->open(storage_path().'/app/image/' . $zipFileName, ZipArchive::CREATE) === true) {
            $zip->addFile(storage_path().'/app/image/out.enc', 'encrypted_data.enc');
            $zip->addFile(storage_path().'/app/image/iv', 'iv');
            if ($store_encryption_key) {
                $zip->addFile(storage_path().'/app/image/enc_key', 'enc_key');
            }

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
