@extends('layouts.app')

@section('content')

<div class="modal-body row">
    <div class="col-md-6 text-center">
        <button type="button" onclick="window.location='{{ route("encrypt") }}'">Encrypt</button>
    </div>
    <div class="col-md-6 text-center">
        <button type="button" onclick="window.location='{{ route("decrypt") }}'">Decrypt</button>
    </div>
</div>

@endsection
{{-- @extends('layouts.app')

@section('content') --}}


{{-- <link href="{{ asset('css/split.css') }}" rel="stylesheet"> --}}


{{-- @endsection --}}
