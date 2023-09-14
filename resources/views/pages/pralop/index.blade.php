<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="witels-pralop"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="REPORT PRA LOP"></x-navbars.navs.auth>
            <!-- End Navbar -->
            <style media="screen">
            .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
              border-color: #D7B1D7;
              background-color: #D7B1D7;
            }

            .truncate {
              max-width:50px;
              white-space: nowrap;
              overflow: hidden;
              text-overflow: ellipsis;
            }

            #table-data-obl .action-kembali-proses-witel.dropdown-item:hover {
              background-color:  	#E91E63;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-obl.dropdown-item:hover {
              background-color:  	#1a73e8;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-legal.dropdown-item:hover {
              background-color:  	#fb8c00;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-mitra-obl.dropdown-item:hover {
              background-color:  	#1da2d8;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-closesm.dropdown-item:hover {
              background-color:  	#d9534f;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-done.dropdown-item:hover {
              background-color:  	#4CAF50;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            #table-data-obl .action-proses-cancel.dropdown-item:hover {
              background-color:  	#f44335;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-kembali-witel.dropdown-item:hover {
              background-color:  	#E91E63;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-lanjut-obl.dropdown-item:hover {
              background-color:  	#1a73e8;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-edit.dropdown-item:hover {
              background-color:  	#3b5998;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-forms.dropdown-item:hover {
              background-color:  	#2a623d;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-lampiran.dropdown-item:hover {
              background-color:  	#008080;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-print.dropdown-item:hover {
              background-color:  	#eeba30;
              color:  	#000000;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-upload.dropdown-item:hover {
              background-color:  	#7289da;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-ketdoc.dropdown-item:hover {
              background-color:  	#708090;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }
            #table-data-obl .action-delete.dropdown-item:hover {
              background-color:  	#ae0001;
              color:  	#ffffff;
              font-weight: bolder;
              font-size: 15px;
            }

            </style>

            <!-- modal alerts -->
            @if( $is_user->role_id === 2 or $is_user->role_id === 4 or $is_user->role_id === 8 or $is_user->role_id === 9  )
            <div class="modal fade" id="modal-status-table-obl" tabindex="-1" aria-labelledby="modal-status-table-obl" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Proses Sistem:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="status-table-obl">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @if( $is_user->role_id === 2 or $is_user->role_id === 8 or $is_user->role_id === 9 )
            <div class="modal fade" id="modal-status-table-obl-delete" tabindex="-1" aria-labelledby="modal-status-table-obl-delete" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Hapus Dokumen OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="">
                        <div class="text-center">
                            <h5 class="">Anda Yakin Hapus Dokumen OBL?</h5>
                        </div>
                    </div>
                  </div>
                  <form action="{{ route('obl.tables.delete') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-footer" id="modal-pilihan-table-obl-hapus">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="modal-multi-obl-hapus" tabindex="-1" aria-labelledby="modal-multi-obl-hapus" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Hapus Dokumen OBL:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="multi-obl-hapus-hapus-body">
                  </div>
                  <div class="modal-footer" id="multi-obl-hapus-hapus-footer">
                  </div>
                </div>
              </div>
            </div>
            @endif
            @if( $is_user->role_id )
            <div class="modal fade" id="modal-ketdoc-table-obl" tabindex="-1" aria-labelledby="modal-ketdoc-table-obl" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Keterangan PRA LOP:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="ketdoc-table-obl">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
            @endif
            <!-- end modal alerts -->


            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                @if( $is_user->role_id == 4 || $is_user->role_id == 5 )
                                <div class="bg-gradient-primary border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3 text-white">REPORT PRA LOP</h6>
                              </div>
                                @elseif( $is_user->role_id === 13 )
                                <div class="bg-gradient-warning border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3 text-white">REPORT PRA LOP</h6>
                                </div>
                                @elseif( $is_user->role_id !== 4 && $is_user->role_id !== 5 && $is_user->role_id !== 13 )
                                <div class="bg-gradient-light shadow-primary border-radius-lg pt-4 pb-3">
                                  <h6 class="text-capitalize ps-3">REPORT PRA LOP</h6>
                                </div>
                                @endif

                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-3">
                                  <form id="formObl" method="GET">
                                    <div class="row">
                                      <div class="col">

                                      </div>
                                    </div><br>
                                    <table id="table-data-obl" class="table align-items-center justify-content-center mb-0 table-hover text-center">
                                        <thead>
                                            <tr>
                                              <th></th>
                                              <th
                                                  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                  No.</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">on handling</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">judul projek</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">nama plggn</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">alamat plggn</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">pic plggn</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">witel</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">id LOP</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">nomor akun</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">estimasi Opportunity</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">segmen</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">skema bayar<br>ke pelanggan</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">status order</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">keterangan</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">created at</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">created by</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">updated at</th>
                                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">updated by</th>
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">
                                        </tbody>
                                    </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <x-footers.auth></x-footers.auth>
            </div>
        </main>
        @push('js')
        <script type="text/javascript">

        window.history.pushState({}, document.title, "/dashboard-obl/witels-pralop" );

          $("#modal-status-table-obl-delete").modal({show:false});
          function deleteDoc(delete_id){
              if(delete_id && typeof delete_id !== undefined){
                $('#modal-pilihan-table-obl-hapus').empty();
                  $('#modal-pilihan-table-obl-hapus').append(`
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TIDAK</button>
                    <button type="submit" name="obl_doc_action" value="delete_`+delete_id+`" class="btn btn-danger">HAPUS</button>
                  `);
                  $('#modal-status-table-obl-delete').modal('show');
              }
          }

          function editDoc(edit_pralop_id){
            $('#formObl').attr('action', "");
            $("<input />").attr("type", "hidden")
              .attr("name", "edit_pralop_id")
              .attr("value", edit_pralop_id )
              .appendTo("#formObl");
            $('#formObl').attr('action', "{{ route('witels.pralop.detail') }}").submit();
          }

          function ketDoc(ket_obl_id){
            $('#ketdoc-table-obl').empty();
            let status_ket_obl = ``;
            // JQUERY AJAX POST
            $.ajax({
               type:'POST',
               url:"{{ route('witels.pralop.ketdoc') }}",
               data:{
                 _token: "{{ csrf_token() }}",
                 ket_obl_id:ket_obl_id
               },
               success:function(data){
                 // console.log(data);
                  if(data.status_id==='3' || data.status_id==='4'){
                    $('#ketdoc-table-obl').append(`
                      <div class="alert alert-danger alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+data.status+`</h5>
                          </div>
                      </div>
                    `);
                  }
                  else if(data.status_id==='2'){
                    $('#ketdoc-table-obl').append(`
                      <div class="alert alert-warning alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+data.status+`</h5>
                          </div>
                      </div>
                    `);
                  }
                  else{
                    let status_ket_obl = ``;
                    if(data.arr_log_histori && data.arr_log_histori.length > 0 && data.arr_log_histori.length !== 1 ){
                      $.each(data.arr_log_histori,function(index,value){
                        if( value.tgl_keterangan ){
                          if(index === 0){
                            status_ket_obl+=`
                            <tr>
                              <td class="d-flex flex-column"><h6 class="text-sm justify-content-center">▶️ [`+value.tgl_keterangan+`]</h6></td>
                              <td><h6 style="white-space:normal;" class="text-sm">`+value.keterangan+`</h6></td>
                            </tr>
                            `;
                          }
                          else{
                            status_ket_obl+=`
                            <tr>
                              <td class="d-flex flex-column justify-content-center">[`+value.tgl_keterangan+`]</td>
                              <td style="white-space:normal;">`+value.keterangan+`</td>
                            </tr>
                            `;
                          }
                        }

                      });
                    }
                    else if( data.arr_log_histori && data.arr_log_histori.length === 1 ){
                      if( !value.tgl_keterangan ){
                        status_ket_obl=`
                        <tr>
                          <td colspan="2"><h6>NO DATA</h6></td>
                        </tr>
                        `;
                      }
                    }


                    $('#ketdoc-table-obl').append(`
                      <div class="alert alert-secondary alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">List Keterangan</h5>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 table-responsive">
                          <table class="table align-items-center mb-0" cellspacing="0" cellpadding="0">
                            <thead>
                              <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TANGGAL</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">KETERANGAN</th>
                              </tr>
                            </thead>
                            <tbody>
                            `+status_ket_obl+`
                            </tbody>
                          </table>
                        </div>
                      </div>
                    `);
                  }
               }
            });
            $('#modal-ketdoc-table-obl').modal('show');
          }

          $(document).ready(function () {
              $("#modal-status-table-obl").modal({show:false});
              $("#modal-ketdoc-table-obl").modal({show:false});

              var status_table_obl = "{{ session('status') }}";
              var wl = @json($wl);
              var cl = @json($cl);
              if(status_table_obl && typeof status_table_obl !== undefined){
                $('#status-table-obl').empty();
                if(status_table_obl.includes('Oops')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-danger alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                }
                if(status_table_obl.includes('Sukses')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-success alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                }
                if(status_table_obl.includes('Draf')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-warning alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                }
                if(status_table_obl.includes('Tidak')){
                  $('#status-table-obl').append(`
                    <div class="alert alert-warning alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+status_table_obl+`</h5>
                        </div>
                    </div>
                  `);
                }
                $('#modal-status-table-obl').modal('show');
              }


              var is_user = "{{ $user_pralop->role_id }}";
              var is_user_witel = "{{ $user_pralop->nama_witel }}";
              var arr_untuk_solution = ["solution","review_kb"];
              var tableObl = $('#table-data-obl').DataTable({
                language: {
                    url: "{{ asset('assets') }}/json/yajra_indonesia.json",
                },
                dom: 'fBrtip',
                buttons: [
                  {
                      extend: 'excel',
                      text: 'EXCEL',
                      className: 'btn btn-sm btn-success',
                      filename: function(){
                            var today = new Date();
                            var dd = String(today.getDate()).padStart(2, '0');
                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                            var yyyy = today.getFullYear();
                            today = yyyy + '-' + mm + '-' + dd;
                            if( is_user_witel && (is_user === '4' || is_user === '5') ){ return 'Report_PRA_LOP_' + today + '_Witel_' + is_user_witel; }
                            else{ return 'Report_PRA_LOP_' + today; }
                        },
                      exportOptions: {
                           columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]
                       }
                  }
                ],
                // select: {
                //     style: 'multi'
                // },
                destroy: true,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('witels.pralop') }}?ajx_wl="+wl+"&ajx_cl="+cl,
                columns: [
                  {
                     searchable:false,orderable:false,targets: 0,
                     render: function ( data, type, row ) {
                         if( is_user === '1' || is_user === '3' || is_user === '5' || is_user === '7' ){
                           return `<button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>`;
                         }
                         else if( is_user === '4' && row.on_handling !== 'witel' && row.on_handling !== 'final_pralop' ){
                           return `<button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>`;
                         }
                         else if( is_user === '4' && row.on_handling === 'witel' ){
                           return `
                               <div class="btn-group" role="group">
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info text-white mt-3" onclick="editDoc('`+row.id+`')">Edit</button>
                                    </div>
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>
                                    </div>
                               </div>
                               `;
                         }
                         else if( is_user === '4' && row.on_handling === 'final_pralop' ){
                           return `
                               <div class="btn-group" role="group">
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info text-white mt-3" onclick="editDoc('`+row.id+`')">Review KB</button>
                                    </div>
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>
                                    </div>
                               </div>
                               `;
                         }
                         else if( is_user === '13' && row.on_handling === 'legal' ){
                           return `
                               <div class="btn-group" role="group">
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info text-white mt-3" onclick="editDoc('`+row.id+`')">Review</button>
                                    </div>
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>
                                    </div>
                               </div>
                               `;
                         }
                         else if( is_user === '13' && row.on_handling !== 'legal' ){
                           return `<button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>`;
                         }
                         else if( is_user === '8' && row.on_handling === 'solution' ){
                           return `
                               <div class="btn-group" role="group">
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info text-white mt-3" onclick="editDoc('`+row.id+`')">Edit</button>
                                    </div>
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>
                                    </div>
                               </div>
                               `;
                         }
                         else if( is_user === '8' && !arr_untuk_solution.includes(row.on_handling) ){
                           return `<button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>`;
                         }
                         else if( is_user === '9' ){
                           return `
                               <div class="btn-group" role="group">
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info text-white mt-3" onclick="editDoc('`+row.id+`')">Edit</button>
                                    </div>
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-secondary text-white mt-3" onclick="ketDoc('`+row.id+`')">KETERANGAN</button>
                                    </div>
                               </div>
                               `;
                         }
                     }
                  },
                  {
                     data: 'DT_RowIndex',searchable:false,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<b>'+data+'</b>';
                     }
                  },
                  {
                     data: 'on_handling',name: 'on_handling',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data==='witel'){ return '<span class="badge badge-sm bg-gradient-primary">WITEL</span>'; }
                       else if(data==='solution'){ return '<span class="badge badge-sm bg-gradient-info">SOLUTION</span>'; }
                       else if(data==='legal'){ return '<span class="badge badge-sm bg-gradient-warning">LEGAL</span>'; }
                       else if(data==='final_pralop'){ return '<span class="badge badge-sm bg-gradient-primary">FINAL PRA LOP</span>'; }
                       else if(data==='final_review_kb'){ return '<span class="badge badge-sm bg-gradient-success">FINAL REVIEW KB</span>'; }
                       else { return '-'; }
                     }
                  },
                  {
                     data: 'lop_judul_projek',name: 'lop_judul_projek',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<span style="white-space:normal">'+data+'</span>';
                     }
                  },

                  {
                     data: 'lop_nama_plggn',name: 'lop_nama_plggn',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return data;
                     }
                  },

                  {
                     data: 'lop_alamat_plggn',name: 'lop_alamat_plggn',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data){ return data; }
                       else{ return '-'; }
                     }
                  },

                  {
                     data: 'lop_pic_plggn',name: 'lop_pic_plggn',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data){ return data; }
                       else{ return '-'; }
                     }
                  },

                  {
                     data: 'lop_witel',name: 'lop_witel',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<span style="white-space:normal">'+data+'</span>';
                     }
                  },

                  {
                     data: 'lop_id_mytens',name: 'lop_id_mytens',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data){ return '<span style="white-space:normal">'+data+'</span>'; }
                       else{ return '<span style="white-space:normal">-</span>'; }
                     }
                  },

                  {
                     data: 'lop_nomor_akun',name: 'lop_nomor_akun',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data){ return '<span style="white-space:normal">'+data+'</span>'; }
                       else{ return '<span style="white-space:normal">-</span>'; }
                     }
                  },

                  {
                     data: 'lop_nilai_kb',name: 'lop_nilai_kb',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data){ return data; }
                       else{ return '-'; }
                     }
                  },

                  {
                     data: 'lop_segmen',name: 'lop_segmen',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data){ return '<span style="white-space:normal">'+data+'</span>'; }
                       else{ return '<span style="white-space:normal">-</span>'; }
                     }
                  },

                  {
                     data: 'lop_skema_bayar',name: 'lop_skema_bayar',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data){ return '<span style="white-space:normal">'+data+'</span>'; }
                       else{ return '<span style="white-space:normal">-</span>'; }
                     }
                  },

                  {
                     data: 'lop_status_order',name: 'lop_status_order',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if(data){ return '<span style="white-space:normal">'+data+'</span>'; }
                       else{ return '<span style="white-space:normal">-</span>'; }
                     }
                  },

                  {
                     data: 'lop_keterangan',name: 'lop_keterangan',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       if( row.lop_tgl_keterangan ){ return '<span white-space:normal><b>'+row.lop_tgl_keterangan+'</b> '+data.substr(0,20)+'</span>'; }
                       else{ return '-'; }
                     }
                  },

                  {
                     data: 'created_at',name: 'created_at',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<span style="white-space:normal">'+data+'</span>';
                     }
                  },

                  {
                     data: 'user_create',name: 'user_create',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<span style="white-space:normal">'+data+'</span>';
                     }
                  },

                  {
                     data: 'updated_at',name: 'updated_at',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<span style="white-space:normal">'+data+'</span>';
                     }
                  },

                  {
                     data: 'user_update',name: 'user_update',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<span style="white-space:normal">'+data+'</span>';
                     }
                  }

                ],
                // lengthChange:false,
                paging:true,
                // orderCellsTop: true,
                pageLength: 50,
              });

          });
          $.extend( $.fn.dataTable.defaults, {
            responsive: true
          } );
        </script>
        @endpush
</x-layout>
