<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="obl-tables-edit"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="TABEL DOKUMEN / EDIT"></x-navbars.navs.auth>
            <!-- End Navbar -->

            <style media="screen">
              .bg-gradient-edit{
                background: rgb(59,89,152);
                background: linear-gradient(90deg, rgba(59,89,152,1) 0%, rgba(91,111,153,1) 100%, rgba(111,123,147,1) 100%);
              }
            </style>


            <!-- modal alerts -->
            <div class="modal fade" id="modal-input-obl" tabindex="-1" aria-labelledby="modal-input-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Submit Form OBL</h5>
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
                              @if( isset($user_edit) )
                                @if( $user_edit->role_id === 4 )
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-capitalize text-white ps-3">TABEL DOKUMEN: EDIT</h6>
                                </div>
                                @elseif( $user_edit->role_id === 2 || $user_edit->role_id === 8 || $user_edit->role_id === 9 )
                                <div class="bg-gradient-edit border-radius-lg pt-4 pb-3">
                                    <h6 class="text-capitalize text-white ps-3">TABEL DOKUMEN: EDIT</h6>
                                </div>
                                @endif
                              @endif

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

                            <form id="formObl" action="{{ route('obl.tables.edit.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if( isset($user_edit) )
                              @if( $user_edit->role_id === 4 )
                              <x-edits.witel :table_edit="$table_edit" :mitra_vendor="$mitra_vendor"></x-edits.witel>
                              @elseif( $user_edit->role_id === 2 || $user_edit->role_id === 8  || $user_edit->role_id === 9 )
                              <x-edits.obl :table_edit="$table_edit" :table_edit_keterangan="$table_edit_keterangan" :mitra_vendor="$mitra_vendor"></x-edits.obl>
                              @endif
                            @else
                            DATA PARSING KOSONG!
                            @endif
                            </form>
                        </div>
                    </div>
                </div>

                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        @push('js')

        @if( isset($user_edit) )
          @if( $user_edit->role_id === 4 )
          <x-editsjs.witel :table_edit="$table_edit"></x-editsjs.witel>
          @elseif( $user_edit->role_id === 2 || $user_edit->role_id === 8 || $user_edit->role_id === 9 )
          <x-editsjs.obl :table_edit="$table_edit" :table_edit_keterangan="$table_edit_keterangan" :table_edit_p4_attendees="$table_edit_p4_attendees"></x-editsjs.obl>
          @endif
        @else
        DATA PARSING KOSONG!
        @endif

        @endpush
</x-layout>
