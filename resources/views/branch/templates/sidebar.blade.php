<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu {{ Request::is('branch/dashboard') ? 'active' : '' }}">
                <a href="/branch/dashboard" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="menu {{ Request::is('branch/produk') ? 'active' : '' }}">
                <a href="/branch/produk" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="gift"></i>
                        <span>Daftar Produk</span>
                    </div>
                </a>
            </li>




            <li class="menu {{ Request::is('branch/transaksi') ? 'active' : '' }}">
                <a href="#product" data-toggle="collapse"
                    aria-expanded="{{ Request::is('branch/transaksi') ? 'true' : '' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-airplay">
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                            <polygon points="12 15 17 21 7 21 12 15"></polygon>
                        </svg>
                        <span>Data Transaksi</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ Request::is('product/branch', 'product/branch') ? 'show' : '' }}"
                    id="product" data-parent="#product" style="overflow:auto !important">
                    <li class="{{ Request::is('branch/transaction/by_date', 'product/branch') ? 'active' : '' }}">
                        <a href="/branch/transaction/by_date"> Per tanggal </a>
                    </li>
                    <li class="{{ Request::is('branch/transaction/by_month') ? 'active' : '' }}">
                        <a href="/branch/transaction/by_month"> Per Bulan </a>
                    </li>
                    <li class="{{ Request::is('branch/transaction/by_year') ? 'active' : '' }}">
                        <a href="/branch/transaction/by_year"> Per Tahun </a>
                    </li>
                    <li class="{{ Request::is('branch/transaction') ? 'active' : '' }}">
                        <a href="/branch/transaction/"> Seluruhya </a>
                    </li>

                </ul>
            </li>


        </ul>

    </nav>

</div>
