@extends('layouts.app')
@section('content')
<form method="post" id="textUpload" class="form" action="{{ action('DecryptController@upload_file') }}" enctype="multipart/form-data">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
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
            <div class="card" id="encInputText" style="display: none;">
                <div class="card-header">Encryption Key</div>
                <div class="card-body">
                    <textarea name="userEncryptionKeyText" id="userEncryptionKeyText" class="form-control" rows="5" cols="25"></textarea>
                </div>
            </div>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="encFile" id="encFile" autocomplete="off" checked>File
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="encText" id="encText" autocomplete="off">Text
                </label>
            </div>
        </div>
        <div class="col-md-3 text-center">
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
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="IVFile" id="IVFile" autocomplete="off" checked>File
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="IVText" id="IVText" autocomplete="off">Text
                </label>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn text-center" type="submit">Upload</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $("#encFile").change(function() {
        if ($(this).prop("checked") == true) {

            $('#encInputText').hide();
            $('#encInputFile').show();
            $('#encText').prop('checked', false);
        }
    });

    $("#encText").change(function() {
        if ($(this).prop("checked") == true) {
            $('#encInputText').show();
            $('#encInputFile').hide();
            $('#encFile').prop('checked', false);
        }
    });

    $("#IVFile").change(function() {
        if ($(this).prop("checked") == true) {

            $('#IvInputText').hide();
            $('#IvInputFile').show();
            $('#IVText').prop('checked', false);

        }
    });

    $("#IVText").change(function() {
        if ($(this).prop("checked") == true) {
            $('#IvInputText').show();
            $('#IvInputFile').hide();
            $('#IVFile').prop('checked', false);
        }
    });
</script>

@endsection
