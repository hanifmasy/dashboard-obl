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
                            Testing.
                            <button type="button" class="btn btn-lg bg-gradient-secondary" id="btn-show-alert" name="button">Click</button>
                        </div>
                    </div>

                </div>
            </div>

            <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
              <div class="toast fade hide p-2 bg-white" role="alert" aria-live="assertive" aria-atomic="true" id="alertToast" >
                <div class="toast-header">
                  <strong class="ml-auto">Status Tabel Dokumen:</strong>
                </div>
                <div class="toast-body">
                  <div class="alert alert-warning alert-dismissible text-white" role="alert">
                      <h5 class="text-sm text-white text-uppercase text-center">Tidak Ada Data.</h5>
                  </div>
                </div>
                <div class="toast-footer">
                  <button type="button" class="btn btn-link bg-gradient-secondary" data-bs-dismiss="toast" aria-label="Close" style="float:right;">
                    <span aria-hidden="true" >OK</span>
                  </button>
                </div>
              </div>
            </div>


        </div>
    </main>
    @push('js')
    <script type="text/javascript">
    $('#btn-show-alert').click(function(){
      $('#alertToast').toast('show');
    });
    </script>
    @endpush
</x-layout>
