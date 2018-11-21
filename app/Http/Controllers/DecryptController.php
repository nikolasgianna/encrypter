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

    public function upload_text()
    {
        request()->validate([
         'textToUpload'          => 'required|string|min:1|max:750',
         'userEncryptionKeyText' => 'required_without:userEncryptionKeyFile|string|nullable|max:128',
         // 'userEncryptionKeyFile' => 'empty_with:userEncryptionKeyText|file|max:2048',
         'userEncryptionKeyFile' => 'file|max:2048',
         'userIVText'            => 'required_without:userIVFile|string|nullable|min:1|max:750',
         // 'userIVFile'            => 'empty_with:userIVText|file|max:2048',
         'userIVFile'            => 'file|max:2048',
      ]);
        $request = request();
        $this->handle_req($request);
        return response()->download(storage_path().'/app/image/out', 'ecnrypted_text.txt')->deleteFileAfterSend();
    }

    public function upload_file()
    {
        request()->validate([
       'fileToUpload'      => 'required|file|max:2048',
       'userEncryptionKeyText' => 'required_without:userEncryptionKeyFile|string|nullable|max:128',
       'userEncryptionKeyFile'      => 'empty_with:userEncryptionKeyText|file|max:2048',
       'userIVText'            => 'required_without:userIVFile|string|nullable|min:1|max:750',
       'userIVFile'            => 'empty_with:userIVText|file|max:2048',
     ]);

        $request = request();
        $this->handle_req($request);
        return response()->download(storage_path().'/app/image/out', 'ecnrypted_img.png')->deleteFileAfterSend();
    }

    public function handle_req(Request $request)
    {
        if (request()->has('textToUpload')) {
            $in = request()->textToUpload;
        } elseif (request()->has('fileToUpload')) {
            $in = file_get_contents(request()->fileToUpload);
        }
        if (request()->userEncryptionKeyText == null) {
            $enc_key = file_get_contents(request()->userEncryptionKeyFile);
        } else {
            $enc_key = request()->userEncryptionKeyText;
        }

        if (request()->userIVText == null) {
            $iv = file_get_contents(request()->userIVFile);
        } else {
            $iv = request()->userIVText;
        }

        $out  = openssl_decrypt($in, 'aes-256-cbc', $enc_key, 0, $iv);
        Storage::put('/image/out', $out);
    }
}
