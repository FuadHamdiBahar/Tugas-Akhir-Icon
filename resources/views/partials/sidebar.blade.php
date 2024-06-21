<div class="iq-sidebar  sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="/" class="header-logo">
            <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid rounded-normal light-logo" alt="logo">
            {{-- <h5 class="logo-title light-logo ml-3">PLN Icon PLus</h5> --}}
        </a>
        <div class="iq-menu-bt-sidebar ml-0">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="{{ Request::path() == '/' ? 'active' : '' }}">
                    <a href="/" class="svg-icon">
                        <svg class="svg-icon" id="p-dash1" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                            </path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        <span class="ml-4">Dashboards</span>
                    </a>
                </li>

                <li class="{{ str_contains(Request::path(), 'utilisation') ? 'active' : '' }}">
                    <a href="#product" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash3" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                        <span class="ml-4">SBU</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="product" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="">
                            <a href="{{ route('utilisation', 'sumbagut') }}">
                                <i class="las la-minus"></i><span>Sumbagut</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'sumbagteng') }}">
                                <i class="las la-minus"></i><span>Sumbagteng</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'sumbagsel') }}">
                                <i class="las la-minus"></i><span>Sumbagsel</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'jakarta') }}">
                                <i class="las la-minus"></i><span>Jakarta</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'jabar') }}">
                                <i class="las la-minus"></i><span>Jawa Barat</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'jateng') }}">
                                <i class="las la-minus"></i><span>Jawa Tengah</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'jatim') }}">
                                <i class="las la-minus"></i><span>Jawa Timur</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'balnus') }}">
                                <i class="las la-minus"></i><span>Balnus</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'kal') }}">
                                <i class="las la-minus"></i><span>Kalimantan</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('utilisation', 'ibt') }}">
                                <i class="las la-minus"></i><span>IBT</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ str_contains(Request::path(), 'ring') ? 'active' : '' }}">
                    <a href="#ring" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <svg class="svg-icon" id="p-dash7" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span class="ml-4">Ring</span>
                        <svg class="svg-icon iq-arrow-right arrow-active" width="20" height="20"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="10 15 15 20 20 15"></polyline>
                            <path d="M4 4h7a4 4 0 0 1 4 4v12"></path>
                        </svg>
                    </a>
                    <ul id="ring" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class="">
                            <a href="{{ route('ring', 'sumbagut') }}">
                                <i class="las la-minus"></i><span>Sumbagut</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'sumbagteng') }}">
                                <i class="las la-minus"></i><span>Sumbagteng</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'sumbagsel') }}">
                                <i class="las la-minus"></i><span>Sumbagsel</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'jakarta') }}">
                                <i class="las la-minus"></i><span>Jakarta</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'jabar') }}">
                                <i class="las la-minus"></i><span>Jawa Barat</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'jateng') }}">
                                <i class="las la-minus"></i><span>Jawa Tengah</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'jatim') }}">
                                <i class="las la-minus"></i><span>Jawa Timur</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'balnus') }}">
                                <i class="las la-minus"></i><span>Balnus</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'kal') }}">
                                <i class="las la-minus"></i><span>Kalimantan</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('ring', 'ibt') }}">
                                <i class="las la-minus"></i><span>IBT</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

    </div>
</div>
