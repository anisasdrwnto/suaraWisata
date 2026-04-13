console.log("ini periksa laporan js");
var periksaLaporan = {}
 
$(document).ready(function(){
 
    // Buka modal respons saat btnRespons diklik
    $(document).on('click', '.btnRespons', function(){
        var id = $(this).data('id');
 
        $.get('proses_periksaLaporan.php', { action: 'getById', id: id }, function(response){
            console.log(response);
            var d = response.data;
            $('#id_laporan').val(d.id_laporan);
            $('#detail_id_laporan').val(d.id_laporan);
            $('#detail_nama_pelapor').val(d.nama_pelapor);
            $('#detail_alamat_pelapor').val(d.alamat_pelapor);
            $('#detail_lokasi_wisata').val(d.lokasi_wisata);
            $('#detail_isi_laporan').val(d.isi_laporan);
            $('#status').val(d.status ? d.status : 'Menunggu');
            $('#respons_admin').val(d.respons_admin ? d.respons_admin : '');
            $('#modalRespons').modal('show');
        }, 'json');
    });
 
    // Simpan respons admin
    $('#btnSimpanRespons').click(function(){
        var json = {
            action        : 'respons',
            id_laporan    : $('#id_laporan').val(),
            status        : $('#status').val(),
            respons_admin : $('#respons_admin').val()
        };
 
        console.log(json);
 
        if(!json.respons_admin.trim()){
            Swal.fire({
                icon  : 'warning',
                title : 'Peringatan!',
                text  : 'Respons admin wajib diisi!'
            });
            return;
        }
 
        $.post('proses_periksaLaporan.php', json, function(response){
            console.log(response);
            if(response.status == 'success'){
                $('#modalRespons').modal('hide');
                loadData();
                Swal.fire({
                    icon             : 'success',
                    title            : 'Berhasil!',
                    text             : response.message,
                    timer            : 2000,
                    showConfirmButton : false
                });
            } else {
                Swal.fire({
                    icon  : 'error',
                    title : 'Gagal!',
                    text  : response.message
                });
            }
        }, 'json');
    });
 
    loadData();
 
});
 
function loadData(){
    $.get('proses_periksaLaporan.php', { action: 'read' }, function(response){
        console.log(response);
        var tbody = $('#tbodyPeriksa');
        tbody.empty();
 
        if(!response.data || response.data.length == 0){
            tbody.append(
                '<tr>' +
                    '<td colspan="9" class="text-center text-muted py-3">' +
                        '<i class="fas fa-inbox mr-2"></i> Belum ada laporan masuk' +
                    '</td>' +
                '</tr>'
            );
            return;
        }
 
        $.each(response.data, function(i, row){
 
            // Badge warna berdasarkan status
            var badgeClass = 'badge-secondary';
            if(row.status == 'Diproses') badgeClass = 'badge-warning';
            if(row.status == 'Selesai')  badgeClass = 'badge-success';
 
            var statusBadge  = '<span class="badge ' + badgeClass + '">' + (row.status ? row.status : 'Menunggu') + '</span>';
            var responsText  = row.respons_admin ? row.respons_admin : '<span class="text-muted">Belum ada respons</span>';
            var tglRespons   = row.tgl_respons   ? row.tgl_respons   : '<span class="text-muted">-</span>';
 
            tbody.append(
                '<tr id="row-' + row.id_laporan + '">' +
                    '<td class="text-center">' + (i+1) + '</td>' +
                    '<td>' + row.id_laporan    + '</td>' +
                    '<td>' + row.nama_pelapor  + '</td>' +
                    '<td>' + row.lokasi_wisata + '</td>' +
                    '<td>' + row.isi_laporan   + '</td>' +
                    '<td>' + statusBadge       + '</td>' +
                    '<td>' + responsText       + '</td>' +
                    '<td>' + tglRespons        + '</td>' +
                    '<td class="text-center">' +
                        '<button class="btn btn-primary btn-xs btnRespons" data-id="' + row.id_laporan + '">' +
                            '<i class="fas fa-reply"></i> Respons' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );
        });
 
    }, 'json');
}