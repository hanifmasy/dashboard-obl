<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="witels-master-input"></x-navbars.sidebar>
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
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">MASTER INPUT</h6>
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

                            <form id="form_master_input"  method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body px-0 pb-2">
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
                                                            <h6 class="mb-0 text-sm">Account Manager</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('acc_mgr'))
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" class="outline-input-merah" name="acc_mgr" id="acc_mgr" autocomplete="off">{{ old('acc_mgr','') }}</textarea>
                                                    @else
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" name="acc_mgr" id="acc_mgr" autocomplete="off">{{ old('acc_mgr','') }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Manager Business Service Witel {{ $user_in_is ? $user_in_is->nama_witel : '' }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('mgr_bs'))
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" class="outline-input-merah" name="mgr_bs" id="mgr_bs" autocomplete="off">{{ old('mgr_bs','') }}</textarea>
                                                    @else
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" name="mgr_bs" id="mgr_bs" autocomplete="off">{{ old('mgr_bs','') }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Manager Government Regional </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('mgr_gs'))
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" class="outline-input-merah" name="mgr_gs" id="mgr_gs" autocomplete="off">{{ old('mgr_gs','') }}</textarea>
                                                    @else
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" name="mgr_gs" id="mgr_gs" autocomplete="off">{{ old('mgr_gs','') }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Manager Enterprise Regional</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('mgr_es'))
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" class="outline-input-merah" name="mgr_es" id="mgr_es" autocomplete="off">{{ old('mgr_es','') }}</textarea>
                                                    @else
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" name="mgr_es" id="mgr_es" autocomplete="off">{{ old('mgr_es','') }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">GM Witel / GM RGES </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($errors->has('gm_witel'))
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" class="outline-input-merah" name="gm_witel" id="gm_witel" autocomplete="off">{{ old('gm_witel','') }}</textarea>
                                                    @else
                                                      <textarea placeholder="NAMA / NIK" type="text" cols="45" rows="1" name="gm_witel" id="gm_witel" autocomplete="off">{{ old('gm_witel','') }}</textarea>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr ><td colspan="2"><br></td></tr>
                                            <tr ><td colspan="2">
                                                <input type="text" name="submit" value="submit_master_input_witel" hidden>
                                                <button onclick="SubmitWitel()" class="btn bg-gradient-primary"><h6 class="mb-0 text-sm" style="color:white;">Submit</h6></button>
                                            </td></tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <div class="row mt-0">
                  <div class="col-12 mx-auto">
                    <div class="card my-4">

                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                              <h6 class="text-white text-capitalize ps-3">LIST MASTER INPUT</h6>
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
                  else if(session_status.includes('Draf')){
                    $('#status-input-obl').append(`
                      <div class="alert alert-warning alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+session_status+`</h5>
                          </div>
                      </div>
                    `);
                    $('#modal-input-obl').modal('show');
                  }
                  else{
                    $('#status-input-obl').append(`
                      <div class="alert alert-danger alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+session_status+`</h5>
                          </div>
                      </div>
                    `);
                    $('#modal-input-obl').modal('show');
                  }
                }

                // clear form submit after refresh browser
                $('#form_master_input')[0].reset();

                // START TABLE MASTER INPUT
                var tableObl = $('#table-master-input').DataTable({
                  language: {
                      url: "{{ asset('assets') }}/json/yajra_indonesia.json",
                  },
                  destroy: true,
                  processing: true,
                  serverSide: true,
                  retrieve: true,
                  aaSorting: [],
                  ajax: "{{ route('witels.master_input') }}",
                  columns: [
                    {
                       searchable:false,orderable:false,targets: 0,
                       render: function ( data, type, row ) {
                           return `
                           <button type="button" class="btn btn-sm btn-info mt-3" data-bs-toggle="popover" title="Edit" onclick="editInput(`+row.id+`)"><i class="material-icons" style="font-size:18px;">edit</i></button>
                           <button disabled="disabled" type="button" class=" input_`+row.id+` btn btn-sm btn-success mt-3" data-bs-toggle="popover" title="Update" onclick="updateInput(`+row.id+`)"><i class="material-icons" style="font-size:18px;">input</i></button>
                           <button disabled="disabled" type="button" class=" input_`+row.id+` btn btn-sm btn-danger mt-3" data-bs-toggle="popover" title="Delete" onclick="deleteInput(`+row.id+`)"><i class="material-icons" style="font-size:18px;">delete</i></button>
                           `;
                       }
                    },
                    {
                       data: 'DT_RowIndex',searchable:false,orderable:false,
                       "render": function ( data, type, row ) {
                         return '<b class="text-center">'+data+'</b>';
                       }
                    },
                    {
                       data: 'nama_nik',name: 'nama_nik',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         if( row.role_witel === 1 ){ return `<input disabled="disabled" class="  input_`+row.id+` text-center " name="acc_mgr_`+row.id+`" value="`+data+`" >`; }
                         if( row.role_witel === 2 ){ return `<input disabled="disabled" class="  input_`+row.id+` text-center " name="mgr_bs_`+row.id+`" value="`+data+`" >`; }
                         if( row.role_witel === 3 ){ return `<input disabled="disabled" class="  input_`+row.id+` text-center " name="mgr_gs_`+row.id+`" value="`+data+`" >`; }
                         if( row.role_witel === 4 ){ return `<input disabled="disabled" class="  input_`+row.id+` text-center " name="mgr_es_`+row.id+`" value="`+data+`" >`; }
                         if( row.role_witel === 5 ){ return `<input disabled="disabled" class="  input_`+row.id+` text-center " name="gm_witel_`+row.id+`" value="`+data+`" >`; }
                       }
                    },
                    {
                       data: 'jabatan',name: 'jabatan',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         if( data === 'GM Witel' ){
                           return '<span class="text-center" style="white-space:normal">GM Witel / GM RGES</span>';
                         }
                         else{ return '<span class="text-center" style="white-space:normal">'+data+'</span>'; }
                       }
                    },
                    {
                       data: 'status',name: 'status',searchable:true,orderable:false,
                       "render": function ( data, type, row ) {
                         let hasil_status = `<select disabled="disabled" class="  input_`+row.id+` text-center " name="status_`+row.id+`" >`;
                         if( data === 'aktif' ){
                           hasil_status += `
                            <option value="aktif" selected>AKTIF</option>
                            <option value="non_aktif" >NON AKTIF</option>`;
                         }
                         else{
                           hasil_status += `
                            <option value="aktif" >AKTIF</option>
                            <option value="non_aktif" selected>NON AKTIF</option>`;
                         }
                         hasil_status += `</select>`;

                         return hasil_status;
                       }
                    }

                  ],
                  lengthChange:false,
                  paging:true,
                  orderCellsTop: true,
                  pageLength: 20,
                });
                // END TABLE MASTER INPUT

            });

            $.extend( $.fn.dataTable.defaults, {
              responsive: true
            } );

        </script>
        @endpush
</x-layout>
