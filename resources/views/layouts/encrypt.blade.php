@extends('layouts.app')
@section('content')
<form method="post" id="textUpload" class="form" action="{{ action('EncryptController@upload') }}" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="modal-body row">
        <div class="col-md-6 text-center">
            @yield('fileOrText')
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="encChoice" id="AES" value='AES' autocomplete="off" checked> AES
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="encChoice" id="RSA" value='RSA' autocomplete="off"> RSA
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="encChoice" id="SHA" value='SHA' autocomplete="off"> SHA
            </label>
        </div>
        </div>
        <div class="col-md-6 text-center">

            {{-- File Input --}}
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

            {{-- Text Input --}}
            <div class="card" id="encInputText" style="display: none; pointer-events: none; opacity: 0.4;">
                <div class="card-header">Encryption Key</div>
                <div class="card-body">
                    <textarea name="userEncryptionKeyText" id="userEncryptionKeyText" class="form-control" rows="2" cols="25"></textarea>
                </div>
            </div>

            {{-- Choose Input Source --}}
            <div class="btn-group btn-group-toggle" data-toggle="buttons" id="options">
                <label class="btn btn-secondary active">
                    <input type="radio" id="auto" name="options" value='auto' autocomplete="off" checked> Auto
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" value='manualFile' id="manualFile" autocomplete="off"> Manual-File
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="options" value='manualText' id="manualText" autocomplete="off"> Manual-Text
                </label>
            </div>
        </div>
    </div>
    {{-- Submit Button --}}
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn text-center" type="submit">Upload</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="{{ URL::asset('js/encrypt.js') }}"></script>

@endsection
