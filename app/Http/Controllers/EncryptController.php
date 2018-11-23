<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 300);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use phpseclib\Crypt\RSA;

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

    public function upload()
    {
        if (request()->has('textToUpload')) {
            request()->validate([
           'textToUpload'      => 'required|string|min:1|max:750',
           'userEncryptionKeyText' => 'required_without_all:userEncryptionKeyFile,randomEncryptionKey|string|nullable|max:128',
           'userEncryptionKeyFile' => 'file|max:2048',
           'randomEncryptionKey' => 'string|nullable|max:4',
           'options' => 'string|nullable|min:4|max:10',
           'encChoice' => 'string|nullable|min:3|max:3',
       ]);
        } elseif (request()->has('fileToUpload')) {
            request()->validate([
            'fileToUpload' => 'required|mimes:jpeg,png,jpg,zip,pdf,doc,docx,txt,asc|max:2048',
            'userEncryptionKeyText' => 'required_without_all:userEncryptionKeyFile,randomEncryptionKey|string|nullable|max:128',
            'userEncryptionKeyFile' => 'file|max:2048',
            'randomEncryptionKey' => 'string|nullable|max:4',
            'options' => 'string|nullable|min:4|max:10',
            'encChoice' => 'string|nullable|min:3|max:3',
      ]);
        }
        // dd(request()->all());
        $request = request();
        $response = $this->handle_req();
        // $response = $this->zip_it($this->handle_req());
        if (!is_null($response)) {
            return $response;
        }
    }

    // public function handle_req(Request $request)
    public function handle_req()
    {
        $store_enc = false;

        if (request()->has('textToUpload')) {
            $in = request()->textToUpload;
        } elseif (request()->has('fileToUpload')) {
            $in = file_get_contents(request()->fileToUpload);
        }

        if (request()->randomEncryptionKey != null) {
            if (request()->options == 'auto') {
                $store_enc = true;
                if (request()->encChoice == 'AES') {
                    $enc_key = openssl_random_pseudo_bytes(64);
                    Storage::put('/image/enc_key', $enc_key);
                } elseif (request()->encChoice == 'RSA') {
                    $rsa = new RSA();
                    extract($rsa->createKey());
                    $enc_key = $privatekey;
                    Storage::put('/image/priv_key.txt', $privatekey);
                    Storage::put('/image/pub_key.txt', $publickey);
                }
            }
        } else {
            if (request()->userEncryptionKeyText != null) {
                if (request()->userEncryptionKeyFile != null) {
                    if (request()->options == 'manualText') {
                        $enc_key = request()->userEncryptionKeyText;
                    } elseif (request()->options == 'manualFile') {
                        $enc_key = file_get_contents(request()->userEncryptionKeyFile);
                    }
                } else {
                    $enc_key = request()->userEncryptionKeyText;
                }
            } else {
                $enc_key = file_get_contents(request()->userEncryptionKeyFile);
            }
        }

        if (request()->encChoice == 'AES') {
            $data = $this->encrypt_AES($in, $enc_key);
        } elseif (request()->encChoice == 'RSA') {
            $data = $this->encrypt_RSA($in, $enc_key);
        } elseif (request()->encChoice == 'SHA') {
            // $this->digestSHA($in);
            return response()->download(storage_path().'/app/image/out.enc', 'digest.txt', $this->digestSHA($in))->deleteFileAfterSend();
        }
        Storage::put('/image/out.enc', $data);
        return $this->zip_it($store_enc);
    }

    public function zip_it($store_encryption_key)
    {
        $zipFileName = 'AllDocuments.zip';
        $zip = new ZipArchive;
        if ($zip->open(storage_path().'/app/image/' . $zipFileName, ZipArchive::CREATE) === true) {
            $zip->addFile(storage_path().'/app/image/out.enc', 'encrypted_data.enc');

            if (request()->encChoice == 'AES') {
                $zip->addFile(storage_path().'/app/image/iv', 'iv');
            }
            if ($store_encryption_key) {
                if (request()->encChoice == 'AES') {
                    $zip->addFile(storage_path().'/app/image/enc_key', 'enc_key');
                } elseif (request()->encChoice == 'RSA') {
                    $zip->addFile(storage_path().'/app/image/priv_key.txt', 'private_key');
                    $zip->addFile(storage_path().'/app/image/pub_key.txt', 'public_key');
                }
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

    public function encrypt_AES(String $data_in, $encryption_key)
    {
        $iv   = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        Storage::put('/image/iv', $iv);
        $data = openssl_encrypt($data_in, 'aes-256-cbc', $encryption_key, 0, $iv);
        return $data;
        // Storage::put('/image/out.enc', $data);
    }

    public function encrypt_RSA(String $file, $privatekey)
    {
        $rsa       = new RSA();
        $rsa->loadKey($privatekey);
        $ciphertext     = $rsa->encrypt($file);
        return $ciphertext;
        // Storage::put('/image/out.enc', $ciphertext);
        // Storage::put('/image/ciphertext.txt', $ciphertext);
    }

    public function digestSHA($in)
    {
        $data = openssl_digest($in, 'sha256');
        Storage::put('/image/out.enc', $data);
        return $headers = array(
       'Content-Type' => 'text/plain',);
    }
}
