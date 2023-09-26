<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="inputs-master"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="MASTER INPUT"></x-navbars.navs.auth>
            <!-- End Navbar -->

            <style media="screen">
            .dataTables_filter {
                float: left !important;
                margin-left: -101%;
            }

            /* th,
            tr,
            td {
              border: 4px double red;
              padding: 10px;
              width: 50vw
            } */

            #card_mitra, #card_tgl, #card_ttd {
              display: none;
            }

            #table_mitra, #table_tgl, #table_ttd {
              display: none;
            }

            </style>

            <!-- modal alerts -->
            <div class="modal fade" id="modal-input-obl" tabindex="-1" aria-labelledby="modal-input-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Submit Master Input</h5>
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
                            <div class="card-header p-0 position-relative mt-n4 z-index-2">
                                <div class="bg-gradient-light shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-dark text-capitalize ps-3">MASTER INPUT</h6>
                                </div>
                            </div>

                            @if($errors->any())
                            <br>
                            <div class="card mt-1 p-2">
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
                        </div>

                        <div class="row d-flex mt-1 mb-6 ">
                          <div class="col-lg-4">
                            <select autocomplete="off" class="form-control border p-2 bg-gradient-light shadow-primary text-md font-weight-bolder" name="" id="pilih_card">
                              <option value="" selected disabled> <b> Pilih Inputan <b> </option>
                              <option value="card_mitra"> <b> Tambah Mitra <b> </option>
                              <option value="card_tgl"> <b> Tambah Tanggal Libur <b> </option>
                              <option value="card_ttd"> <b> Tambah Penanda Tangan <b> </option>
                            </select>
                          </div>
                        </div>

                        <div class="card my-4" id="card_mitra">
                          <form id="form_mitra" action=""  method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="card-body px-0 pb-2">
                              <h6 class="text-md ms-4 ">TAMBAH MITRA</h6>
                              <div class="table-responsive p-0">
                                  <table id="table-input" class="table align-items-center mb-0" cellspacing="0" cellpadding="0">
                                      <thead>
                                          <tr class="kepala">
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Nama Inputan
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                  Isian Inputan
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr >
                                              <td>
                                                  <div class="d-flex px-2 py-1">
                                                      <div class="d-flex flex-column justify-content-center">
                                                          <h6 class="mb-0 text-sm">Nama Mitra</h6>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td>
                                                  @if($errors->has('nama_mitra'))
                                                    <textarea placeholder="" type="text" cols="45" rows="1" class="outline-input-merah" name="nama_mitra" id="nama_mitra" autocomplete="off">{{ old('nama_mitra','') }}</textarea>
                                                  @else
                                                    <textarea placeholder="" type="text" cols="45" rows="1" name="nama_mitra" id="nama_mitra" autocomplete="off">{{ old('nama_mitra','') }}</textarea>
                                                  @endif
                                              </td>
                                          </tr>
                                          <tr ><td colspan="2">
                                              <input type="text" name="submit" value="submit_master_input_mitra" hidden>
                                              <button onclick="SubmitMitra()" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Submit Mitra</h6></button>
                                          </td></tr>

                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </form>
                        </div>

                        <div class="card my-4" id="card_tgl">
                          <form id="form_tgl"  action="" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="card-body px-0 pb-2">
                            <h6 class="text-md ms-4">TAMBAH TANGGAL LIBUR ( UNTUK TAKAH )</h6>
                              <div class="table-responsive p-0">
                                  <table id="table-input" class="table align-items-center mb-0" cellspacing="0" cellpadding="0">
                                      <thead>
                                          <tr class="kepala">
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Nama Inputan
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                  Isian Inputan
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr >
                                              <td>
                                                  <div class="d-flex px-2 py-1">
                                                      <div class="d-flex flex-column justify-content-center">
                                                          <h6 class="mb-0 text-sm">Tanggal Libur</h6>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td>
                                                  @if($errors->has('tgl_libur_1'))
                                                    <input type="date" class="outline-input-merah" name="tgl_libur_1" id="tgl_libur_1" autocomplete="off" value="{{ old('tgl_libur_1','') }}" >
                                                  @else
                                                    <input type="date" name="tgl_libur_1" id="tgl_libur_1" autocomplete="off" value="{{ old('tgl_libur_1','') }}" >
                                                  @endif
                                              </td>
                                          </tr>
                                          <tr >
                                              <td>
                                                  <div class="d-flex px-2 py-1">
                                                      <div class="d-flex flex-column justify-content-center">
                                                          <h6 class="mb-0 text-sm"> <b>Atau</b> </h6>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td>
                                              </td>
                                          </tr>
                                          <tr >
                                              <td>
                                                  <div class="d-flex px-2 py-1">
                                                      <div class="d-flex flex-column justify-content-center">
                                                          <h6 class="mb-0 text-sm">Tanggal Libur Panjang</h6>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td class="d-flex">
                                                  @if(  $errors->has('tgl_libur_2') || $errors->has('tgl_libur_3')  )
                                                    <b>Dari</b> <input type="date" class="ms-2 outline-input-merah" name="tgl_libur_2" id="tgl_libur_2" autocomplete="off" value="{{ old('tgl_libur_2','') }}" >
                                                    <b class="ms-1">Hingga</b> <input type="date" class="ms-2 outline-input-merah" name="tgl_libur_3" id="tgl_libur_3" autocomplete="off" value="{{ old('tgl_libur_3','') }}" >
                                                  @else
                                                    <b>Dari</b> <input type="date" class="ms-2 " name="tgl_libur_2" id="tgl_libur_2" autocomplete="off" value="{{ old('tgl_libur_2','') }}" >
                                                    <b class="ms-1">Hingga</b> <input type="date" class="ms-2 " name="tgl_libur_3" id="tgl_libur_3" autocomplete="off" value="{{ old('tgl_libur_3','') }}" >
                                                  @endif
                                              </td>
                                          </tr>
                                          <tr ><td colspan="2">
                                              <input type="text" name="submit" value="submit_master_input_tgl" hidden>
                                              <button onclick="SubmitTanggalLibur()" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Submit Tanggal Libur</h6></button>
                                          </td></tr>

                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </form>
                        </div>

                        <div class="card my-4" id="card_ttd">
                          <form id="form_ttd"  action="" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="card-body px-0 pb-2">
                            <h6 class="text-md ms-4">TAMBAH PENANDA TANGAN</h6>
                              <div class="table-responsive p-0">
                                  <table id="table-input" class="table align-items-center mb-0" cellspacing="0" cellpadding="0">
                                      <thead>
                                          <tr class="kepala">
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Nama Inputan
                                              </th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                  Isian Inputan
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr >
                                              <td>
                                                  <div class="d-flex px-2 py-1">
                                                      <div class="d-flex flex-column justify-content-center">
                                                          <h6 class="mb-0 text-sm">Nama / NIK Penanda Tangan</h6>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td>
                                                  @if($errors->has('nama_ttd'))
                                                    <input placeholder="NAMA / NIK" style="width:350px;" type="text" class="outline-input-merah" name="nama_ttd" id="nama_ttd" autocomplete="off" value="{{ old('nama_ttd','') }}" >
                                                  @else
                                                    <input placeholder="NAMA / NIK" style="width:350px;" type="text" name="nama_ttd" id="nama_ttd" autocomplete="off" value="{{ old('nama_ttd','') }}" >
                                                  @endif
                                              </td>
                                          </tr>
                                          <tr >
                                              <td>
                                                  <div class="d-flex px-2 py-1">
                                                      <div class="d-flex flex-column justify-content-center">
                                                          <h6 class="mb-0 text-sm">Jabatan Penanda Tangan</h6>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td class="d-flex">
                                                  @if(  $errors->has('jabatan_ttd')  )
                                                    <select class=" outline-input-merah" name="jabatan_ttd" id="jabatan_ttd" autocomplete="off">
                                                      <option value="" disabled selected>Pilih Jabatan</option>
                                                      <option value="officer">Officer Bidding & Performance Evaluation</option>
                                                      <option value="mgr_bidding">Manager Bidding Management TR VI</option>
                                                      <option value="osm">OSM Regional Enterprise, Government, & Business Service</option>
                                                    </select>
                                                  @else
                                                    <select class="" name="jabatan_ttd" id="jabatan_ttd" autocomplete="off">
                                                      <option value="" disabled selected>Pilih Jabatan</option>
                                                      <option value="officer">Officer Bidding & Performance Evaluation</option>
                                                      <option value="mgr_bidding">Manager Bidding Management TR VI</option>
                                                      <option value="osm">OSM Regional Enterprise, Government, & Business Service</option>
                                                    </select>
                                                  @endif
                                              </td>
                                          </tr>
                                          <tr ><td colspan="2">
                                              <input type="text" name="submit" value="submit_master_input_ttd" hidden>
                                              <button onclick="SubmitTandaTangan()" class="btn bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">Submit Penanda Tangan</h6></button>
                                          </td></tr>

                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </form>
                        </div>

                        <!-- table mitra -->
                            <div class="card my-4" id="table_mitra">
                              <div class="card-body px-0 pb-2">
                                <h5 class="text-md ps-4"> TABEL MITRA </h5>

                                <div class="card-body px-0 pb-2">

                                       <form id="" class="" action="" method="POST" enctype="multipart/form-data">
                                         @csrf
                                        <div class="table-responsive p-3">
                                            <table id="table-mitra" class="table align-items-center justify-content-center mb-0 table-hover text-center" >
                                                <thead>
                                                    <tr >
                                                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            No.
                                                        </th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Nama Mitra
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="align-middle text-center">
                                                </tbody>
                                            </table>
                                        </div>
                                      </form>

                                </div>

                              </div>
                            </div>
                        <!-- end table mitra -->
                        <!-- table tgl -->
                            <div class="card my-4" id="table_tgl">
                              <div class="card-body px-0 pb-2">
                                <h5 class="text-sm ps-4 ">TABEL TANGGAL LIBUR</h5>

                                <div class="card-body px-0 pb-2">

                                       <form id="" class="" action="" method="POST" enctype="multipart/form-data">
                                         @csrf
                                        <div class="table-responsive p-3">
                                            <table id="table-tgl" class="table align-items-center justify-content-center mb-0 table-hover text-center" >
                                                <thead>
                                                    <tr >
                                                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            No.
                                                        </th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Tanggal
                                                        </th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Hari
                                                        </th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Status
                                                        </th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Keterangan
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="align-middle text-center">
                                                </tbody>
                                            </table>
                                        </div>
                                      </form>

                                </div>

                              </div>
                            </div>
                        <!-- end table tgl -->
                        <!-- table ttd -->
                            <div class="card my-4" id="table_ttd">
                              <div class="card-body px-0 pb-2">
                                <h5 class="text-sm ps-4">TABEL PENANDA TANGAN</h5>

                                <div class="card-body px-0 pb-2">

                                       <form id="" class="" action="" method="POST" enctype="multipart/form-data">
                                         @csrf
                                        <div class="table-responsive p-3">
                                            <table id="table-ttd" class="table align-items-center justify-content-center mb-0 table-hover text-center" >
                                                <thead>
                                                    <tr >
                                                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            No.
                                                        </th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Nama / NIK
                                                        </th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Jabatan
                                                        </th>
                                                        <th
                                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Status
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="align-middle text-center">
                                                </tbody>
                                            </table>
                                        </div>
                                      </form>

                                </div>

                              </div>
                            </div>
                        <!-- end table ttd -->

                    </div>
                </div><br>


                <div class="row mt-0" hidden>
                  <div class="col-12 mx-auto">
                    <div class="card my-4">

                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                          <div class="bg-gradient-light shadow-primary border-radius-lg pt-4 pb-3">
                              <h6 class="text-dark text-capitalize ps-3">LIST MASTER INPUT</h6>
                          </div>
                      </div>

                      <div class="card-body px-0 pb-2">

                             <form id="form_list_master_input" class="" action="" method="POST" enctype="multipart/form-data">
                               @csrf
                              <div class="table-responsive p-3">
                                  <table id="table-master-input" class="table align-items-center justify-content-center mb-0 table-hover text-center" >
                                      <thead>
                                          <tr >
                                              <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                              <th
                                                  class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                  No.
                                              </th>
                                              <th
                                                  class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Nama / NIK
                                              </th>
                                              <th
                                                  class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Jabatan
                                              </th>
                                              <th
                                                  class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                  Status
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody class="align-middle text-center">
                                      </tbody>
                                  </table>
                              </div>
                            </form>

                      </div>

                    </div>
                  </div>
                </div>

                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        @push('js')
        <script>
            function SubmitWitel(){
              $('#form_master_input').attr('action', "{{ route('witels.master_input.submit') }}").submit();
            }

            function editInput(var_input_id){
              // console.log( $('.input_'+var_input_id).prop('disabled') );
              if( $('.input_'+var_input_id).prop('disabled') === true ){ $('.input_'+var_input_id).removeAttr('disabled'); }
              else{ $('.input_'+var_input_id).attr('disabled','disabled'); }
            }

            function updateInput(var_update_id){
              $("<input />").attr("type", "hidden")
                .attr("name", "var_update_id")
                .attr("value", var_update_id)
                .appendTo("#form_list_master_input");
              $('#form_list_master_input').attr('action', "{{ route('witels.master_input.update_list') }}").submit();
            }

            function deleteInput(var_delete_id){
              $("<input />").attr("type", "hidden")
                .attr("name", "var_delete_id")
                .attr("value", var_delete_id)
                .appendTo("#form_list_master_input");
              $('#form_list_master_input').attr('action', "{{ route('witels.master_input.delete_list') }}").submit();
            }

            function SubmitMitra(){
              $('#form_mitra').attr('action', "{{ route('inputs.master.submit_mitra') }}").submit();
            }
            function SubmitTanggalLibur(){
              $('#form_tgl').attr('action', "{{ route('inputs.master.submit_tgl') }}").submit();
            }
            function SubmitTandaTangan(){
              $('#form_ttd').attr('action', "{{ route('inputs.master.submit_ttd') }}").submit();
            }

            $( document ).ready(function() {
                $("#modal-input-obl").modal({show:false});
                var session_status = "{{ session('status') }}";

                if(session_status && typeof session_status !== undefined){
                  $('#status-input-obl').empty();
                  if(session_status.includes('Sukses')){
                    $('#status-input-obl').append(`
                      <div class="alert alert-success alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+session_status+`</h5>
                          </div>
                      </div>
                    `);
                    $('#modal-input-obl').modal('show');
                  }
                  else if(session_status.includes('Oops')){
                    $('#status-input-obl').append(`
                      <div class="alert alert-danger alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+session_status+`</h5>
                          </div>
                      </div>
                    `);
                    $('#modal-input-obl').modal('show');
                  }
                  else{
                    $('#status-input-obl').append(`
                      <div class="alert alert-warning alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+session_status+`</h5>
                          </div>
                      </div>
                    `);
                    $('#modal-input-obl').modal('show');
                  }
                }

                // clear form submit after refresh browser
                $('#form_mitra')[0].reset();
                $('#form_tgl')[0].reset();
                $('#form_ttd')[0].reset();

                $('#pilih_card').change(function(){
                    if( $(this).val() === 'card_mitra' ){
                      $('#card_mitra').show(); $('#table_mitra').show(); tableMitra();
                      $('#card_tgl').hide(); $('#table_tgl').hide(); $('#card_ttd').hide(); $('#table_ttd').hide();
                    }
                    if( $(this).val() === 'card_tgl' ){
                      $('#card_tgl').show(); $('#table_tgl').show(); // tableTgl();
                      $('#card_ttd').hide(); $('#table_ttd').hide(); $('#card_mitra').hide(); $('#table_mitra').hide();
                    }
                    if( $(this).val() === 'card_ttd' ){
                      $('#card_ttd').show(); $('#table_ttd').show(); // tableTtd();
                      $('#card_tgl').hide(); $('#table_tgl').hide(); $('#card_mitra').hide(); $('#table_mitra').hide();
                    }
                });

                var tableMitra;
                var tableTgl;
                var tableTtd;
                function tableMitra(){

                  tableMitra = $('#table-mitra').DataTable({
                    language: {
                        url: "{{ asset('assets') }}/json/yajra_indonesia.json",
                    },
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    aaSorting: [],
                    ajax: "{{ route('inputs.master') }}?ajx_fr=mitra",
                    columns: [
                      {
                         data: 'DT_RowIndex',searchable:false,orderable:false,
                         "render": function ( data, type, row ) {
                           return '<b>'+data+'</b>';
                         }
                      },
                      {
                         data: 'nama_mitra',name: 'nama_mitra',searchable:true,orderable:false,
                         "render": function ( data, type, row ) {
                           return '<span style="white-space:normal">'+data+'</span>';
                         }
                      },

                    ],
                    // lengthChange:false,
                    paging:true,
                    // orderCellsTop: true,
                    pageLength: 50,
                  });

                }

                // START TABLE MASTER INPUT
                // END TABLE MASTER INPUT

            });



        </script>
        @endpush
</x-layout>
