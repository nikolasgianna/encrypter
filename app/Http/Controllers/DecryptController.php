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

    public function decrypt_text_view()
    {
        return view('decrypt_text');
    }

    public function decrypt_file_view()
    {
        return view('decrypt_file');
    }

    public function upload()
    {
        if (request()->has('textToUpload')) {
            request()->validate([
         'textToUpload'          => 'required|string|min:1|max:750',
         'userEncryptionKeyText' => 'required_without:userEncryptionKeyFile|string|nullable|max:128',
         'userEncryptionKeyFile' => 'file|max:2048',
         'userIVText'            => 'required_without:userIVFile|string|nullable|min:1|max:750',
         'userIVFile'            => 'file|max:2048',
         'encOptions' => 'string|nullable|min:10|max:10',
         'IVOptions' => 'string|nullable|min:10|max:10',
      ]);
            $filename = 'ecnrypted_text.txt';
        } elseif (request()->has('fileToUpload')) {
            request()->validate([
         'fileToUpload'      => 'required|file|max:2048',
         'userEncryptionKeyText' => 'required_without:userEncryptionKeyFile|string|nullable|max:128',
         'userEncryptionKeyFile'      => 'file|max:2048',
         'userIVText'            => 'required_without:userIVFile|string|nullable|min:1|max:750',
         'userIVFile'            => 'file|max:2048',
         'encOptions' => 'string|nullable|min:10|max:10',
         'IVOptions' => 'string|nullable|min:10|max:10',
   ]);
            $filename = 'ecnrypted_img.png';
        }
        // dd(request()->all());
        $request = request();
        $this->handle_req($request);
        return response()->download(storage_path().'/app/image/out', $filename)->deleteFileAfterSend();
    }

    public function handle_req(Request $request)
    {
        if (request()->has('textToUpload')) {
            $in = request()->textToUpload;
        } elseif (request()->has('fileToUpload')) {
            $in = file_get_contents(request()->fileToUpload);
        }

        if (request()->userEncryptionKeyText != null) {
            if (request()->userEncryptionKeyFile != null) {
                if (request()->encOptions == 'manualText') {
                    $enc_key = request()->userEncryptionKeyText;
                } elseif (request()->encOptions == 'manualFile') {
                    $enc_key = file_get_contents(request()->userEncryptionKeyFile);
                }
            } else {
                $enc_key = request()->userEncryptionKeyText;
            }
        } else {
            $enc_key = file_get_contents(request()->userEncryptionKeyFile);
        }

        if (request()->userIVText != null) {
            if (request()->userIVFile != null) {
                if (request()->IVOptions == 'manualText') {
                    $iv = request()->userIVText;
                } elseif (request()->IVOptions == 'manualFile') {
                    $iv = file_get_contents(request()->userIVFile);
                }
            } else {
                $iv = request()->userIVText;
            }
        } else {
            $iv = file_get_contents(request()->userIVFile);
        }

        $out  = openssl_decrypt($in, 'aes-256-cbc', $enc_key, 0, $iv);
        Storage::put('/image/out', $out);
    }
}
