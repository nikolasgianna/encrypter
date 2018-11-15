@extends('layouts.app')
@section('content')
<div class="modal-body row">
    <div class="col-md-4 text-center">
        <form method="post" id="textUpload" class="form" action="{{ action('FileUploadController@storetest') }}" enctype="multipart/form-data">
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
                <input type="hidden" name="encrytionKey" id="textEncKey" />
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
        <div class="card">
            <div class="card-header">Encryption Key</div>
            <div class="card-body">
                {{-- <input id="encryptionKey" type="textarea" rows="5" cols="25"/> --}}
                <textarea id="encryptionKey" class="form-control" rows="5" cols="25"></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <form method="post" id="fileUpload" class="form" action="{{ action('FileUploadController@storetest') }}" enctype="multipart/form-data">
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
                                <input type="hidden" name="encrytionKey" id="fileEncKey" />
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 text-center">
                                <!-- {!! Form::submit('Upload') !!} -->
                                <button class="btn text-center" type="submit" name="fileToUpload">Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $("#fileUpload").on("submit", function(e) {
        $('#fileEncKey').val(document.getElementById("encryptionKey").value);
        alert(document.getElementById("encryptionKey").value);
    });
    $("#textUpload").on("submit", function(e) {
        $('#textEncKey').val(document.getElementById("encryptionKey").value);
        alert(document.getElementById("encryptionKey").value);
    });
</script>
@endsection