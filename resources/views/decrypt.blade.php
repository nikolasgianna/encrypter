@extends('layouts.app')
@section('content')
<div class="modal-body row">
    <div class="col-md-4 text-center">
        <form method="post" id="textUpload" class="form" action="{{ action('DecryptController@upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-header">Text</div>
            <div class="form-group">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <textarea class='form-control' name="textToUpload" rows="5"></textarea>
                <input type="hidden" name="textEncryptionKeyText" id="textEncryptionKeyText" />
                <input type="hidden" name="textIVText" id="textIVText" />
                <span id="enc_text_area"></span>
                <span id="iv_text_area"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button class="btn text-center" type="submit">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4 text-center">

        <div class="modal-body row">
            <div class="col-md-6 text-center">
              <div class="card" id="encInputFile">
                  <div class="card-header">Encryption Key</div>
                  <div class="card-body">
                      @if ($message = Session::get('success'))
                      <div class="alert alert-success alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <strong>{{ $message }}</strong>
                      </div>
                      @endif
                      <div class="form-group">
                          <input type="file" class="form-control-file" name="userEncryptionKeyFile" id="userEncryptionKeyFile" aria-describedby="fileHelp">
                          <small id="fileHelp" class="form-text text-muted">Please upload a file. Size should not be more than 2MB.</small>
                      </div>
                  </div>
              </div>
                <div class="card" id="encInputText"  style="display: none;">
                    <div class="card-header">Encryption Key</div>
                    <div class="card-body">
                        <textarea name="userEncryptionKeyText" id="userEncryptionKeyText" class="form-control" rows="5" cols="25"></textarea>
                    </div>
                </div>
                <div class="form-control" name="selectEnc" id="selectEnc">
                    <select name="selectEnc" id="selectEnc" autocomplete="off" onchange="getValEnc(this);">
                      <option value="file" selected="selected">File</option>
                        <option value="text">Text</option>
                    </select>
                </div>

            </div>
            <div class="col-md-6 text-center">

              <div class="card" id="IvInputFile">
                  <div class="card-header">Initialization Vector</div>
                  <div class="card-body">
                      @if ($message = Session::get('success'))
                      <div class="alert alert-success alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <strong>{{ $message }}</strong>
                      </div>
                      @endif
                      <div class="form-group">
                          <input type="file" class="form-control-file" name="userIVFile" id="userIVFile" aria-describedby="fileHelp">
                          <small id="fileHelp" class="form-text text-muted">Please upload a file. Size should not be more than 2MB.</small>
                      </div>
                  </div>
              </div>
                <div class="card" id="IvInputText" style="display: none;">
                    <div class="card-header">Initialization Vector</div>
                    <div class="card-body">
                        <textarea name="userIVText" id="userIVText" class="form-control" rows="5" cols="25"></textarea>
                    </div>
                </div>
                <div class="form-control" name="selectIv" id="selectIv">
                    <select name="selectIv" id="selectIv" autocomplete="off" onchange="getValIv(this);">
                      <option value="file" selected="selected">File</option>
                        <option value="text">Text</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-4 text-center">
        <form method="post" name="fileUpload" id="fileUpload" class="form" action="{{ action('DecryptController@upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row justify-content-center">
                    <div class="card">
                        <div class="card-header">Upload File</div>
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                            <div class="form-group" id="testform">
                                <input type="file" class="form-control-file" name="fileToUpload" id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Please upload a file. Size should not be more than 2MB.</small>
                                <input type="hidden" name="fileEncryptionKeyText" id="fileEncryptionKeyText" />
                                <input type="hidden" name="fileIVText" id="fileIVText" />
                                <span id="enc_file_area"></span>
                                <span id="iv_file_area"></span>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="btn text-center" type="submit" name="fileToUpload">Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript" src="{{ URL::asset('js/additional.js') }}"></script>

@endsection
