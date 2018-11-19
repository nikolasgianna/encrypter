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


    public function upload()
    {
        if (request()->has('textToUpload')) {
            request()->validate([
         'textToUpload'          => 'required|string|min:1|max:750',
         'textEncryptionKeyText' => 'required_without:textEncryptionKeyFile|string|nullable|max:128',
         'textEncryptionKeyFile' => 'empty_with:textEncryptionKeyText|file|max:2048',
         'textIVText'            => 'required_without:textIVFile|string|nullable|min:1|max:750',
         'textIVFile'            => 'empty_with:textIVText|file|max:2048',
     ]);
            // dd(request()->all());
            $in = request()->textToUpload;
            if (request()->textEncryptionKeyText == null) {
                request()->textEncryptionKeyFile->store('image');
                $enc_key = Storage::get('/image/'.request()->textEncryptionKeyFile->hashName());
            } else {
                $enc_key = request()->textEncryptionKeyText;
            }

            if (request()->textIVText == null) {
                request()->textIVFile->store('image');
                $iv = Storage::get('/image/'.request()->textIVFile->hashName());
            } else {
                $iv = request()->textIVText;
            }

            $out  = openssl_decrypt($in, 'aes-256-cbc', $enc_key, 0, $iv);
            Storage::put('/image/out.txt', $out);
            return response()->download(storage_path().'/app/image/out.txt', 'ecnrypted_text.txt')->deleteFileAfterSend();
        }

        if (request()->has('fileToUpload')) {
            request()->validate([
             'fileToUpload'      => 'required|file|max:2048',
             'fileEncryptionKeyText' => 'required_without:fileEncryptionKeyFile|string|nullable|max:128',
             'fileEncryptionKeyFile'      => 'empty_with:fileEncryptionKeyText|file|max:2048',
             'fileIVText'            => 'required_without:fileIVFile|string|nullable|min:1|max:750',
             'fileIVFile'            => 'empty_with:fileIVText|file|max:2048',
         ]);


            request()->fileToUpload->store('image');
            $in = Storage::get('/image/'.request()->fileToUpload->hashName());
            if (request()->fileEncryptionKeyText == null) {
                request()->fileEncryptionKeyFile->store('image');
                $enc_key = Storage::get('/image/'.request()->fileEncryptionKeyFile->hashName());
            } else {
                $enc_key = request()->fileEncryptionKeyText;
            }

            if (request()->fileIVText == null) {
                request()->fileIVFile->store('image');
                $iv = Storage::get('/image/'.request()->fileIVFile->hashName());
            } else {
                $iv = request()->fileIVText;
            }

            $out  = openssl_decrypt($in, 'aes-256-cbc', $enc_key, 0, $iv);
            Storage::put('/image/out.png', $out);
            return response()->download(storage_path().'/app/image/out.png', 'ecnrypted_image.png')->deleteFileAfterSend();
        }
    }
}
