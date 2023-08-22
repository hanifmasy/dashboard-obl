@props(['titlePage'])

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                @if( $is_user->role_id == 1 || $is_user->role_id == 2 || $is_user->role_id == 3 || $is_user->role_id == 7 || $is_user->role_id == 8 || $is_user->role_id == 9 )
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"> Hi, {{ $is_user->nama_lengkap }} </li>
                @elseif( $is_user->role_id == 4 || $is_user->role_id == 5 )
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"> WITEL {{ $is_user->nama_lengkap }}</li>
                @elseif( $is_user->role_id == 6 )
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"> MITRA: {{ $is_user->nama_lengkap }}</li>
                @endif
            </ol>
              @if( $is_user->role_id == 1 || $is_user->role_id == 2 )
              <h6 class="font-weight-bolder mb-0"> OBL / {{ $titlePage }}</h6>
              @elseif( $is_user->role_id == 7 || $is_user->role_id == 8 )
              <h6 class="font-weight-bolder mb-0"> SOLUTION / {{ $titlePage }}</h6>
              @elseif( $is_user->role_id == 3 )
              <h6 class="font-weight-bolder mb-0"> PJM / {{ $titlePage }}</h6>
              @elseif( $is_user->role_id == 4 || $is_user->role_id == 5 )
              <h6 class="font-weight-bolder mb-0"> WITEL / {{ $titlePage }}</h6>
              @elseif( $is_user->role_id == 6 )
              <h6 class="font-weight-bolder mb-0"> MITRA / {{ $titlePage }}</h6>
              @elseif( $is_user->role_id == 9 )
              <h6 class="font-weight-bolder mb-0"> NOUS / {{ $titlePage }}</h6>
              @endif
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">

            <!-- search bar line -->
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                    <!-- <label class="form-label">Type here...</label>
                    <input type="text" class="form-control"> -->
                </div>
            </div>
            <!-- end search bar line -->

            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                @csrf
            </form>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign
                            Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
