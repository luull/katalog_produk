<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="profile-info">
            <figure class="user-cover-image"></figure>
            <div class="user-info">

                <img src="{{ asset(session('backend-session')->foto) }}" alt="avatar">
                <h6 class="">{{ session('backend-session')->username }}</h6>
                <p class="">{{ session('backend-session')->level_admin->nama }}</p>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample" style="height:350px;overflow: scroll">
            <li class="menu {{ Request::is('backend/dashboard') ? 'active' : '' }}">
                <a href="/backend/dashboard" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::is('backend/admin') ? 'active' : '' }}">
                <a href="/backend/admin" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="user-plus"></i>
                        <span>Admin Manager</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::is('backend/branch') ? 'active' : '' }}">
                <a href="/backend/branch" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="users"></i>
                        <span>Mitrasalur</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ Request::is('backend/pages') ? 'active' : '' }}">
                <a href="/backend/pages" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="layout"></i>
                        <span>Pages</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::is('backend/bank') ? 'active' : '' }}">
                <a href="/backend/bank" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="slack"></i>
                        <span>Bank</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::is('banner/backend') ? 'active' : '' }}">
                <a href="/banner/backend" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="image"></i>
                        <span>Banner</span>
                    </div>
                </a>
            </li>


            <li class="menu {{ Request::is('backend/product', 'product/backend') ? 'active' : '' }}">
                <a href="#product" data-toggle="collapse"
                    aria-expanded="{{ Request::is('backend/product', 'product/backend') ? 'true' : '' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="gift"></i>
                        <span>Product</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('product/backend', 'product/backend') ? 'show' : '' }}"
                    id="product" data-parent="#product" style="overflow:auto !important">
                    <li class="{{ Request::is('product/backend', 'product/backend') ? 'active' : '' }}">
                        <a href="/product/backend"> Daftar Produk </a>
                    </li>
                    <li class="{{ Request::is('backend/product/display') ? 'active' : '' }}">
                        <a href="/backend/product/display"> Produk Pilihan </a>
                    </li>
                    <li class="{{ Request::is('backend/product/category/') ? 'active' : '' }}">
                        <a href="/backend/category"> Kategori </a>
                    </li>
                    <li class="{{ Request::is('backend/subcategory') ? 'active' : '' }}">
                        <a href="/backend/subcategory"> Sub Kategori </a>
                    </li>
                    <li class="{{ Request::is('backend/subsubcategory') ? 'active' : '' }}">
                        <a href="/backend/subsubcategory"> Sub Sub Kategori </a>
                    </li>
                    <li class="{{ Request::is('backend/satuan') ? 'active' : '' }}">
                        <a href="/backend/satuan">Satuan Produk </a>
                    </li>
                </ul>
            </li>


        </ul>

    </nav>

</div>
