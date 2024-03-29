<x-layout bodyClass="bg-gray-200">

        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    <!-- Navbar -->
                    <x-navbars.navs.guest signin='login' signup='register'></x-navbars.navs.guest>
                    <!-- End Navbar -->
                </div>
            </div>
        </div>

        <main class="main-content  mt-0">
            <div class="page-header align-items-start min-vh-100"
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container mt-5">
                    <div class="row signin-margin">
                        <div class="col-lg-4 col-md-8 col-12 mx-auto">
                            <div class="card z-index-0 fadeIn3 fadeInBottom">
                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                    <div class="bg-gradient-light shadow-danger border-radius-lg py-3 pe-1">
                                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                                          <img type="image/png" src="{{ asset('assets') }}/img/logo_telkom.png" alt="" width="40%" height="40%">
                                        </h4>
                                        <br><br>
                                        <h5 class="font-weight-bolder text-center mt-2 mb-0" style="color:#363636;">Dashboard OBL</h5>
                                            <h6 class='text-center' style="color:#363636;">
                                                <span class="font-weight-normal">by</span> SDA</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                                        @csrf
                                        @if ( Session::has('status') )
                                            @if( str_contains(Session::get('status'),'Oops') )
                                            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                                <span class="text-sm">{{ Session::get('status') }}</span>
                                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @else
                                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                                <span class="text-sm">{{ Session::get('status') }}</span>
                                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                        @endif
                                        @error('username')
                                        <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                            <span class="text-sm">{{ $message }}</span>
                                            <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @enderror
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" autocomplete="off">
                                        </div>
                                        <div class="input-group input-group-outline mt-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" autocomplete="off">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-light shadow-danger w-100 my-4 mb-2">Sign
                                                in</button>
                                        </div>
                                        <p class="mt-4 text-sm text-center">
                                            Belum Memiliki Akun?
                                            <a href="{{ route('register') }}"
                                                class="text-primary text-gradient font-weight-bold">Klik di sini</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @push('js')
<script src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script>
    $(function() {

    var text_val = $(".input-group input").val();
    if (text_val === "") {
      $(".input-group").removeClass('is-filled');
    } else {
      $(".input-group").addClass('is-filled');
    }
});
</script>
@endpush
</x-layout>
