<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="obl-upload"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="UPLOAD FILE"></x-navbars.navs.auth>
            <!-- End Navbar -->

            <style media="screen">
            .bg-upload-title{
              background: rgb(114,137,218);
background: linear-gradient(90deg, rgba(114,137,218,1) 0%, rgba(161,175,226,1) 84%, rgba(181,190,221,1) 100%);
box-shadow: 2px 1px 2px 1px rgb(114,137,218);
            }
            .bg-upload-btn{
              background: rgb(114,137,218);
            }
            </style>

            <!-- modal alerts -->
            <div class="modal fade" id="modal-input-obl" tabindex="-1" aria-labelledby="modal-input-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Upload File:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="status-input-obl">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- end modal alerts -->


            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12 mx-auto">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-upload-title border-radius-lg pt-4 pb-3">
                                    @if(isset($upload_doc))
                                    <h6 class="text-white text-capitalize ps-3">UPLOAD FILE: <div style="font-size: 24px;">&nbsp; {{ $upload_doc[0]['f1_segmen'] }} &nbsp; {{ $upload_doc[0]['folder'] }} &nbsp;|&nbsp; {{ $upload_doc[0]['f1_judul_projek'] }} </div></h6>
                                    @else
                                    <h6 class="text-white text-capitalize ps-3">UPLOAD FILE</h6>
                                    @endif
                                </div>
                            </div>

                            @if($errors->any())
                            <div class="card">
                              <div class="card-body">
                                <div class="border-radius-sm">
                                  <div class="alert alert-danger alert-dismissible text-align-center">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                      <div style="color:white;" class="text-center">
                                          <strong>INPUTAN BELUM VALID. CEK KEMBALI INPUTAN ANDA.</strong>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            @endif

                            <form id="formObl" action="{{ route('witels.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table id="table-input-obl" class="table align-items-center mb-0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr class="kepala">
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Inputan
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Inputan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- filter kontrak -->
                                            <tr ><td colspan="2"><br></td></tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Quote</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input style="width:350px;" type="text" name="f1_quote_kontrak" id="f1_quote_kontrak" value="{{ old('f1_quote_kontrak','') }}">
                                                </td>
                                            </tr>
                                            <tr ><td colspan="2"><br></td></tr>
                                            <tr ><td colspan="2">
                                                <button type="submit" name="submit" value="submit_witel" class="btn bg-upload-btn"><h6 class="mb-0 text-sm" style="color:white;">Submit</h6></button>
                                            </td></tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        @push('js')
        <script>
            $( document ).ready(function() {


            });

        </script>
        @endpush
</x-layout>
