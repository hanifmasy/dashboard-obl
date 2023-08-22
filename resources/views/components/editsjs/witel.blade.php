@props([
    'table_edit'
])

<script>
    $( document ).ready(function() {

        var table_edit = @json($table_edit);
        $("#formObl").submit( function(e) {
           $("<input />").attr("type", "hidden")
               .attr("name", "edit_obl_id")
               .attr("value", table_edit[0]['id'])
               .appendTo("#formObl");
           return true;
       });


        // STARTLINE: FORMAT RUPIAH FORM P5 Harga Penawaran
        var rupiah = document.getElementById('f1_nilai_kb');
        rupiah.addEventListener('keyup', function(e){
            rupiah.value = formatRupiah(this.value, 'Rp. ');
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


    });

</script>
