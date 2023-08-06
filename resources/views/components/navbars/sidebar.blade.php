@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('assets') }}/img/logo_mini_telkom.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">DASHBOARD OBL</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Personal</h6>
            </li>
            <li class="nav-item">
              @if($is_user->role_id == 1 || $is_user->role_id == 2 || $is_user->role_id == 3 || $is_user->role_id == 7 || $is_user->role_id == 8 || $is_user->role_id == 9)
              <a class="nav-link text-white {{ $activePage == 'user-profile' ? ' active bg-gradient-info' : '' }}  "
                  href="{{ route('user-profile') }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">person</i>
                  </div>
                  <span class="nav-link-text ms-1">PROFILE</span>
              </a>
              @elseif( $is_user->role_id == 4 || $is_user->role_id == 5  )
              <a class="nav-link text-white {{ $activePage == 'user-profile' ? ' active bg-gradient-primary' : '' }}  "
                  href="{{ route('user-profile') }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">person</i>
                  </div>
                  <span class="nav-link-text ms-1">PROFILE</span>
              </a>
              @else
              <a class="nav-link text-white {{ $activePage == 'user-profile' ? ' active bg-gradient-warning' : '' }}  "
                  href="{{ route('user-profile') }}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">person</i>
                  </div>
                  <span class="nav-link-text ms-1">PROFILE</span>
              </a>
              @endif

            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages</h6>
            </li>
            <li class="nav-item">
                @if($is_user->role_id == 1 || $is_user->role_id == 2 || $is_user->role_id == 3 || $is_user->role_id == 7 || $is_user->role_id == 8 || $is_user->role_id == 9)
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-info' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">DASHBOARD</span>
                </a>
                @elseif( $is_user->role_id == 4 || $is_user->role_id == 5  )
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">DASHBOARD</span>
                </a>
                @else
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-warning' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">DASHBOARD</span>
                </a>
                @endif
            </li>

            <!-- OBL -->
            @if( $is_user->role_id == 2 || $is_user->role_id == 8 || $is_user->role_id == 9 )
            <li class="nav-item dropdown align-items-center">
                <a href="javascript:;" class="nav-link text-white {{ $activePage == 'inputs' || $activePage == 'obl-tables'  || $activePage == 'obl-drafs' || $activePage == 'obl-drafs-edit' ? ' active bg-gradient-info' : '' }}"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">article</i>
                    </div>
                    <span class="nav-link-text ms-1">OBL</span>
                </a>
                <ul class="dropdown-menu  dropdown-menu-end"
                    aria-labelledby="dropdownMenuButton">
                    @if( $is_user->role_id == 2 || $is_user->role_id == 8 || $is_user->role_id == 9 )
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="{{ route('inputs') }}">
                            <div class="d-flex py-1">
                                <div class="my-auto">
                                    <i class="material-icons opacity-10 me-2">note_add</i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        <span class="font-weight-bold">Input Form</span>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endif
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="{{ route('obl.tables') }}">
                            <div class="d-flex py-1">
                                <div class="my-auto">
                                    <i class="material-icons opacity-10 me-2">table_view</i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        <span class="font-weight-bold">Tabel Dokumen</span>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <!-- END OBL -->

            <!-- OBL VIEW  -->
            @if( $is_user->role_id == 1 || $is_user->role_id == 3 || $is_user->role_id == 7)
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'obl-tables' ? ' active bg-gradient-info' : '' }} "
                    href="{{ route('obl.tables') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">article</i>
                    </div>
                    <span class="nav-link-text ms-1">OBL</span>
                </a>
            </li>
            @endif
            <!-- END OBL VIEW -->

            <!-- WITEL -->
            @if( $is_user->role_id == 4 || $is_user->role_id == 9 )
            <li class="nav-item dropdown align-items-center">
                <a href="javascript:;" class="nav-link text-white {{ $activePage == 'witels' || $activePage == 'obl-tables' ? ' active bg-gradient-primary' : '' }}"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">article</i>
                    </div>
                    <span class="nav-link-text ms-1">WITEL</span>
                </a>
                <ul class="dropdown-menu  dropdown-menu-end"
                    aria-labelledby="dropdownMenuButton">
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="{{ route('witels') }}">
                            <div class="d-flex py-1">
                                <div class="my-auto">
                                    <i class="material-icons opacity-10 me-2">note_add</i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        <span class="font-weight-bold">Input Form</span>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a class="dropdown-item border-radius-md" href="{{ route('obl.tables') }}">
                            <div class="d-flex py-1">
                                <div class="my-auto">
                                    <i class="material-icons opacity-10 me-2">table_view</i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        <span class="font-weight-bold">Tabel Dokumen</span>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <!-- END WITEL -->

            <!-- WITEL VIEW  -->
            @if( $is_user->role_id == 5 )
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'obl-tables' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('obl.tables') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">article</i>
                    </div>
                    <span class="nav-link-text ms-1">WITEL</span>
                </a>
            </li>
            @endif
            <!-- END WITEL VIEW -->

            <!-- MITRA -->
            @if( $is_user->role_id == 6 || $is_user->role_id == 9 )
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'obl-tables' ? ' active bg-gradient-warning' : '' }} "
                    href="{{ route('obl.tables') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">article</i>
                    </div>
                    <span class="nav-link-text ms-1">MITRA</span>
                </a>
            </li>
            @endif
            <!-- END MITRA -->

        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <!-- <div class="mx-3">
            <a class="btn bg-gradient-primary w-100" href="../../documentation/getting-started/installation.html" target="_blank">View documentation</a>
        </div>
        <div class="mx-3">
            <a class="btn bg-gradient-primary w-100"
                href="https://www.creative-tim.com/product/material-dashboard-pro-laravel" target="_blank" type="button">Upgrade
                to pro</a>
        </div> -->
    </div>
</aside>
