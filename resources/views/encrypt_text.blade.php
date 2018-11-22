@extends('layouts.encrypt')
@section('fileOrText')
  <div class="card">
      <div class="card-header">Text</div>
      <div class="form-group">
          <textarea class='form-control' name="textToUpload" rows="3"></textarea>
          <input type="hidden" name="randomEncryptionKey" id="randomEncryptionKey" />
      </div>
  </div>


@endsection
