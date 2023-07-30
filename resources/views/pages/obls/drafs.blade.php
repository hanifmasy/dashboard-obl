<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        <x-navbars.sidebar activePage="obl-drafs"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="OBL / Draf Dokumen"></x-navbars.navs.auth>
            <!-- End Navbar -->

            <!-- modal alerts -->
            <div class="modal fade" id="modal-status-draf" tabindex="-1" aria-labelledby="modal-status-draf" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Draf</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="status-draf">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="modal-status-draf-delete" tabindex="-1" aria-labelledby="modal-status-draf-delete" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Draf Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="">
                        <div class="text-center">
                            <h5 class="">Anda Yakin Hapus Draf?</h5>
                        </div>
                    </div>
                  </div>
                  <form action="{{ route('obl.drafs.delete') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-footer" id="modal-pilihan-draf-hapus">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- end modal alerts -->

            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Draf Dokumen</h6>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-2">
                                    <form action="{{ route('obl.drafs.edit') }}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                      <table id="table-draf-obl" class="table align-items-center mb-0">
                                          <thead>
                                              <tr>
                                                  <th class="text-secondary opacity-7"></th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      No.</th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Nama Pelanggan</th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Judul Projek</th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Status Draf</th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Tanggal Create</th>
                                                  <th
                                                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                      Tanggal Update</th>

                                              </tr>
                                          </thead>
                                          <tbody class="align-middle text-center">
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
        <x-plugins></x-plugins>
        @push('js')
        <script type="text/javascript">

        $("#modal-status-draf-delete").modal({show:false});
        function deleteDraf(delete_id){
            if(delete_id && typeof delete_id !== undefined){
              $('#modal-pilihan-draf-hapus').empty();
                $('#modal-pilihan-draf-hapus').append(`
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                  <button type="submit" name="draf_action" value="delete_`+delete_id+`" class="btn btn-danger">DELETE</button>
                `);
                $('#modal-status-draf-delete').modal('show');
            }
        }

          $(document).ready(function () {
              $("#modal-status-draf").modal({show:false});

              var draf_status = "{{ session('status') }}";
              if(draf_status && typeof draf_status !== undefined){
                $('#status-draf').empty();
                if(draf_status.includes('Oops!')){
                  $('#status-draf').append(`
                    <div class="alert alert-danger alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+draf_status+`</h5>
                        </div>
                    </div>
                  `);
                  $('#modal-status-draf').modal('show');
                }
                if(draf_status.includes('Sukses')){
                  $('#status-draf').append(`
                    <div class="alert alert-success alert-dismissible">
                        <div class="text-center">
                            <h5 class="text-white">`+draf_status+`</h5>
                        </div>
                    </div>
                  `);
                  $('#modal-status-draf').modal('show');
                }
              }



              $('#table-draf-obl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('obl.drafs') }}",
                columns: [
                  {
                     searchable:false,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<button type="submit" name="draf_action" value="edit_'+row.id+'" class="btn btn-info btn-sm">Edit</button><button type="button" class="btn btn-danger btn-sm" onclick="deleteDraf('+row.id+')">Delete</button>';
                     }
                  },
                  {
                     data: 'DT_RowIndex',searchable:false,orderable:false
                  },
                  {
                     data: 'f1_nama_plggn',name: 'f1_nama_plggn',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<h6 class="mb-0 text-sm" style="white-space:normal">'+data+'</h6>';
                     }
                  },
                  {
                     data: 'f1_judul_projek',name: 'f1_judul_projek',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                       return '<span style="white-space:normal">' + data + '</span>';
                     }
                  },
                  {
                     data: 'string_submit',name: 'string_submit',searchable:true,orderable:false,
                     "render": function ( data, type, row ) {
                        if(row.filter_submit==='kontrak'){ return '<span class="badge badge-sm bg-gradient-success">'+data+'</span>'; }
                        if(row.filter_submit==='filter'){ return '<span class="badge badge-sm bg-gradient-secondary">'+data+'</span>'; }
                        if(row.filter_submit==='form'){ return '<span class="badge badge-sm bg-gradient-warning">'+data+'</span>'; }
                     }
                  },
                  {
                     data: 'string_tgl_create',name: 'string_tgl_create',searchable:true,orderable:true
                  },
                  {
                     data: 'string_tgl_update',name: 'string_tgl_update',searchable:true,orderable:true
                  }

                ],
                lengthChange:false,
                paging:true,
                orderCellsTop: true,
                // order: [[ 5, 'desc' ]],
                pageLength: 50,
              });

          });



          $.extend( $.fn.dataTable.defaults, {
            responsive: true
          } );
        </script>
        @endpush
</x-layout>
