@extends('backend.templates.master')
@section('content')
<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Upload  Photo Profile</span></li>
            </ol>
        </nav>
    </div>
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
   
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body justify-content-center">
                <h4 class="text-center p-3">UPLOAD PHOTO PROFILE</h4>
                <hr>
                 @if (session('message'))
                        <div class="alert alert-{{session('alert')}} text-center">{{session('message')}}</div>
                        @endif  
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-lg-4">
                            @if (!@empty( session('backend-session')->foto))
                            <img src="{{ asset( session('backend-session')->foto)}}" class="img-fluid rounded-circle">
                            @else
                                <img src="{{ asset('images/no-photo.svg')}}" class="img-fluid rounded-circle">
                                
                            @endif
                        </div>
                    </div>
                 <div class="row justify-content-center p-3">
                    <form class="form-inline" method="post" action="{{route('upload_foto_backend')}}" enctype="multipart/form-data">
                        @csrf
                    <div class="col-12 text-center">
                        Upload Foto <input type="file" id="foto" name="foto" class="form-control m-2 @error('foto') is-invalid @enderror">
                        <input type="submit" class="btn btn-danger m-2" id="tombol" onclick="getMessage()" value="Proses Upload">
                        @error('foto')
                        <div class="text-danger font-italic">{{$message}}</div>
                        @enderror  
                        </div>
                        <hr>
                       
                    </form>
                </div>
                    
                
            </div>
        </div>
    </div>
</div> 
    </div>
</div>
@endsection