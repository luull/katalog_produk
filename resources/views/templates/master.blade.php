<!DOCTYPE html>
<html lang="en" class="sidebar-noneoverflow">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env('STORE_NAME')}}</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="{{ asset('templates/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/components/custom-carousel.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="{{ asset('templates/plugins/font-icons/fontawesome/css/regular.css')}}">
    <link rel="stylesheet" href="{{ asset('templates/plugins/font-icons/fontawesome/css/fontawesome.css')}}"> --}}
    <link href="{{ asset('templates/assets/css/components/tabs-accordian/custom-accordions.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/elements/breadcrumb.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/elements/search.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('templates/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}">
    <link href="{{ asset('templates/assets/css/elements/infobox.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('templates/assets/css/components/custom-modal.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('templates/plugins/bootstrap-select/bootstrap-select.min.css')}}">
    <link href="{{ asset('templates/assets/css/components/custom-list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('templates/assets/css/components/timeline/custom-timeline.css')}}" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    @yield('myStyle')
</head>
<body class="sidebar-noneoverflow" data-spy="scroll" data-target="#navSection" data-offset="100">
    @include("templates.navbar")
    <div class="containerr">
        @yield('content')
    </div>
    @include("templates.footer")
    <script src="{{ asset('templates/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('templates/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{ asset('templates/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('templates/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('templates/plugins/blockui/jquery.blockUI.min.js')}}"></script>
    <script src="{{ asset('templates/assets/js/app.js')}}"></script>

    <script>
        $(document).ready(function() {
            App.init();
        });
        </script>
    <script src="{{ asset('templates/plugins/highlight/highlight.pack.js')}}"></script>
    <script src="{{ asset('templates/assets/js/custom.js')}}"></script>
    <script src="{{ asset('templates/assets/js/scrollspyNav.js')}}"></script>
    <script src="{{ asset('templates/plugins/font-icons/feather/feather.min.js')}}"></script>
    <script src="https://use.fontawesome.com/9a35825826.js"></script>
    <script src="{{ asset('templates/assets/js/components/ui-accordions.js')}}"></script>
    <script src="{{ asset('templates/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ asset('templates/plugins/bootstrap-touchspin/custom-bootstrap-touchspin.js')}}"></script>
    <script src="{{ asset('templates/plugins/bootstrap-select/bootstrap-select.min.js')}}"></script>
    <script type="text/javascript">
        feather.replace();
    </script>
    @yield('script')
</body>

</html>
