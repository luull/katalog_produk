  <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <ul class="navbar-nav theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="/">
                        <img src="{{ asset('images/logo.png')}}" class="navbar-logo" style="height: 60px;width:auto" alt="{{env('STORE_NAME')}}" title="{{env('STORE_NAME')}}">
                    </a>
                </li>
            </ul>
            <ul class="navbar-item flex-row search-ul">
                <li class="nav-item align-self-center search-animated">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <form class="form-inline search-full form-inline search" id="form" role="search" action="{{ route('findproduk') }}"  method="GET" >
                        <div class="search-bar">

                            <input type="text" class="form-control search-form-control ml-lg-auto" name="search" value="{{ $search ?? '' }}" placeholder="Search..." style="height: 35px">
                        </div>
                        {{-- <button type="submit" class="btn btn-success btnsearch ml-2">Cari</button> --}}
                    </form>
                </li>
            </ul>
            <ul class="navbar-item flex-row navbar-dropdown">
                
                @if (session('user-session') == null)
                  {{-- <li class="nav-item ml-3 ">
                    <a href="/display-product" class="btn btn-success mt-2">Produk</a>
                </li> --}}
                <li class="nav-item ml-3">
                    <a href="/login" class="btn btn-outline-success mt-2">Masuk</a>
                </li>
                <li class="nav-item ml-3 mr-4">
                    <a href="/register" class="btn btn-success mt-2">Daftar</a>
                </li>
                @else
                 <li class="nav-item align-self-center ml-3">
                    <a href="/display-product" class="position-relative"><i class="fa fa-cubes" title="Daftar Produk" style="color:#686868;font-size:24px;"></i></a>
                </li>
                @if (session('countcart') != 'kosong')
                <li class="nav-item align-self-center ml-3">
                   <a href="/cart" class="position-relative"><span class="badge badge-danger badge-sm counter p-0">{{session('countcart')}}</span> <i class="fa fa-shopping-cart" style="color:#686868;font-size:24px;"></i></a>
                </li>
                @else
                <li class="nav-item align-self-center ml-3">
                   <a href="/cart" class="position-relative"><i class="fa fa-shopping-cart" style="color:#686868;font-size:24px;" title="Keranjang ({{session('countcart')}})"></i></a>
                </li>

                @endif
                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-profile-section mt-2">
                        <div class="media mx-auto">
                            @if (session('user-session')->photo != null)
                            <img src="{{ asset(session('user-session')->photo)}}" class="img-fluid mr-2" style="width:40px !important;height:auto;background-size: cover;" alt="avatar">
                            @else
                            <img src="{{ asset('default-user.jpeg')}}" class="img-fluid mr-2" style="width:40px !important;height:auto;background-size: cover;" alt="avatar">
                            @endif
                            <div class="align-self-center">
                                <p class="size-12">{{session('user-session')->name}}</h5>
                            </div>
                        </div>
                    </div>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="dropdown-item">
                            <a href="/">
                                <i data-feather="home"></i><span>Home</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="/dashboard">
                                <i data-feather="user"></i><span>Profil</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="/display-product">
                                <i class="fa fa-cubes"></i> <span>Product</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="/myorder">
                                <i data-feather="truck"></i><span>Pesanan Saya</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="/logout">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                            </a>
                        </div>
                    </div>
                </li>
                @endif
            </ul>
        </header>
    </div>
<script>
    document.getElementById('body').onkeyup = function(e) {
  if (e.keyCode === 13) {
    document.getElementById('form').submit(); // your form has an id="form"
  }
  return true;
 }
</script>