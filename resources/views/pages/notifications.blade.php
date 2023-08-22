<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="notifications"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Notifications"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="card mt-4">

                        <div class="card-body p-3 pb-0">
                            <div class="alert alert-primary alert-dismissible text-white" role="alert">
                                <span class="text-sm">A simple primary alert with <a href="javascript:;"
                                        class="alert-link text-white">an example link</a>. Give it a click if you
                                    like.</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-secondary alert-dismissible text-white" role="alert">
                                <span class="text-sm">A simple secondary alert with <a href="javascript:;"
                                        class="alert-link text-white">an example link</a>. Give it a click if you
                                    like.</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">A simple success alert with <a href="javascript:;"
                                        class="alert-link text-white">an example link</a>. Give it a click if you
                                    like.</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                <span class="text-sm">A simple danger alert with <a href="javascript:;"
                                        class="alert-link text-white">an example link</a>. Give it a click if you
                                    like.</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-warning alert-dismissible text-white" role="alert">
                                <span class="text-sm">A simple warning alert with <a href="javascript:;"
                                        class="alert-link text-white">an example link</a>. Give it a click if you
                                    like.</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-info alert-dismissible text-white" role="alert">
                                <span class="text-sm">A simple info alert with <a href="javascript:;"
                                        class="alert-link text-white">an example link</a>. Give it a click if you
                                    like.</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-light alert-dismissible text-white" role="alert">
                                <span class="text-sm">A simple light alert with <a href="javascript:;"
                                        class="alert-link text-white">an example link</a>. Give it a click if you
                                    like.</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-dark alert-dismissible text-white" role="alert">
                                <span class="text-sm">A simple dark alert with <a href="javascript:;"
                                        class="alert-link text-white">an example link</a>. Give it a click if you
                                    like.</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="position-fixed bottom-1 end-1 z-index-2">

                <div class="toast fade hide p-2 bg-white" role="alert" aria-live="assertive" id="successToast"
                    aria-atomic="true">
                    <div class="toast-header border-0">
                        <i class="material-icons text-success me-2">
                            check
                        </i>
                        <span class="me-auto font-weight-bold">Material Dashboard </span>
                        <small class="text-body">11 mins ago</small>
                        <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                            aria-label="Close"></i>
                    </div>
                    <hr class="horizontal dark m-0">
                    <div class="toast-body">
                        Hello, world! This is a notification message.
                    </div>
                </div>

            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>
