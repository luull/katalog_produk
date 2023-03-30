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
    @if(request()->segment(1) !== "categoryproduct")
        <div class="containerr">
            @include('sweetalert::alert')
            @yield('content')
        </div>
    @else
        @include('sweetalert::alert')
        @yield('content')
    @endif
    @include("templates.footer")
    <script src="{{ asset('templates/assets/js/libs/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('templates/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{ asset('templates/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('templates/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('templates/plugins/blockui/jquery.blockUI.min.js')}}"></script>
    <script src="{{ asset('templates/assets/js/app.js')}}"></script>
    <script>
        //code = 2k minified
    function createAuto (i, elem) {
    console.log('q');
        var input = $(elem);
        var dropdown = input.closest('.dropdown');
        var menu = dropdown.find('.dropdown-menu');
        var listContainer = dropdown.find('.list-autocomplete');
        var listItems = listContainer.find('.dropdown-item');
        var hasNoResults = dropdown.find('.hasNoResults');
        var clear = dropdown.find('.bl');
    
        listItems.hide();

        listItems.each(function() {
             $(this).data('value', $(this).text() );  
             //!important, keep this copy of the text outside of keyup/input function
        });
        
        input.on("input", function(e){
            
            if((e.keyCode ? e.keyCode : e.which) == 13)  {
                $(this).closest('.dropdown').removeClass('open').removeClass('in');
                return; //if enter key, close dropdown and stop
            }
            if((e.keyCode ? e.keyCode : e.which) == 9) {
                return; //if tab key, stop
            }
    
          
            var query = input.val().toLowerCase();
    
            if( query.length > 1) {
    
                menu.addClass('show');
              
                listItems.each(function() {
                 
                  var text = $(this).data('value');             
                  if ( text.toLowerCase().indexOf(query) > -1 ) {
     
                    var textStart = text.toLowerCase().indexOf( query );
                    var textEnd = textStart + query.length;
                    var htmlR = text.substring(0,textStart) + '<em>' + text.substring(textStart,textEnd) + '</em>' + text.substring(textEnd+length);
                    $(this).html( htmlR );               
                    $(this).show();
         
     
                  } else { 
                  
                    $(this).hide(); 
                  
                  }
                });
              
                var count = listItems.filter(':visible').length;
                ( count > 0 ) ? hasNoResults.hide() : hasNoResults.show();
    
            } else {
                listItems.hide();
                dropdown.removeClass('open').removeClass('in');
                hasNoResults.show();
            }
        });
    
          listItems.on('click', function(e) {
            var txt = $(this).text().replace(/^\s+|\s+$/g, "");  //remove leading and trailing whitespace
            input.val( txt );
            menu.removeClass('show');
            $( "#form" ).submit();
            });
            clear.on('click', function(e) {
                $("#cari" ).val('');
                $("#icon-clear" ).removeClass('fa-close')
            });
            
    }
    
    $('.jAuto').each( createAuto );
    
    
    $(document).on('focus', '.jAuto', function() {
         $(this).select();  // in case input text already exists
    });
      
    $(document).mouseup(function (e) { 
      if ($(e.target).closest(".dropdown").length === 0) {
          $('.dropdown-menu').removeClass('show');
      }
    });
    </script>
    <script>
        $(document).ready(function() {
            $("#icon-clear" ).removeClass('fa-close')
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
