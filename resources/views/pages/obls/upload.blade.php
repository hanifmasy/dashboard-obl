<x-layout bodyClass="g-sidenav-show  bg-gray-200">
        @if(isset($upload_doc))
        <x-navbars.sidebar activePage="obl-tables-upload"></x-navbars.sidebar>
        @else
        <x-navbars.sidebar activePage="obl-upload"></x-navbars.sidebar>
        @endif

        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="ARSIP DOKUMEN"></x-navbars.navs.auth>
            <!-- End Navbar -->

            <style media="screen">
            .btn-link-visibility {
              color: blue !important;
            }
            .btn-link-download {
              color: green !important;
            }
            .btn-link-clear {
              color: red !important;
            }
            .btn-submit-upload, .btn-kembali-upload {
              display: none;
            }
            .btn-submit-loading{ display: none; }
            .bg-btn-disabled{
              color: #b3b3b3 !important;
            }
            .bg-upload-title{
              background: rgb(114,137,218);
              background: linear-gradient(90deg, rgba(114,137,218,1) 0%, rgba(161,175,226,1) 84%, rgba(181,190,221,1) 100%);
              box-shadow: 2px 1px 2px 1px rgb(114,137,218);
            }
            .bg-upload-btn{
              background: rgb(114,137,218);
            }
            #btn-lanjut{
              width:200px;
              background:#275379;
            }
            #btn-lanjut:hover {
              width:200px;
              background:#275379;
              box-shadow: 0 10px 10px -2px #becbd6;
            }
            .btn-setting  {
              float:left;
              padding: 0;
              border: none;
              background: none;
            }
            table th {
              /* margin: 1.5em; */
              /* padding-top: 1.0em; */
              padding-left: 8.4em;
              /* padding-right: 2.5em; */
              padding-bottom: 0.7em;
            }
            table td {
              /* margin: 1.5em; */
              padding-top: 1.0em;
              padding-left: 5.5em;
              /* padding-right: 2.5em; */
              padding-bottom: 0.7em;
            }
            </style>
            @if(isset($upload_doc))
                @if( $upload_doc[0]['f1_jenis_spk'] == 'SP' )
                <style media="screen">
                  .lanjut-form{ display:block; }
                  .lanjut-head{ display:block; }
                  .lanjut-form-kl{ display:none; }
                  .lanjut-form-wo{ display:none; }
                  .lanjut-form-biasa{ display:inline; }
                  .lanjut-form-sp{ display:inline; }
                </style>
                @elseif( $upload_doc[0]['f1_jenis_spk'] == 'WO' )
                <style media="screen">
                  .lanjut-form{ display:block; }
                  .lanjut-head{ display:block; }
                  .lanjut-form-kl{ display:none; }
                  .lanjut-form-sp{ display:none; }
                  .lanjut-form-biasa{ display:none; }
                  .lanjut-form-wo{ display:inline; }
                </style>
                @elseif( $upload_doc[0]['f1_jenis_spk'] == 'KL' )
                <style media="screen">
                  .lanjut-form{ display:block; }
                  .lanjut-head{ display:block; }
                  .lanjut-form-sp{ display:none; }
                  .lanjut-form-wo{ display:none; }
                  .lanjut-form-biasa{ display:inline; }
                  .lanjut-form-kl{ display:inline; }
                </style>
                @endif
            @else
            <style media="screen">
              .lanjut-form{ display:none; }
              .lanjut-head{ display:none; }
            </style>
            @endif

            <!-- modal alerts -->
            <div class="modal hide fade in" id="modal-status-upload-obl" tabindex="-1" aria-labelledby="modal-status-upload-obl" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Status Upload File:</h5>
                  </div>
                  <div class="modal-body" id="status-upload-obl">
                  </div>
                  <div class="modal-footer">
                    @if( isset($upload_doc) )
                      <a href="{{ route('obl.tables') }}" role="button" class="btn btn-secondary">OK</a>
                    @else
                      <a href="{{ route('obl.upload.index') }}" role="button" class="btn btn-secondary">OK</a>
                    @endif
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
                                    @if(isset($upload_doc))
                                        @if( $user_in_is->role_id === 4 || $user_in_is->role_id === 5 )
                                        <div class="bg-gradient-primary border-radius-lg pt-4 pb-3">
                                        <h6 class="text-white text-capitalize ps-3">ARSIP DOKUMEN: <div style="font-size: 24px;">{{ $upload_doc[0]['f1_segmen'] }} / {{ $upload_doc[0]['folder'] }} / {{ $upload_doc[0]['tahun'] }}  / {{ $upload_doc[0]['f1_judul_projek'] }} </div></h6>
                                        </div>
                                        @elseif( $user_in_is === 6 )
                                        <div class=" border-radius-lg pt-4 pb-3" style="background:#1da2d8;">
                                        <h6 class="text-white text-capitalize ps-3">ARSIP DOKUMEN: <div style="font-size: 24px;">{{ $upload_doc[0]['f1_segmen'] }} / {{ $upload_doc[0]['folder'] }} / {{ $upload_doc[0]['tahun'] }}  / {{ $upload_doc[0]['f1_judul_projek'] }} </div></h6>
                                        </div>
                                        @else
                                        <div class="bg-upload-title border-radius-lg pt-4 pb-3">
                                        <h6 class="text-white text-capitalize ps-3">ARSIP DOKUMEN: <div style="font-size: 24px;">{{ $upload_doc[0]['f1_segmen'] }} / {{ $upload_doc[0]['folder'] }} / {{ $upload_doc[0]['tahun'] }}  / {{ $upload_doc[0]['f1_judul_projek'] }} </div></h6>
                                        </div>
                                        @endif
                                    @else
                                        @if( $user_in_is->role_id === 4 || $user_in_is->role_id === 5 )
                                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                        <h6 class="text-capitalize ps-3">ARSIP DOKUMEN<span id="judul_hasil_cari"></span></h6>
                                        </div>
                                        @elseif( $user_in_is === 6 )
                                        <div class="shadow-primary border-radius-lg pt-4 pb-3" style="background:#1da2d8;">
                                        <h6 class="text-capitalize ps-3">ARSIP DOKUMEN<span id="judul_hasil_cari"></span></h6>
                                        </div>
                                        @else
                                        <div class="bg-gradient-light shadow-primary border-radius-lg pt-4 pb-3">
                                        <h6 class="text-capitalize ps-3">ARSIP DOKUMEN<span id="judul_hasil_cari"></span></h6>
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

                            <form id="formObl" enctype="multipart/form-data">
                              @csrf
                            <div class="card-body px-0">
                                <div class=" p-0">
                                  @if( !isset($upload_doc) )
                                  <table>
                                    <tbody>
                                      <tr>
                                        <td>
                                          <div class="row-sm d-flex">
                                              <select class="ps-3 border form-control " name="f1_segmen" id="f1_segmen" autocomplete="off">
                                                <option value="" disabled selected>PILIH SEGMEN</option>
                                                <option value="DES">DES</option>
                                                <option value="DGS">DGS</option>
                                                <option value="DBS">DBS</option>
                                              </select>
                                              <input class="ps-3 border form-control "  type="text" id="folder" name="folder" placeholder="NAMA FOLDER" autocomplete="off">
                                              <input class="ps-3 border form-control " type="text" id="tahun" name="tahun" placeholder="TAHUN" autocomplete="off">

                                          </div>
                                          <div class="row-sm d-flex py-2">
                                            <div class="col d-flex">
                                              <button type="button" onclick="cariUploadDoc()" class="btn-cari mt-2 mb-2 btn btn-sm bg-gradient-info" style="width:135px;"><h6 class="mb-0 text-sm" style="color:white;">Cari Dokumen</h6></button>
                                              <button type="button" id="btn-lanjut" class="ms-1 mt-2 mb-2 btn btn-sm" style=""><h6 class="mb-0 text-sm" style="color:white;">Lanjut Upload File</h6></button>
                                              <button class="btn-loading mt-2 mb-2 btn btn-sm btn-info text-white" type="button" style="width:135px;">
                                                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    Loading...
                                              </button>
                                              <div class="text-white text-center me-1 mt-3 d-flex align-items-center justify-content-center">
                                              </div>
                                              <span class="nav-link-text ms-2 mt-2 text-danger" id="label_upload_doc"></span>
                                            </div>
                                          </div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  @endif
                                    <table id="table-input-obl" class="" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr class="kepala">
                                                <th ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class=" lanjut-head ">
                                                <!-- FILES UPLOAD -->
                                                <td class="">

                                                  <!-- FILES USER WITEL VIEW -->
                                                  @if( $user_in_is->role_id === 5 )
                                                    @if( isset($upload_doc) )
                                                    @else
                                                    @endif
                                                  @endif
                                                  <!-- END FILES USER WITEL VIEW -->

                                                  <!-- FILES FOR OBL VIEW -->
                                                  @if( $user_in_is->role_id === 1 || $user_in_is->role_id === 3 || $user_in_is->role_id === 7 )
                                                    @if( isset($upload_doc) )
                                                    <div class="row">
                                                      <div class="col">
                                                        <div class="row">
                                                          <div class="col d-flex">

                                                            @if( $upload_doc[0]['nama_p0'] !== '' )
                                                            <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                            <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                            @else
                                                            <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                            <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                            @endif
                                                            <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                                                            <input style="visibility:hidden;" type="file" disabled>
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col d-flex">

                                                            @if( $upload_doc[0]['nama_p1'] !== '' )
                                                            <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                            <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                            @else
                                                            <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                            <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                            @endif
                                                            <label class="btn btn-sm bg-gradient-light label_p0">File P1</label>
                                                            <input style="visibility:hidden;" type="file" disabled>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    @else
                                                    <div class="row">
                                                      <div class="col">
                                                        FILE FOR USER VIEW - ROUTING INDEX
                                                      </div>
                                                    </div>
                                                    @endif
                                                  @endif
                                                  <!-- END FILE USER VIEW -->

                                                  <!-- FILES FOR WITEL/SOLUTION -->
                                                  @if( $user_in_is->role_id === 4 || $user_in_is->role_id === 8 )
                                                    @if( isset($upload_doc) )
                                                      @if( $user_in_is->role_id === 4 && $upload_doc[0]['revisi_witel'] === true )
                                                      <div class="row">
                                                        <div class="col">
                                                          <div class="row">
                                                            <div class="col d-flex">

                                                              @if( $upload_doc[0]['nama_p0'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif

                                                              <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                                                              <label for="file_p0" class="btn btn-sm bg-gradient-light label_p0"><span id="label_file_p0">Pilih File P0</span></label>
                                                              <input id="file_p0" name="file_p0" style="visibility:hidden;" type="file">
                                                            </div>
                                                          </div>
                                                          <div class="row">
                                                            <div class="col d-flex">

                                                                @if( $upload_doc[0]['nama_p1'] !== '' )
                                                                <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                @else
                                                                <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                @endif

                                                              <button type="button" id="btn_clear_p1" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                                                              <label for="file_p1" class="btn btn-sm bg-gradient-light label_p1"><span id="label_file_p1">Pilih File P1</span></label>
                                                              <input id="file_p1" name="file_p1" style="visibility:hidden;" type="file">
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      @elseif( $user_in_is->role_id === 4 && $upload_doc[0]['revisi_witel'] === false )
                                                      <div class="row">
                                                        <div class="col">
                                                          <div class="row">
                                                            <div class="col d-flex">

                                                              @if( $upload_doc[0]['nama_p0'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                              <label  class="btn btn-sm bg-gradient-light label_p1">File P0</label>
                                                              <input style="visibility:hidden;" type="file" disabled>

                                                            </div>
                                                          </div>
                                                          <div class="row">
                                                            <div class="col d-flex">

                                                                @if( $upload_doc[0]['nama_p1'] !== '' )
                                                                <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                @else
                                                                <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                @endif
                                                                <label  class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                                                                <input style="visibility:hidden;" type="file" disabled>

                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      @elseif( $user_in_is->role_id === 8 && $upload_doc[0]['f1_proses'] === 'witel' )
                                                      <div class="row">
                                                        <div class="col">
                                                          <div class="row">
                                                            <div class="col d-flex">

                                                              @if( $upload_doc[0]['nama_p0'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif

                                                              <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                                                              <label for="file_p0" class="btn btn-sm bg-gradient-light label_p0"><span id="label_file_p0">Pilih File P0</span></label>
                                                              <input id="file_p0" name="file_p0" style="visibility:hidden;" type="file">
                                                            </div>
                                                          </div>
                                                          <div class="row">
                                                            <div class="col d-flex">

                                                                @if( $upload_doc[0]['nama_p1'] !== '' )
                                                                <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                @else
                                                                <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                @endif

                                                              <button type="button" id="btn_clear_p1" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                                                              <label for="file_p1" class="btn btn-sm bg-gradient-light label_p1"><span id="label_file_p1">Pilih File P1</span></label>
                                                              <input id="file_p1" name="file_p1" style="visibility:hidden;" type="file">
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      @elseif( $user_in_is->role_id === 8 && $upload_doc[0]['f1_proses'] !== 'witel' )
                                                      <div class="row">
                                                        <div class="col">
                                                          <div class="row">
                                                            <div class="col d-flex">

                                                              @if( $upload_doc[0]['nama_p0'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p0')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                              <label  class="btn btn-sm bg-gradient-light label_p1">File P0</label>
                                                              <input style="visibility:hidden;" type="file" disabled>

                                                            </div>
                                                          </div>
                                                          <div class="row">
                                                            <div class="col d-flex">

                                                                @if( $upload_doc[0]['nama_p1'] !== '' )
                                                                <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p1')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                @else
                                                                <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                                @endif
                                                                <label  class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                                                                <input style="visibility:hidden;" type="file" disabled>

                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      @endif
                                                    @else
                                                      <div class="row">
                                                        <div class="col">
                                                          @if( $user_in_is->role_id === 8 )
                                                          <div class="row">
                                                            <div class="col d-flex">
                                                              <span class="d-flex" id="btns_file_p0"></span>
                                                            </div>
                                                          </div>
                                                          <div class="row">
                                                            <div class="col d-flex">
                                                              <span class="d-flex" id="btns_file_p1"></span>
                                                            </div>
                                                          </div>
                                                          @endif
                                                        </div>
                                                      </div>
                                                    @endif
                                                  @endif
                                                  <!-- END FILE USER WITEL/SOLUTION -->

                                                  <!-- FILES FOR OBL USER -->
                                                  @if( $user_in_is->role_id === 2 || $user_in_is->role_id === 8  || $user_in_is->role_id === 9 )
                                                  <div class="row">
                                                    <div class="col">
                                                      <div class=" {{ isset($upload_doc) == false ? ' lanjut-form ' : ''  }} lanjut-form-biasa ">
                                                        <div class="row">
                                                          <div class="col d-flex">

                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_p2'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p2')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p2')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_p2"></span>
                                                            @endif

                                                            <button type="button" id="btn_clear_p2" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_p2" class="btn btn-sm bg-gradient-light label_p2"><span id="label_file_p2">Pilih File P2</span></label>
                                                            <input id="file_p2" name="file_p2" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col d-flex">
                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_p3'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p3')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p3')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_p3"></span>
                                                            @endif
                                                            <button type="button" id="btn_clear_p3" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_p3" class="btn btn-sm bg-gradient-light label_p3"><span id="label_file_p3">Pilih File P3</span></label>
                                                            <input id="file_p3" name="file_p3" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col d-flex">
                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_p4'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p4')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p4')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_p4"></span>
                                                            @endif
                                                          <button type="button" id="btn_clear_p4" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                          <label for="file_p4" class="btn btn-sm bg-gradient-light label_p4"><span id="label_file_p4">Pilih File P4</span></label>
                                                          <input id="file_p4" name="file_p4" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col d-flex">
                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_p5'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p5')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p5')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_p5"></span>
                                                            @endif
                                                            <button type="button" id="btn_clear_p5" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_p5" class="btn btn-sm bg-gradient-light label_p5"><span id="label_file_p5">Pilih File P5</span></label>
                                                            <input id="file_p5" name="file_p5" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class=" {{ isset($upload_doc) == false ? ' lanjut-form ' : ''  }} lanjut-form-biasa lanjut-form-wo ">
                                                        <div class="row">
                                                          <div class="col d-flex">

                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_p6'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p6')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p6')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_p6"></span>
                                                            @endif

                                                            <button type="button" id="btn_clear_p6" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_p6" class="btn btn-sm bg-gradient-light label_p6"><span id="label_file_p6">Pilih File P6</span></label>
                                                            <input id="file_p6" name="file_p6" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class=" {{ isset($upload_doc) == false ? ' lanjut-form ' : ''  }} lanjut-form-biasa ">
                                                        <div class="row">
                                                          <div class="col d-flex">
                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_p7'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p7')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p7')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_p7"></span>
                                                            @endif
                                                            <button type="button" id="btn_clear_p7" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_p7" class="btn btn-sm bg-gradient-light label_p7"><span id="label_file_p7">Pilih File P7</span></label>
                                                            <input id="file_p7" name="file_p7" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class=" {{ isset($upload_doc) == false ? ' lanjut-form ' : ''  }} lanjut-form-sp ">
                                                        <div class="row">
                                                          <div class="col d-flex">
                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_sp'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('sp')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('sp')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_sp"></span>
                                                            @endif
                                                            <button type="button" id="btn_clear_sp" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_sp" class="btn btn-sm bg-gradient-light label_sp"><span id="label_file_sp">Pilih File SP</span></label>
                                                            <input id="file_sp" name="file_sp" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class=" {{ isset($upload_doc) == false ? ' lanjut-form ' : ''  }} lanjut-form-wo ">
                                                        <div class="row">
                                                          <div class="col d-flex">
                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_wo'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('wo')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('wo')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_wo"></span>
                                                            @endif
                                                            <button type="button" id="btn_clear_wo" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_wo" class="btn btn-sm bg-gradient-light label_wo"><span id="label_file_wo">Pilih File WO</span></label>
                                                            <input id="file_wo" name="file_wo" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class=" {{ isset($upload_doc) == false ? ' lanjut-form ' : ''  }} lanjut-form-kl ">
                                                        <div class="row">
                                                          <div class="col d-flex">
                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_p8'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p8')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('p8')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_p8"></span>
                                                            @endif
                                                            <button type="button" id="btn_clear_p8" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_p8" class="btn btn-sm bg-gradient-light label_p8"><span id="label_file_p8">Pilih File P8</span></label>
                                                            <input id="file_p8" name="file_p8" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                        <div class="row">
                                                          <div class="col d-flex">
                                                            @if( isset($upload_doc) )
                                                              @if( $upload_doc[0]['nama_kl'] !== '' )
                                                              <a target="_blank" href="{{ route('obl.files.visibility',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('kl')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <a href="{{ route('obl.files.download',['rt'=>1,'st'=>$upload_doc[0]['id'],'ft'=>Crypt::encrypt('kl')]) }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @else
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                                                              @endif
                                                            @else
                                                            <span class="d-flex" id="btns_file_kl"></span>
                                                            @endif
                                                            <button type="button" id="btn_clear_kl" class="mt-0 btn btn-link  btn-setting btn-link-clear  d-flex py-2 mb-2"><i class="material-icons opacity-7">backspace</i></button>
                                                            <label for="file_kl" class="btn btn-sm bg-gradient-light label_kl"><span id="label_file_kl">Pilih File KL</span></label>
                                                            <input id="file_kl" name="file_kl" style="visibility:hidden;" type="file">
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  @endif
                                                  <!-- END FILE USER OBL -->

                                                </td>
                                            </tr>
                                            <tr><td>

                                              @if(isset($upload_doc))
                                                  @if( $user_in_is->role_id === 5  )
                                                  <a href="{{ route('obl.tables') }}" role="button" id="btn-kembali-upload" class="mb-3 btn btn-lg bg-gradient-light shadow-primary text-sm" aria-pressed="true">KEMBALI</a>
                                                  @endif
                                                  @if( $user_in_is->role_id === 1 || $user_in_is->role_id === 3  || $user_in_is->role_id === 7 )
                                                  <a href="{{ route('obl.tables') }}" role="button" id="btn-kembali-upload" class="mb-3 btn btn-lg bg-gradient-secondary text-sm" aria-pressed="true">KEMBALI</a>
                                                  @endif
                                                  @if( $user_in_is->role_id === 4 || $user_in_is->role_id === 8 )
                                                    @if( $user_in_is->role_id === 4 && $upload_doc[0]['revisi_witel'] === true )
                                                    <input type="text" name="submit_upload_doc_id" value="{{ $upload_doc[0]['id'] }}" hidden>
                                                    <a href="{{ route('obl.tables') }}" role="button" id="btn-kembali-upload" class="mb-3 btn btn-lg bg-gradient-light shadow-primary text-sm" aria-pressed="true">KEMBALI</a>
                                                    <button type="submit" name="submit" id="submit_upload" class="btn btn-lg bg-gradient-primary"><h6 class="mb-0 text-sm" style="color:white;">UPLOAD</h6></button>
                                                    <button type="button" id="submit_upload_loading" class="btn btn-lg bg-gradient-primary btn-submit-loading" disabled><h6 class="mb-0 text-sm" style="color:white;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading</h6></button>
                                                    @elseif( $user_in_is->role_id === 4 && $upload_doc[0]['revisi_witel'] === false )
                                                    <a href="{{ route('obl.tables') }}" role="button" id="btn-kembali-upload" class="mb-3 btn btn-lg bg-gradient-light shadow-primary text-sm" aria-pressed="true">KEMBALI</a>
                                                    @elseif( $user_in_is->role_id === 8 && $upload_doc[0]['f1_proses'] !== 'witel' )
                                                    <a href="{{ route('obl.tables') }}" role="button" id="btn-kembali-upload" class="mb-3 btn btn-lg bg-gradient-secondary text-sm" aria-pressed="true">KEMBALI</a>
                                                    @elseif( $user_in_is->role_id === 8 && $upload_doc[0]['f1_proses'] === 'witel' )
                                                    <input type="text" name="submit_upload_doc_id" value="{{ $upload_doc[0]['id'] }}" hidden>
                                                    <a href="{{ route('obl.tables') }}" role="button" id="btn-kembali-upload" class="mb-3 btn btn-lg bg-gradient-secondary text-sm" aria-pressed="true">KEMBALI</a>
                                                    <button type="submit" name="submit" id="submit_upload" class="btn btn-lg bg-upload-btn"><h6 class="mb-0 text-sm" style="color:white;">UPLOAD</h6></button>
                                                    <button type="button" id="submit_upload_loading" class="btn btn-lg bg-upload-btn btn-submit-loading" disabled><h6 class="mb-0 text-sm" style="color:white;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading</h6></button>
                                                    @endif
                                                  @endif
                                                  @if( $user_in_is->role_id === 2 || $user_in_is->role_id === 9 )
                                                  <input type="text" name="submit_upload_doc_id" value="{{ $upload_doc[0]['id'] }}" hidden>
                                                  <a href="{{ route('obl.tables') }}" role="button" id="btn-kembali-upload" class="mb-3 btn btn-lg bg-gradient-secondary text-sm" aria-pressed="true">KEMBALI</a>
                                                  <button type="submit" name="submit" id="submit_upload" class="btn btn-lg bg-upload-btn"><h6 class="mb-0 text-sm" style="color:white;">UPLOAD</h6></button>
                                                  <button type="button" id="submit_upload_loading" class="btn btn-lg bg-upload-btn btn-submit-loading" disabled><h6 class="mb-0 text-sm" style="color:white;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading</h6></button>
                                                  @endif
                                              @else
                                                  @if( $user_in_is->role_id === 1 || $user_in_is->role_id === 3 || $user_in_is->role_id === 5 || $user_in_is->role_id === 7 )
                                                  @endif
                                                  @if( $user_in_is->role_id === 4 || $user_in_is->role_id === 8 )
                                                    @if( isset($upload_doc) )
                                                    @else
                                                        @if( $user_in_is->role_id === 4 )
                                                        @elseif( $user_in_is->role_id === 8 )
                                                            <input type="text" name="submit_upload_doc_id" id="submit_upload_doc_id"  hidden>
                                                            <a href="{{ route('obl.upload.index') }}" role="button" id="btn-kembali-upload" class="mb-8 btn btn-lg btn-kembali-upload bg-gradient-secondary text-sm" aria-pressed="true">KEMBALI</a>
                                                            <button type="submit" name="submit" id="submit_upload" class="mt-3 btn btn-lg btn-submit-upload bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">UPLOAD</h6></button>
                                                            <button type="button" id="submit_upload_loading" class="mt-3 btn btn-lg btn-submit-loading bg-gradient-info" disabled><h6 class="mb-0 text-sm" style="color:white;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading</h6></button>
                                                        @endif
                                                    @endif
                                                  @endif
                                                  @if( $user_in_is->role_id === 2 || $user_in_is->role_id === 9 )
                                                  <input type="text" name="submit_upload_doc_id" id="submit_upload_doc_id"  hidden>
                                                  <a href="{{ route('obl.upload.index') }}" role="button" id="btn-kembali-upload" class="mb-8 btn btn-lg btn-kembali-upload bg-gradient-secondary text-sm" aria-pressed="true">KEMBALI</a>
                                                  <button type="submit" name="submit" id="submit_upload" class="mt-3 btn btn-lg btn-submit-upload bg-gradient-info"><h6 class="mb-0 text-sm" style="color:white;">UPLOAD</h6></button>
                                                  <button type="button" id="submit_upload_loading" class="mt-3 btn btn-lg btn-submit-loading bg-gradient-info" disabled><h6 class="mb-0 text-sm" style="color:white;"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading</h6></button>
                                                  @endif
                                              @endif

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

        function clearAllFile(){
          $('#file_p0').val('');
          $('#label_file_p0').empty(); $('#label_file_p0').append(`Pilih File P0`);
          $('#file_p1').val('');
          $('#label_file_p1').empty(); $('#label_file_p1').append(`Pilih File P1`);
          $('#file_p2').val('');
          $('#label_file_p2').empty(); $('#label_file_p2').append(`Pilih File P2`);
          $('.label_p3').removeClass('bg-gradient-secondary'); $('.label_p2').addClass('bg-gradient-light');
          $('#file_p3').val('');
          $('#label_file_p3').empty(); $('#label_file_p3').append(`Pilih File P3`);
          $('.label_p3').removeClass('bg-gradient-secondary'); $('.label_p3').addClass('bg-gradient-light');
          $('#file_p4').val('');
          $('#label_file_p4').empty(); $('#label_file_p4').append(`Pilih File P4`);
          $('.label_p4').removeClass('bg-gradient-secondary'); $('.label_p4').addClass('bg-gradient-light');
          $('#file_p5').val('');
          $('#label_file_p5').empty(); $('#label_file_p5').append(`Pilih File P5`);
          $('.label_p5').removeClass('bg-gradient-secondary'); $('.label_p5').addClass('bg-gradient-light');
          $('#file_p6').val('');
          $('#label_file_p6').empty(); $('#label_file_p6').append(`Pilih File P6`);
          $('.label_p6').removeClass('bg-gradient-secondary'); $('.label_p6').addClass('bg-gradient-light');
          $('#file_p7').val('');
          $('#label_file_p7').empty(); $('#label_file_p7').append(`Pilih File P7`);
          $('.label_p7').removeClass('bg-gradient-secondary'); $('.label_p7').addClass('bg-gradient-light');
          $('#file_p8').val('');
          $('#label_file_p8').empty(); $('#label_file_p8').append(`Pilih File P8`);
          $('.label_p8').removeClass('bg-gradient-secondary'); $('.label_p8').addClass('bg-gradient-light');
          $('#file_sp').val('');
          $('#label_file_sp').empty(); $('#label_file_sp').append(`Pilih File SP`);
          $('.label_sp').removeClass('bg-gradient-secondary'); $('.label_sp').addClass('bg-gradient-light');
          $('#file_wo').val('');
          $('#label_file_wo').empty(); $('#label_file_wo').append(`Pilih File WO`);
          $('.label_wo').removeClass('bg-gradient-secondary'); $('.label_wo').addClass('bg-gradient-light');
          $('#file_kl').val('');
          $('#label_file_kl').empty(); $('#label_file_kl').append(`Pilih File KL`);
          $('.label_kl').removeClass('bg-gradient-secondary'); $('.label_kl').addClass('bg-gradient-light');
        }

        $('#btn_clear_p0').on('click', function() {
          $('#file_p0').val('');
          $('#label_file_p0').empty(); $('#label_file_p0').append(`Pilih File P0`);
          $('.label_p0').removeClass('bg-gradient-secondary'); $('.label_p0').addClass('bg-gradient-light');
        });
        $('#btn_clear_p1').on('click', function() {
          $('#file_p1').val('');
          $('#label_file_p1').empty(); $('#label_file_p1').append(`Pilih File P1`);
          $('.label_p1').removeClass('bg-gradient-secondary'); $('.label_p1').addClass('bg-gradient-light');
        });
        $('#btn_clear_p2').on('click', function() {
          $('#file_p2').val('');
          $('#label_file_p2').empty(); $('#label_file_p2').append(`Pilih File P2`);
          $('.label_p2').removeClass('bg-gradient-secondary'); $('.label_p2').addClass('bg-gradient-light');
        });
        $('#btn_clear_p3').on('click', function() {
          $('#file_p3').val('');
          $('#label_file_p3').empty(); $('#label_file_p3').append(`Pilih File P3`);
          $('.label_p3').removeClass('bg-gradient-secondary'); $('.label_p3').addClass('bg-gradient-light');
        });
        $('#btn_clear_p4').on('click', function() {
          $('#file_p4').val('');
          $('#label_file_p4').empty(); $('#label_file_p4').append(`Pilih File P4`);
          $('.label_p4').removeClass('bg-gradient-secondary'); $('.label_p4').addClass('bg-gradient-light');
        });
        $('#btn_clear_p5').on('click', function() {
          $('#file_p5').val('');
          $('#label_file_p5').empty(); $('#label_file_p5').append(`Pilih File P5`);
          $('.label_p5').removeClass('bg-gradient-secondary'); $('.label_p5').addClass('bg-gradient-light');
        });
        $('#btn_clear_p6').on('click', function() {
          $('#file_p6').val('');
          $('#label_file_p6').empty(); $('#label_file_p6').append(`Pilih File P6`);
          $('.label_p6').removeClass('bg-gradient-secondary'); $('.label_p6').addClass('bg-gradient-light');
        });
        $('#btn_clear_p7').on('click', function() {
          $('#file_p7').val('');
          $('#label_file_p7').empty(); $('#label_file_p7').append(`Pilih File P7`);
          $('.label_p7').removeClass('bg-gradient-secondary'); $('.label_p7').addClass('bg-gradient-light');
        });
        $('#btn_clear_p8').on('click', function() {
          $('#file_p8').val('');
          $('#label_file_p8').empty(); $('#label_file_p8').append(`Pilih File P8`);
          $('.label_p8').removeClass('bg-gradient-secondary'); $('.label_p8').addClass('bg-gradient-light');
        });
        $('#btn_clear_sp').on('click', function() {
          $('#file_sp').val('');
          $('#label_file_sp').empty(); $('#label_file_sp').append(`Pilih File SP`);
          $('.label_sp').removeClass('bg-gradient-secondary'); $('.label_sp').addClass('bg-gradient-light');
        });
        $('#btn_clear_wo').on('click', function() {
          $('#file_wo').val('');
          $('#label_file_wo').empty(); $('#label_file_wo').append(`Pilih File WO`);
          $('.label_wo').removeClass('bg-gradient-secondary'); $('.label_wo').addClass('bg-gradient-light');
        });
        $('#btn_clear_kl').on('click', function() {
          $('#file_kl').val('');
          $('#label_file_kl').empty(); $('#label_file_kl').append(`Pilih File KL`);
          $('.label_kl').removeClass('bg-gradient-secondary'); $('.label_kl').addClass('bg-gradient-light');
        });

        $("#file_p0").change(function() {
          // filename = this.files[0].name;
          // console.log(filename);
            $('.label_p0').removeClass('bg-gradient-light');
            $('#label_file_p0').empty();
            $('#label_file_p0').append(this.files[0].name);
            $('.label_p0').addClass('bg-gradient-secondary');
        });
        $("#file_p1").change(function() {
          // filename = this.files[0].name;
          // console.log(filename);
            $('.label_p1').removeClass('bg-gradient-light');
            $('#label_file_p1').empty();
            $('#label_file_p1').append(this.files[0].name);
            $('.label_p1').addClass('bg-gradient-secondary');
        });
        $("#file_p2").change(function() {
          // filename = this.files[0].name;
          // console.log(filename);
            $('.label_p2').removeClass('bg-gradient-light');
            $('#label_file_p2').empty();
            $('#label_file_p2').append(this.files[0].name);
            $('.label_p2').addClass('bg-gradient-secondary');
        });
        $("#file_p3").change(function() {
            $('.label_p3').removeClass('bg-gradient-light');
            $('#label_file_p3').empty();
            $('#label_file_p3').append(this.files[0].name);
            $('.label_p3').addClass('bg-gradient-secondary');
        });
        $("#file_p4").change(function() {
            $('.label_p4').removeClass('bg-gradient-light');
            $('#label_file_p4').empty();
            $('#label_file_p4').append(this.files[0].name);
            $('.label_p4').addClass('bg-gradient-secondary');
        });
        $("#file_p5").change(function() {
            $('.label_p5').removeClass('bg-gradient-light');
            $('#label_file_p5').empty();
            $('#label_file_p5').append(this.files[0].name);
            $('.label_p5').addClass('bg-gradient-secondary');
        });
        $("#file_p6").change(function() {
            $('.label_p6').removeClass('bg-gradient-light');
            $('#label_file_p6').empty();
            $('#label_file_p6').append(this.files[0].name);
            $('.label_p6').addClass('bg-gradient-secondary');
        });
        $("#file_p7").change(function() {
            $('.label_p7').removeClass('bg-gradient-light');
            $('#label_file_p7').empty();
            $('#label_file_p7').append(this.files[0].name);
            $('.label_p7').addClass('bg-gradient-secondary');
        });
        $("#file_p8").change(function() {
            $('.label_p8').removeClass('bg-gradient-light');
            $('#label_file_p8').empty();
            $('#label_file_p8').append(this.files[0].name);
            $('.label_p8').addClass('bg-gradient-secondary');
        });
        $("#file_sp").change(function() {
            $('.label_sp').removeClass('bg-gradient-light');
            $('#label_file_sp').empty();
            $('#label_file_sp').append(this.files[0].name);
            $('.label_sp').addClass('bg-gradient-secondary');
        });
        $("#file_wo").change(function() {
            $('.label_wo').removeClass('bg-gradient-light');
            $('#label_file_wo').empty();
            $('#label_file_wo').append(this.files[0].name);
            $('.label_wo').addClass('bg-gradient-secondary');
        });
        $("#file_kl").change(function() {
            $('.label_kl').removeClass('bg-gradient-light');
            $('#label_file_kl').empty();
            $('#label_file_kl').append(this.files[0].name);
            $('.label_kl').addClass('bg-gradient-secondary');
        });


        var data_upload_doc = null;
          function cariUploadDoc(){
            $('#btns_file_p0').empty();
            $('#btns_file_p1').empty();
            $('#btns_file_p2').empty();
            $('#btns_file_p3').empty();
            $('#btns_file_p4').empty();
            $('#btns_file_p5').empty();
            $('#btns_file_p6').empty();
            $('#btns_file_p7').empty();
            $('#btns_file_p8').empty();
            $('#btns_file_sp').empty();
            $('#btns_file_wo').empty();
            $('#btns_file_kl').empty();

            $('#judul_hasil_cari').empty();
            $('.btn-cari').hide();
            $('#btn-lanjut').hide();
            $('.btn-loading').show();
            $('#label_upload_doc').empty();
            let f1_segmen = $('#f1_segmen').val();
            let folder = $('#folder').val();
            let tahun = $('#tahun').val();
            $.ajax({
               type:'POST',
               url:"{{ route('obl.upload.cari') }}",
               data:{
                 _token: "{{ csrf_token() }}",
                 f1_segmen:f1_segmen,
                 folder:folder,
                 tahun:tahun
               },
               success:function(data){
                 if(data.status_id==='3'){
                   $('.btn-loading').hide();
                   $('#btn-lanjut').hide();
                   $('.btn-cari').show();
                   if( data.is_segmen_ok === false ){ $('#f1_segmen').removeClass(' is-valid text-success '); $('#f1_segmen').addClass(' is-invalid text-danger ');  }
                   if( data.is_folder_ok === false ){ $('#folder').removeClass(' is-valid text-success '); $('#folder').addClass(' is-invalid text-danger ');  }
                   if( data.is_tahun_ok === false ){ $('#tahun').removeClass(' is-valid text-success '); $('#tahun').addClass(' is-invalid text-danger ');  }
                   $('#label_upload_doc').append(`<i class="material-icons opacity-7">warning</i>`+data.status);
                 }
                 if(data.status_id==='2'){
                   $('.btn-loading').hide();
                   $('#btn-lanjut').hide();
                   $('.btn-cari').show();
                   $('#f1_segmen').removeClass(' is-valid text-success ');
                   $('#folder').removeClass(' is-valid text-success ');
                   $('#tahun').removeClass(' is-valid text-success ');
                   $('#f1_segmen').addClass(' is-invalid text-danger ');
                   $('#folder').addClass(' is-invalid text-danger ');
                   $('#tahun').addClass(' is-invalid text-danger ');
                   $('#label_upload_doc').append(`<i class="material-icons opacity-7">warning</i>`+data.status);
                 }
                 if(data.status_id==='1'){
                   let temp_upload_doc_id = data.upload_doc[0]['id'];
                   $('.btn-loading').hide();
                   $('.btn-cari').show();
                   $('#btn-lanjut').show();
                   $('#f1_segmen').removeClass(' is-invalid text-danger ');
                   $('#folder').removeClass(' is-invalid text-danger ');
                   $('#tahun').removeClass(' is-invalid text-danger ');
                   $('#f1_segmen').addClass(' is-valid text-success ');
                   $('#folder').addClass(' is-valid text-success ');
                   $('#tahun').addClass(' is-valid text-success ');
                   data_upload_doc = data.upload_doc[0]['f1_jenis_spk'];
                   $('#submit_upload_doc_id').val(temp_upload_doc_id);
                   $('#judul_hasil_cari').append(`: ` + data.upload_doc[0]['f1_segmen']+' / '+data.upload_doc[0]['folder']+' / '+ data.upload_doc[0]['tahun'] + ' / ' + data.upload_doc[0]['f1_jenis_spk'] + ` / ` + data.upload_doc[0]['f1_judul_projek']);

                   // FILE P0
                   if( data.upload_doc[0]['nama_p0'] !== '' ){
                     if( data.user_in_is['role_id'] === 1 || data.user_in_is['role_id'] === 3 || data.user_in_is['role_id'] === 7){
                       $('#btns_file_p0').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 5 ){
                       $('#btns_file_p0').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 4 && data.upload_doc[0]['revisi_witel'] === true ){
                       $('#btns_file_p0').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label for="file_p0" class="btn btn-sm bg-gradient-light label_p0"><span id="label_file_p0">Pilih File P0</span></label>
                         <input id="file_p0" name="file_p0" style="visibility:hidden;" type="file">
                         `);
                     }
                     if( data.user_in_is['role_id'] === 4 && data.upload_doc[0]['revisi_witel'] === false ){
                       $('#btns_file_p0').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 8 && data.upload_doc[0]['f1_proses'] === 'witel' ){
                       $('#btns_file_p0').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label for="file_p0" class="btn btn-sm bg-gradient-light label_p0"><span id="label_file_p0">Pilih File P0</span></label>
                         <input id="file_p0" name="file_p0" style="visibility:hidden;" type="file">
                         `);
                     }
                     if( data.user_in_is['role_id'] === 8 && data.upload_doc[0]['f1_proses'] !== 'witel' ){
                       $('#btns_file_p0').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 2 || data.user_in_is['role_id'] === 9  ){
                       $('#btns_file_p0').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p0') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                   }
                   else{
                     if( data.user_in_is['role_id'] === 1 || data.user_in_is['role_id'] === 3 || data.user_in_is['role_id'] === 7){
                       $('#btns_file_p0').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 5 ){
                       $('#btns_file_p0').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 4 && data.upload_doc[0]['revisi_witel'] === true ){
                       $('#btns_file_p0').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label for="file_p0" class="btn btn-sm bg-gradient-light label_p0"><span id="label_file_p0">Pilih File P0</span></label>
                         <input id="file_p0" name="file_p0" style="visibility:hidden;" type="file">
                         `);
                     }
                     if( data.user_in_is['role_id'] === 4 && data.upload_doc[0]['revisi_witel'] === false ){
                       $('#btns_file_p0').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 8 && data.upload_doc[0]['f1_proses'] === 'witel' ){
                       $('#btns_file_p0').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label for="file_p0" class="btn btn-sm bg-gradient-light label_p0"><span id="label_file_p0">Pilih File P0</span></label>
                         <input id="file_p0" name="file_p0" style="visibility:hidden;" type="file">
                         `);
                     }
                     if( data.user_in_is['role_id'] === 8 && data.upload_doc[0]['f1_proses'] !== 'witel' ){
                       $('#btns_file_p0').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 2 || data.user_in_is['role_id'] === 9  ){
                       $('#btns_file_p0').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p0">File P0</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                   }

                   // FILE P1
                   if( data.upload_doc[0]['nama_p1'] !== '' ){
                     if( data.user_in_is['role_id'] === 1 || data.user_in_is['role_id'] === 3 || data.user_in_is['role_id'] === 7){
                       $('#btns_file_p1').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 5 ){
                       $('#btns_file_p1').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 4 && data.upload_doc[0]['revisi_witel'] === true ){
                       $('#btns_file_p1').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label for="file_p1" class="btn btn-sm bg-gradient-light label_p1"><span id="label_file_p1">Pilih File P1</span></label>
                         <input id="file_p1" name="file_p1" style="visibility:hidden;" type="file">
                         `);
                     }
                     if( data.user_in_is['role_id'] === 4 && data.upload_doc[0]['revisi_witel'] === false ){
                       $('#btns_file_p1').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p1" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 8 && data.upload_doc[0]['f1_proses'] === 'witel' ){
                       $('#btns_file_p1').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p0" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label for="file_p1" class="btn btn-sm bg-gradient-light label_p1"><span id="label_file_p1">Pilih File P1</span></label>
                         <input id="file_p1" name="file_p1" style="visibility:hidden;" type="file">
                         `);
                     }
                     if( data.user_in_is['role_id'] === 8 && data.upload_doc[0]['f1_proses'] !== 'witel' ){
                       $('#btns_file_p1').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 2 || data.user_in_is['role_id'] === 9  ){
                       $('#btns_file_p1').append(`
                         <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p1') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                   }
                   else{
                     if( data.user_in_is['role_id'] === 1 || data.user_in_is['role_id'] === 3 || data.user_in_is['role_id'] === 7){
                       $('#btns_file_p1').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 5 ){
                       $('#btns_file_p1').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 4 && data.upload_doc[0]['revisi_witel'] === true ){
                       $('#btns_file_p1').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p1" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label for="file_p1" class="btn btn-sm bg-gradient-light label_p1"><span id="label_file_p1">Pilih File P1</span></label>
                         <input id="file_p1" name="file_p1" style="visibility:hidden;" type="file">
                         `);
                     }
                     if( data.user_in_is['role_id'] === 4 && data.upload_doc[0]['revisi_witel'] === false ){
                       $('#btns_file_p1').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p1" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 8 && data.upload_doc[0]['f1_proses'] === 'witel' ){
                       $('#btns_file_p1').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" id="btn_clear_p1" class="mb-4 btn btn-link  btn-setting btn-link-clear "><i class="material-icons opacity-7">backspace</i></button>
                         <label for="file_p1" class="btn btn-sm bg-gradient-light label_p1"><span id="label_file_p1">Pilih File P1</span></label>
                         <input id="file_p1" name="file_p1" style="visibility:hidden;" type="file">
                         `);
                     }
                     if( data.user_in_is['role_id'] === 8 && data.upload_doc[0]['f1_proses'] !== 'witel' ){
                       $('#btns_file_p1').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                     if( data.user_in_is['role_id'] === 2 || data.user_in_is['role_id'] === 9  ){
                       $('#btns_file_p1').append(`
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                         <label class="btn btn-sm bg-gradient-light label_p1">File P1</label>
                         <input style="visibility:hidden;" type="file" disabled>
                         `);
                     }
                   }
                   // FILE P2
                   if( data.upload_doc[0]['nama_p2'] !== '' ){
                     $('#btns_file_p2').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p2') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p2') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_p2').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE P3
                   if( data.upload_doc[0]['nama_p3'] !== '' ){
                     $('#btns_file_p3').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p3') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p3') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_p3').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE P4
                   if( data.upload_doc[0]['nama_p4'] !== '' ){
                     $('#btns_file_p4').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p4') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p4') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_p4').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE P5
                   if( data.upload_doc[0]['nama_p5'] !== '' ){
                     $('#btns_file_p5').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p5') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p5') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_p5').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE P6
                   if( data.upload_doc[0]['nama_p6'] !== '' ){
                     $('#btns_file_p6').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p6') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p6') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_p6').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE P7
                   if( data.upload_doc[0]['nama_p7'] !== '' ){
                     $('#btns_file_p7').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p7') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p7') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_p7').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE P8
                   if( data.upload_doc[0]['nama_p8'] !== '' ){
                     $('#btns_file_p8').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p8') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('p8') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_p8').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE SP
                   if( data.upload_doc[0]['nama_sp'] !== '' ){
                     $('#btns_file_sp').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('sp') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('sp') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_sp').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE WO
                   if( data.upload_doc[0]['nama_wo'] !== '' ){
                     $('#btns_file_wo').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('wo') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('wo') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_wo').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   // FILE KL
                   if( data.upload_doc[0]['nama_kl'] !== '' ){
                     $('#btns_file_kl').append(`
                       <a target="_blank" href="{{ route('obl.files.visibility' ) }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('kl') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-visibility  d-flex py-2 mb-2"><i class="material-icons opacity-7">visibility</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <a href="{{ route('obl.files.download') }}?st=`+temp_upload_doc_id+`&ft={{ Crypt::encrypt('kl') }}" role="button" class="mt-0 btn btn-link  btn-setting btn-link-download  d-flex py-2 mb-2"><i class="material-icons opacity-7">download</i></a>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }
                   else{
                     $('#btns_file_kl').append(`
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">visibility</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       <button type="button" class="mt-0 btn btn-link  btn-setting bg-btn-disabled  d-flex py-2 mb-2" disabled><i class="material-icons opacity-5">download</i></button>&nbsp;&nbsp;▪&nbsp;&nbsp;
                       `);
                   }

                   $('#btn_clear_p0').on('click', function() {
                     $('#file_p0').val('');
                     $('#label_file_p0').empty(); $('#label_file_p0').append(`Pilih File P0`);
                     $('.label_p0').removeClass('bg-gradient-secondary'); $('.label_p0').addClass('bg-gradient-light');
                   });
                   $('#btn_clear_p1').on('click', function() {
                     $('#file_p1').val('');
                     $('#label_file_p1').empty(); $('#label_file_p1').append(`Pilih File P1`);
                     $('.label_p1').removeClass('bg-gradient-secondary'); $('.label_p1').addClass('bg-gradient-light');
                   });
                   $("#file_p0").change(function() {
                       $('.label_p0').removeClass('bg-gradient-light');
                       $('#label_file_p0').empty();
                       $('#label_file_p0').append(this.files[0].name);
                       $('.label_p0').addClass('bg-gradient-secondary');
                   });
                   $("#file_p1").change(function() {
                       $('.label_p1').removeClass('bg-gradient-light');
                       $('#label_file_p1').empty();
                       $('#label_file_p1').append(this.files[0].name);
                       $('.label_p1').addClass('bg-gradient-secondary');
                   });

                 }
               },
               error: function(xhr, textStatus, error) {
                   $('.btn-loading').hide();
                   $('#btn-lanjut').hide();
                   $('.btn-cari').show();
                   alert('Gagal Ambil Data Dokumen OBL!');
                }
             });
          }

          $('#btn-lanjut').click(function(){
            clearAllFile();
            $('.btn-cari').hide(); $(this).hide(); $('#label_upload_doc').empty();
            $('#f1_segmen').attr('disabled',true);
            $('#folder').attr('disabled',true);
            $('#tahun').attr('disabled',true);
            $('.lanjut-head').show();
            $('.btn-submit-upload').show(); $('.btn-kembali-upload').show();
            if(data_upload_doc==='SP'){ $('.lanjut-form-kl').hide(); $('.lanjut-form-wo').hide(); $('.lanjut-form-biasa').show(); $('.lanjut-form-sp').show(); }
            if(data_upload_doc==='WO'){ $('.lanjut-form-kl').hide(); $('.lanjut-form-sp').hide(); $('.lanjut-form-biasa').hide(); $('.lanjut-form-wo').show(); }
            if(data_upload_doc==='KL'){ $('.lanjut-form-sp').hide(); $('.lanjut-form-wo').hide(); $('.lanjut-form-biasa').show(); $('.lanjut-form-kl').show(); }
          });

          $(".btn-link-visibility").attr("data-bs-toggle", "popover").attr("title","View File").append();
          $(".btn-link-download").attr("data-bs-toggle", "popover").attr("title","Download File").append();
          $(".btn-link-clear").attr("data-bs-toggle", "popover").attr("title","Undo Select File").append();

          $( document ).ready(function() {
            $('#modal-status-upload-obl').modal({show:false});
              checkModalUpload();

              function checkModalUpload(){
                var session_status = "{{ session('status') }}";

                if(session_status && typeof session_status !== undefined){
                  $('#status-upload-obl').empty();
                  if(session_status.includes('Sukses')){
                    $('#status-upload-obl').append(`
                      <div class="alert alert-success alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+session_status+`</h5>
                          </div>
                      </div>
                    `);
                  }
                  else if(session_status.includes('Tidak')){
                    $('#status-upload-obl').append(`
                      <div class="alert alert-warning alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+session_status+`</h5>
                          </div>
                      </div>
                    `);
                  }
                  else if(session_status.includes('Oops')){
                    $('#status-upload-obl').append(`
                      <div class="alert alert-danger alert-dismissible">
                          <div class="text-center">
                              <h5 class="text-white">`+session_status+`</h5>
                          </div>
                      </div>
                    `);

                  }
                  $('#modal-status-upload-obl').modal('show');
                }
              }

              $('#formObl').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $('#submit_upload').hide();
                $('.btn-submit-loading').show();
                $.ajax({
                  type:'POST',
                  url:"{{ route('obl.upload.create') }}",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(data) {

                    $('#status-upload-obl').empty();
                    if( data ){
                      if( data.status.includes('Oops') ){
                        $('#status-upload-obl').append(`
                          <div class="alert alert-danger alert-dismissible">
                              <div class="text-center">
                                  <h5 class="text-white">`+data.status+`</h5>
                              </div>
                          </div>
                        `);
                      }
                      if( data.status.includes('Tidak') ){
                        $('#status-upload-obl').append(`
                          <div class="alert alert-warning alert-dismissible">
                              <div class="text-center">
                                  <h5 class="text-white">`+data.status+`</h5>
                              </div>
                          </div>
                        `);
                      }
                      if( data.status.includes('Sukses') ){
                        $('#status-upload-obl').append(`
                          <div class="alert alert-success alert-dismissible">
                              <div class="text-center">
                                  <h5 class="text-white">`+data.status+`</h5>
                              </div>
                          </div>
                        `);
                      }

                    }
                    else{
                      $('#status-upload-obl').append(`
                        <div class="alert alert-danger alert-dismissible">
                            <div class="text-center">
                                <h5 class="text-white">Oops! Hasil Proses Tidak Berhasil Diambil.</h5>
                            </div>
                        </div>
                      `);
                    }
                    $('.btn-submit-loading').hide();
                    $('#submit_upload').show();
                    $('#modal-status-upload-obl').modal('show');

                  }
                });
              });

          });

        </script>
        @endpush
</x-layout>
