@extends('layouts.app')
@section('content')
<div class="modal-body row">
    <div class="col-md-4 text-center">
        <form method="post" id="textUpload" class="form" action="{{ action('EncryptController@upload') }}" enctype="multipart/form-data">
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
                <input type="hidden" name="randomTrueText" id="randomTrueText" />

                <span id="enc_text_area"></span>

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

        <div class="card" id="encInputFile" style="pointer-events: none; opacity: 0.4;">
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
        <div class="card" id="encInputText" style="display: none; pointer-events: none; opacity: 0.4;">
            <div class="card-header">Encryption Key</div>
            <div class="card-body">
                <textarea name="userEncryptionKeyText" id="userEncryptionKeyText" class="form-control" rows="5" cols="25"></textarea>
            </div>
        </div>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="auto" value='TRUE' autocomplete="off" checked> Auto
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="manualFile" autocomplete="off"> Manual-File
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="manualText" autocomplete="off"> Manual-Text
            </label>
        </div>

    </div>
    <div class="col-md-4 text-center">
        <form method="post" id="fileUpload" class="form" action="{{ action('EncryptController@upload') }}" enctype="multipart/form-data">
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
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="fileToUpload" id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Please upload a file. Size should not be more than 2MB.</small>
                                <input type="hidden" name="fileEncryptionKeyText" id="fileEncryptionKeyText" />
                                <input type="hidden" name="randomTrueFile" id="randomTrueFile" />
                                <span id="enc_file_area"></span>
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

<script type="text/javascript" src="{{ URL::asset('js/encrypt.js') }}"></script>

@endsection
