@extends('layouts.app')

@section('content')

{!! Form::open(array('action' => 'FormTestController@store', 'class' => 'form', 'files' => true)) !!}


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

       <textarea class = 'form-control' rows="5"></textarea>


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
                             </div>

                         </div>
                     </div>

                      <div class="card">
                        <div class="card-header">Public Key</div>
                        <div class="card-body">
                          <textarea class="form-control" rows="5" cols="25"></textarea>
                        </div>
                      </div>

                      <div class="card">
                        <div class="card-header">Encryption Key</div>
                        <div class="card-body">
                          <textarea class="form-control" rows="5" cols="25"></textarea>
                        </div>
                      </div>

               </div>
            </div>


       <div class="container">
         <div class="row">
           <div class="col-12 text-center">
             <!-- {!! Form::submit('Upload') !!} -->
            <button class="btn text-center" type="submit">Upload</button>
            </div>
         </div>
       </div>
      </div>
   </div>

   <!-- {{ Form::radio('result', 'buy' , true) }}
   {{ Form::radio('result', 'sell' , false) }} -->

   <!-- <div class="container">
     <div class="row">
       <div class="col-12 text-center"> -->
         <!-- <button class="btn text-center" type="submit">Upload File</button> -->
       <!-- </div>
     </div>
   </div> -->


{!! Form::close() !!}

@endsection
