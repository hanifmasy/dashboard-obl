@props([
    'table_edit'
])

<script>
    $( document ).ready(function() {
        $(".filterKontrak").show();

        var global_jenis_spk = '';
        $('#lanjutP2').show();
        $('.jenis_spk_kl').hide();
        $('.jenis_spk_sp').hide();

        // clear form submit after refresh browser
        $('#formObl')[0].reset();
        $("#formObl").submit( function(e) {
           $("<input />").attr("type", "hidden")
               .attr("name", "global_jenis_spk")
               .attr("value", global_jenis_spk)
               .appendTo("#formObl");
           return true;
       });

        var table_edit = @json($table_edit);

        if(table_edit[0]['f1_jenis_spk']==='WO'){ $('.jenis_spk_klsp').hide(); }
        else if(table_edit[0]['f1_jenis_spk']==='KL'||table_edit[0]['f1_jenis_spk']==='SP'){
          $('.jenis_spk_wo').hide();
          if(table_edit[0]['f1_jenis_spk']==='KL'){ $('.jenis_spk_kl').show(); }
          if(table_edit[0]['f1_jenis_spk']==='SP'){ $('.jenis_spk_sp').show(); }
        }
        else{ $('.jenis_spk_klsp').show(); $('.jenis_spk_wo').show(); }

        if(table_edit[0]['f2_nilai_kontrak']==='dibawah_100'){ $('.jenis_spk_sp').show(); }
        else if(table_edit[0]['f2_nilai_kontrak']==='diatas_100'){ $('.jenis_spk_kl').show(); }
        else{ $('.jenis_spk_sp').show(); $('.jenis_spk_kl').show(); }


        $("#formObl").submit( function(e) {
           $("<input />").attr("type", "hidden")
               .attr("name", "edit_draf_id")
               .attr("value", table_edit[0]['id'])
               .appendTo("#formObl");
           return true;
       });

       // table_edit[0]['f1_jenis_spk']

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


        $('input[type=radio][name=p3_status_rapat_pengadaan]').change(function() {
            if (this.value == 'ada') {
                $('.status_rapat_pengadaan').show();
            }
            else if (this.value == 'nada') {
                $('.status_rapat_pengadaan').hide();
            }
        });

        var view_diatas_100='';
        $('input[type=radio][name=f2_nilai_kontrak]').change(function() {
            if (this.value == 'dibawah_100') {
                global_jenis_spk = 'SP';
                view_diatas_100='0';
                $('#lanjutP2').show(); $('.hide-filterkl').show();
                $('#judulFilter').empty(); $('#judulFilter').append(`<h6 class="ps-2">SKEMA SP</h6>`);
            }
            else if (this.value == 'diatas_100') {
                global_jenis_spk = 'KL';
                view_diatas_100='1';
                $('#lanjutP2').show(); $('.hide-filterkl').show();
                $('#judulFilter').empty(); $('#judulFilter').append(`<h6 class="ps-2">SKEMA KL</h6>`);
            }
        });

        // SKEMA OBL : WO
        $('#lanjutWO2').click(function(){
          global_jenis_spk = 'WO';
          $('.filterKontrak').hide(); $('.formP6').show();
          $('#backP5').hide(); $('#lanjutP7').hide();
          $('#backKontrak2').show(); $('#lanjutWO3').show();
        });

        $('#backKontrak2').click(function(){
            global_jenis_spk = '';
            $('.formP6').hide(); $('.filterKontrak').show();
        });
        $('#lanjutWO3').click(function(){
          $('.formP6').hide(); $('.formWO').show();
        });
        $('#backP62').click(function(){
            $('.formWO').hide(); $('.formP6').show();
            $('#backP5').hide(); $('#lanjutP7').hide();
            $('#backKontrak2').show(); $('#lanjutWO3').show();
        });
        // END SKEMA OBL : WO

        $('#lanjutFilter').click(function(){ $('.filterKontrak').hide(); $('.filterAwal').show(); });
        $('#backKontrak').click(function(){ global_jenis_spk = ''; $('.filterAwal').hide();  $('.filterKontrak').show(); });
        $('#lanjutP2').click(function(){ $('.filterAwal').hide(); $('.formP2').show(); });

        $('#backFilter').click(function(){ $('.formP2').hide(); $('.filterAwal').show(); });
        $('#lanjutP3').click(function(){ $('.formP2').hide(); $('.formP3').show(); });

        $('#backP2').click(function(){ $('.formP3').hide(); $('.formP2').show(); });
        $('#lanjutP4').click(function(){ $('.formP3').hide(); $('.formP4').show(); });

        $('#backP3').click(function(){ $('.formP4').hide(); $('.formP3').show(); });
        $('#lanjutP5').click(function(){
            $('.formP4').hide(); $('.formP5').show();
        });
        $('#backP4').click(function(){ $('.formP5').hide(); $('.formP4').show(); });
        $('#lanjutP6').click(function(){
            $('.formP5').hide(); $('.formP6').show(); $('#backKontrak2').hide(); $('#lanjutWO3').hide(); $('#backP5').show(); $('#lanjutP7').show();
        });
        $('#backP5').click(function(){
            $('.formP6').hide(); $('.formP5').show();
        });
        $('#lanjutP7').click(function(){
            $('.formP6').hide(); $('.formP7').show();
            if(table_edit[0]['f1_jenis_spk']==='KL' || table_edit[0]['f2_nilai_kontrak']==='diatas_100'){ $('.dibawah-100').hide(); $('.diatas-100').show();  }
            else if(table_edit[0]['f1_jenis_spk']==='SP' || table_edit[0]['f2_nilai_kontrak']==='dibawah_100'){ $('.diatas-100').hide(); $('.dibawah-100').show();  }
            else{ $('.diatas-100').show(); $('.dibawah-100').show(); }
        });
        $('#backP6').click(function(){
            $('.formP7').hide(); $('.formP6').show();
        });
        // SKEMA OBL : SP
        $('#lanjutSP').click(function(){
            $('.formP7').hide(); $('.formSP').show();
        });
        $('#backP72').click(function(){
            $('.formSP').hide(); $('.formP7').show(); $('.diatas-100').hide(); $('.dibawah-100').show();
        });

        // SKEMA OBL : KL
        $('#lanjutP8').click(function(){
            $('.formP7').hide(); $('.formP8').show();
            if(
                $('#p7_lampiran_berkas').val() === '' ||
                $('#p7_harga_pekerjaan').val() === '' ||
                $('#p7_skema_bayar').val() === '' ||
                $('#p7_pemeriksa').val() === ''
            )
            { $('#lanjutKL').hide(); $('#suksesIsi').hide(); $('#gagalIsi').show(); $('.save-draf-p8').hide(); }
            else{ $('#gagalIsi').hide(); $('#suksesIsi').show(); $('#lanjutKL').show(); $('.save-draf-p8').show(); }
        });
        $('#backP7').click(function(){
            $('.formP8').hide(); $('.formP7').show(); $('.dibawah-100').hide(); $('.diatas-100').show();
        });
        $('#backP8').click(function(){
            $('.formKL').hide(); $('.formP8').show();
            if(
                $('#p7_lampiran_berkas').val() === '' ||
                $('#p7_harga_pekerjaan').val() === '' ||
                $('#p7_otc').val() === '' ||
                $('#p7_rincian_bulanan').val() === '' ||
                $('#p7_pemeriksa').val() === '' ||
                $('#p7_tembusan').val() === ''
            )
            { $('#lanjutKL').hide(); $('.save-draf').hide(); $('#suksesIsi').hide(); $('#gagalIsi').show(); }
            else{ $('#gagalIsi').hide(); $('#suksesIsi').show(); $('#lanjutKL').show(); $('.save-draf').show(); }
        });
        $('#lanjutKL').click(function(){
            $('.formP8').hide(); $('.formKL').show();
        });

        // INPUT TEXT : NUMERIC TYPE ONLY
        $("input[name='f1_masa_layanan_tahun']").on('input', function (e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='f1_masa_layanan_bulan']").on('input', function (e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='f1_masa_layanan_hari']").on('input', function (e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='p7_lampiran_berkas']").on('input', function (e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $("input[name='wo_jumlah_layanan']").on('input', function (e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });


        // STARTLINE: FORMAT RUPIAH FORM P5 Harga Penawaran
        var rupiah = document.getElementById('f1_nilai_kb');
        rupiah.addEventListener('keyup', function(e){
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
        var rupiah2 = document.getElementById('p5_harga_penawaran');
        rupiah2.addEventListener('keyup', function(e){
            rupiah2.value = formatRupiah(this.value, 'Rp. ');
        });
        var rupiah3 = document.getElementById('p6_harga_negosiasi');
        rupiah3.addEventListener('keyup', function(e){
            rupiah3.value = formatRupiah(this.value, 'Rp. ');
        });

        var rupiah4 = document.getElementById('p7_harga_pekerjaan');
        rupiah4.addEventListener('keyup', function(e){
            rupiah4.value = formatRupiah(this.value, 'Rp. ');
        });

        var rupiah7 = document.getElementById('wo_harga_ke_plggn');
        rupiah7.addEventListener('keyup', function(e){
            rupiah7.value = formatRupiah(this.value, 'Rp. ');
        });

        var rupiah8 = document.getElementById('wo_onetime_charge_plggn');
        rupiah8.addEventListener('keyup', function(e){
            rupiah8.value = formatRupiah(this.value, 'Rp. ');
        });

        var rupiah9 = document.getElementById('wo_monthly_plggn');
        rupiah9.addEventListener('keyup', function(e){
            rupiah9.value = formatRupiah(this.value, 'Rp. ');
        });

        var rupiah10 = document.getElementById('wo_onetime_charge_telkom');
        rupiah10.addEventListener('keyup', function(e){
            rupiah10.value = formatRupiah(this.value, 'Rp. ');
        });

        var rupiah11 = document.getElementById('wo_monthly_telkom');
        rupiah11.addEventListener('keyup', function(e){
            rupiah11.value = formatRupiah(this.value, 'Rp. ');
        });

        var rupiah12 = document.getElementById('wo_onetime_charge_mitra');
        rupiah12.addEventListener('keyup', function(e){
            rupiah12.value = formatRupiah(this.value, 'Rp. ');
        });

        var rupiah13 = document.getElementById('wo_monthly_mitra');
        rupiah13.addEventListener('keyup', function(e){
            rupiah13.value = formatRupiah(this.value, 'Rp. ');
        });
        var rupiah14 = document.getElementById('kl_bayar_dp');
        rupiah14.addEventListener('keyup', function(e){
            rupiah14.value = formatRupiah(this.value, 'Rp. ');
        });


        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        // ENDLINE: FORMAT RUPIAH FORM P5 Harga Penawaran


        // Start dd rows table p4 attendees
        var table_edit_p4_attendees = @json($table_edit_p4_attendees);
        var table_edit_p4_attendees_length = 0;
        if(table_edit_p4_attendees && table_edit_p4_attendees_length > 0){ table_edit_p4_attendees_length = table_edit_p4_attendees.length; }
        var counter = (table_edit_p4_attendees_length+1);
        $("#insertRow").on("click", function (event) {
            event.preventDefault();
            var newRow = $("<tr>");
            var cols = '';
            cols += '<th scrope="row">' + counter + '</th>';
            cols += '<td><input style="width:500px;" type="text" name="p4_attendees[]" id="p4_attendees" placeholder="Masukkan Attendees"></td>';
            cols += '<td><button style="float:left;margin-left:-250%;" type="button" class="btn btn-danger" id="deleteRow"><i class="fa fa-trash"></i></button</td>';
            newRow.append(cols);
            $("#p4_attendees").append(newRow);
            counter++;
        });
        $("#p4_attendees").on("click", "#deleteRow", function (event) {
            $(this).closest("tr").remove();
            counter -= 1
        });
        // end add rows table p4 attendees

    });

</script>
