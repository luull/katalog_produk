<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PENDAFTARAN {{env('ISTILAH_MEMBER')}}</title>
    {{-- <link rel="icon" type="image/x-icon" href="{{ asset('templates/assets/img/favicon.ico')}}"/> --}}
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{ asset('templates/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/authentication/form-2.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('templates/assets/css/forms/theme-checkbox-radio.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('templates/assets/css/forms/switches.css')}}">
</head>
<body class="form">


    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h4 class="">PENDAFTARAN {{env('ISTILAH_MEMBER')}} {{env('STORE_NAME')}}</h4>
                        <p class="">Direfferensikan oleh {{session('data_refferal')->nama}}</p>
                        @if (session('message'))
                        <div class="alert alert-warning alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button> {{ session('message') }}</div>
                        @endif
                        <form class="text-left" action="{{ route('proses-registrasi') }}" method="post">
                            @csrf
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">USERNAME</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="username" type="text" class="form-control" placeholder="Username" value="{{ old('username')}}">
                                    @error('username')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" value="{{old('password')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <div id="name-field" class="field-wrapper input">
                                    <label for="name">NAMA LENGKAP</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                     <input id="name" name="name" type="text" class="form-control" placeholder="Nama Lengkap" value="{{ old('name')}}">

                                    @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="email-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="email">EMAIL</label>
                                    </div>
                                    <i data-feather="slack"></i>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Alamat Email" value="{{old('email')}}">
                                    @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                    <div id="phone-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="phone">HANDPHONE</label>
                                    </div>
                                    <input id="phone" name="phone" type="text" class="form-control" placeholder="Nomor Handphone" value="{{old('phone')}}">
                                    @error('phone')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Proses Pendaftaran</button>
                                    </div>
                                </div>

                               
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('templates/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('templates/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{ asset('templates/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('templates/plugins/font-icons/feather/feather.min.js')}}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('templates/assets/js/authentication/form-2.js')}}"></script>

</body>
</html>
