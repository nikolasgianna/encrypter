<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use phpseclib\Crypt\RSA;
use phpseclib\Crypt\AES;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function create()
    {
        return view('fileupload');
    }

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

    public function encrypt_RSA($file)
    {
        $rsa            = new RSA();
        // extract($rsa->createKey());
        // Storage::put('/image/priv_key.txt', $privatekey);
        // Storage::put('/image/pub_key.txt', $publickey);
        $publickey = file_get_contents(storage_path().'/app/image/public.pem');

        $rsa->loadKey($publickey);

        $in             = file_get_contents($file);

        // $encryption_key = openssl_random_pseudo_bytes(64);
        // Storage::put('/image/encryption.txt', $encryption_key);
        //$encryption_key = file_get_contents(storage_path().'/app/image/encryption.txt');
        $encryption_key = Storage::get('/image/encryption.txt');


        $ciphertext     = $rsa->encrypt($encryption_key);
        Storage::put('/image/ciphertext.txt', $ciphertext);

        $iv             = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        Storage::put('/image/iv.txt', $iv);

        $data           = openssl_encrypt($in, 'aes-256-cbc', $encryption_key, 0, $iv);
        Storage::put('/image/data', $data);

        //$rsa->loadKey($privatekey);
    //Storage::put('/image/priv_key.txt', $privatekey);
    }

    public function decrypt_RSA()
    {
        $rsa = new RSA();
        $privatekey = file_get_contents(storage_path().'/app/image/private_unencrypted.pem');
        $rsa->loadKey($privatekey);

        $iv         = file_get_contents(storage_path().'/app/image/iv.txt');
        $ciphertext = file_get_contents(storage_path().'/app/image/ciphertext.txt');
        $data       = file_get_contents(storage_path().'/app/image/data');

        $encryption_key = $rsa->decrypt($ciphertext);
        $out = openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        Storage::put('/image/out.png', $out);
    }

    public function store()
    {
        request()->validate([
             //'fileToUpload' => 'required|file|max:20480',
             'fileToUpload' => 'required|mimes:jpeg,png,jpg,zip,pdf,doc,docx|max:2048',
             'type_text'    => 'string|max:750',
         ]);
        request()->fileToUpload->store('image');

        // return back()
        //         ->with('success','You have successfully uploaded an image.');

        //$rsa = new RSA();
        $in = storage_path().'/app/image/'.request()->fileToUpload->hashName();
        // $in = file_get_contents(storage_path().'/app/image/'.request()->fileToUpload->hashName());


        self::encrypt_RSA($in);

        self::decrypt_RSA();

        $out = file_get_contents(storage_path().'/app/image/out.png');
        $im  = imagecreatefromstring($out);
        imagepng($im, storage_path().'/app/image/test.png');
        return response()->download(storage_path().'/app/image/out.png');
        //return response()->file(storage_path().'/app/image/test.png');
    }

    public function storefile()
    {
        dd(request()->all());
    }

    public function storetext()
    {
        echo request()->input('encrytionKey');
        echo request()->input('textToUpload');
        dd(request()->all());
    }

    public function storetest()
    {
        if (request()->has('textToUpload')) {
            self::storetext();
        }

        if (request()->has('fileToUpload')) {
            self::storefile();
        }
    }
}
