<x-layout bodyClass="">

    <div>
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
            <section>
                <div class="page-header min-vh-100">
                    <div class="container">
                        <div class="row">
                            <div
                                class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto">
                                <div class="card card-plain">
                                    <div class="card-header">
                                        <h4 class="font-weight-bolder">Mendaftar Akun</h4>
                                        <p class="mb-0">Masukkan Nama Lengkap, Email, dan Password Anda.</p>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="input-group input-group-outline mt-3">
                                                <label class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" name="nama_lengkap"
                                                    value="{{ old('nama_lengkap') }}">
                                            </div>
                                            @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                            <div class="input-group input-group-outline mt-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" name="username"
                                                    value="{{ old('username') }}">
                                            </div>
                                            @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                            <div class="input-group input-group-outline mt-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ old('email') }}">
                                            </div>
                                            @error('email')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                            <div class="input-group input-group-outline mt-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                            @error('password')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-lg bg-gradient-light shadow-primary btn-lg w-100 mt-4 mb-0">Sign
                                                    Up</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

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
