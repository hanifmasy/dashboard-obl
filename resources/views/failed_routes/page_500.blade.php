<x-layout bodyClass="bg-gray-200">

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100">
            <span class="mask bg-gradient-light opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-12 mx-auto align-items-center text-center">
                      <img src="{{ asset('assets') }}/img/page_500_2.png" class="text-white" alt="" width="70%"><br>
                      <a class="btn btn-lg ps-8" href="{{ route('dashboard') }}"><h4 style="color: #555555;">
                              <i class="material-icons opacity-10">arrow_back</i>
                          <span class="">BACK TO DASHBOARD</span></h4>
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-layout>
