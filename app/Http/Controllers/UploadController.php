<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib\Crypt\RSA;
use phpseclib\Crypt\AES;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

  public function create()
  {
      return view('fileupload');
  }

  public function upload()
  {
      request()->validate([
           //'fileToUpload' => 'required|file|max:20480',
           'fileToUpload' => 'required|mimes:jpeg,png,jpg,zip,pdf,doc,docx|max:2048',
           'type_text'    => 'string|max:750',
       ]);
      request()->fileToUpload->store('image');

      //$rsa = new RSA();
      $in = storage_path().'/app/image/'.request()->fileToUpload->hashName();
      // $in = file_get_contents(storage_path().'/app/image/'.request()->fileToUpload->hashName());

      self::encrypt_RSA($in);
      self::decrypt_RSA();

      $out = file_get_contents(storage_path().'/app/image/out.png');
      $im  = imagecreatefromstring($out);
      imagepng($im, storage_path().'/app/image/test.png');
      return response()->download(storage_path().'/app/image/out.png');
      //return response()->download(storage_path().'/app/image/test.png');
  }

  public function encrypt_RSA($file)
  {
      $rsa            = new RSA();
      extract($rsa->createKey());
      Storage::put('/image/priv_key.txt', $privatekey);
      // Storage::put('/image/pub_key.txt', $publickey);
      //$publickey = file_get_contents(storage_path().'/app/image/public.pem');

      $rsa->loadKey($publickey);

      $in             = file_get_contents($file);

      $encryption_key = openssl_random_pseudo_bytes(64);
      // Storage::put('/image/encryption.txt', $encryption_key);
      //$encryption_key = file_get_contents(storage_path().'/app/image/encryption.txt');
      //$encryption_key = Storage::get('/image/encryption.txt');


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
      $rsa        = new RSA();
      $privatekey = file_get_contents(storage_path().'/app/image/priv_key.txt');
      $rsa->loadKey($privatekey);

      $iv         = file_get_contents(storage_path().'/app/image/iv.txt');
      $ciphertext = file_get_contents(storage_path().'/app/image/ciphertext.txt');
      $data       = file_get_contents(storage_path().'/app/image/data');

      $encryption_key = $rsa->decrypt($ciphertext);
      $out            = openssl_decrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
      Storage::put('/image/out.png', $out);
  }

  public function upload2()
  {
      if (request()->has('textToUpload')) {
          request()->validate([
         'textToUpload'      => 'required|string|min:1|max:750',
         'textEncryptionKeyText' => 'required_without_all:textEncryptionKeyFile,randomTrueText|string|nullable|max:128',
         'textEncryptionKeyFile' => 'empty_with:textEncryptionKeyText|file|max:2048',
         'randomTrueText' => 'string|nullable|max:4',
     ]);
          $store_enc = false;
          $in = request()->textToUpload;
          if (request()->randomTrueText != null) {
              $store_enc = true;
              $enc_key = openssl_random_pseudo_bytes(64);
              Storage::put('/image/enc_key', $enc_key);
          } else {
              if (request()->textEncryptionKeyText == null) {
                  $enc_key = file_get_contents(request()->textEncryptionKeyFile);
              } else {
                  $enc_key = request()->textEncryptionKeyText;
              }
          }
      }

      if (request()->has('fileToUpload')) {
          request()->validate([
             'fileToUpload'      => 'required|mimes:jpeg,png,jpg,zip,pdf,doc,docx|max:2048',
             'fileEncryptionKeyText' => 'required_without_all:fileEncryptionKeyFile,randomTrueFile|string|nullable|max:128',
             'fileEncryptionKeyFile'      => 'empty_with:fileEncryptionKeyText|file|max:2048',
             'randomTrueFile' => 'string|nullable|max:4',
           ]);
          $store_enc = false;

          $in = file_get_contents(request()->fileToUpload);
          if (request()->randomTrueFile !== null) {
              $store_enc = true;
              $enc_key = openssl_random_pseudo_bytes(64);
              Storage::put('/image/enc_key', $enc_key);
          } else {
              if (request()->fileEncryptionKeyText == null) {
                  $enc_key = file_get_contents(request()->fileEncryptionKeyFile);
              } else {
                  $enc_key = request()->fileEncryptionKeyText;
              }
          }
      }
      self::encrypt_AES($in, $enc_key);
      $response = $this->zip_it($store_enc);
      if (!is_null($response)) {
          return $response;
      }
  }

  public function upload3()
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
