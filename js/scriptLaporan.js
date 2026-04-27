console.log("ini laporan js");
const urlParams = new URLSearchParams(window.location.search);
// const currentUser = urlParams.get('user');
const currentUser = urlParams.get('id_users');
var laporan = {}

$(document).ready(function(){

    var nama_pelapor   = $('#nama_pelapor').val();
    var no_telp        = $('#nomer_telp').val();
    var email          = $('#email').val();
    var lokasi_wisata  = $('#lokasi_wisata').val();
    var infoLokasi     = $('#info_lokasi').val();
    var isi_laporan    = $('#isi_laporan').val();

    // Reset readonly saat modal ditutup
    $('#modalAddLaporan').on('hidden.bs.modal', function(){
        $('#nama_pelapor, #nomer_telp, #email, #info_lokasi, #isi_laporan').prop('readonly', false);
        $('#btnSimpanLaporan').show();
    });

   $('#btnAddLaporan').click(function(){
        $('#id_laporan').val('');
        $('#nama_pelapor').val('');
        $('#nomer_telp').val('');
        $('#email').val('');
        $('#info_lokasi').val('');
        $('#lokasi_wisata').val('');
        $('#isi_laporan').val('');
       
        // Tampilkan dropdown, sembunyikan readonly
        $('#provinsi').closest('.form-group').show();
        $('#kabkota').closest('.form-group').show();
        $('#lokasiReadonly').hide();

        loadProvinsi();
        $('.modal-title').html('<i class="fas fa-plus mr-2"></i> Add Laporan Keluhan Wisata');
        $('#modalAddLaporan').modal('show');
    });

    
$('#btnSimpanLaporan').click(function(){
    var idLaporan    = $('#id_laporan').val();
    var action       = idLaporan ? 'update' : 'create';
    var nama_pelapor = $('#nama_pelapor').val().trim();
    var no_telp      = $('#nomer_telp').val().trim();
    var email        = $('#email').val().trim();
    var infoLokasi   = $('#info_lokasi').val().trim();
    var isi_laporan  = $('#isi_laporan').val().trim();

    // Reset semua error
    $('#nama_pelapor, #nomer_telp, #email, #provinsi, #kabkota, #info_lokasi, #isi_laporan').removeClass('is-invalid');
    $('#errorNama, #errorNoTelepon, #errorEmail, #errorProvinsi, #errorKabkota, #errorInfoLokasi, #err_isi').html('');

    var isValid = 1;

    if(action === 'create'){
        if($('#provinsi').val() === ''){
            $('#provinsi').addClass('is-invalid');
            $('#errorProvinsi').html('Provinsi wajib dipilih');
            isValid = 0;
        }

        if($('#kabkota').val() === ''){
            $('#kabkota').addClass('is-invalid');
            $('#errorKabkota').html('Kabupaten wajib dipilih');
            isValid = 0;
        }

        if(nama_pelapor === ''){
            $('#nama_pelapor').addClass('is-invalid');
            $('#errorNama').html('Nama wajib diisi');
            isValid = 0;
        }

        if(no_telp === ''){
            $('#nomer_telp').addClass('is-invalid');
            $('#errorNoTelepon').html('Nomer telepon wajib diisi');
            isValid = 0;
        } else if(!/^[0-9]{10,13}$/.test(no_telp)){
            $('#nomer_telp').addClass('is-invalid');
            $('#errorNoTelepon').html('Format nomer telepon harus angka, 10-13 digit');
            isValid = 0;
        }

        if(email === ''){
            $('#email').addClass('is-invalid');
            $('#errorEmail').html('Email wajib diisi');
            isValid = 0;
        } else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){ 
            $('#email').addClass('is-invalid');
            $('#errorEmail').html('Format email tidak valid');
            isValid = 0;
        }

        if(infoLokasi === ''){
            $('#info_lokasi').addClass('is-invalid');
            $('#errorInfoLokasi').html('Lokasi wisata wajib diisi');
            isValid = 0;
        }

        if(isi_laporan === ''){
            $('#isi_laporan').addClass('is-invalid');
            $('#err_isi').html('Isi laporan wajib diisi');
            isValid = 0;
        }
    }

    if(isValid == 0) return;

        var json = {
            action        : action,
            id_users      : currentUser,
            nama_pelapor  : $('#nama_pelapor').val(),
            nomer_telp    : $('#nomer_telp').val(),   
            email         : $('#email').val(),
            lokasi_wisata : $('#lokasi_wisata').val(),
            info_lokasi   : $('#info_lokasi').val(), 
            isi_laporan   : $('#isi_laporan').val()
        };

        if(action == 'update'){
            json.id_laporan = idLaporan;
        }

    var url = '/proses/proses_laporan.php';
    $.post(url, json, function(response){
        if(response.status == 'success'){
            $('#modalAddLaporan').modal('hide');
            // Reset semua field
            $('#id_laporan, #nama_pelapor, #nomer_telp, #email, #lokasi_wisata, #info_lokasi').val('');
            $('#isi_laporan').val('');
            $('#provinsi').html('<option value="">-- Pilih Provinsi --</option>');
            $('#kabkota').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);
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
    
    $(document).on('click', '.btnEdit', function(){
    var id = $(this).data('id');

    $.get('/proses/proses_laporan.php', { action: 'getById', id: id, id_users: currentUser }, function(response){
        var d = response.data;
        $('#id_laporan').val(d.id_laporan);
        $('#nama_pelapor').val(d.nama_pelapor);
        $('#nomer_telp').val(d.nomer_telp);
        $('#email').val(d.email);
        $('#lokasi_wisata').val(d.lokasi_wisata);
        $('#info_lokasi').val(d.info_lokasi);
        $('#isi_laporan').val(d.isi_laporan);

        loadProvinsi();
        $('#lokasi_wisata').val(d.lokasi_wisata);
        // Sembunyikan dropdown, tampilkan teks lokasi lama
        $('#provinsi').closest('.form-group').hide();
        $('#kabkota').closest('.form-group').hide();
        $('#lokasiReadonlyText').val(d.lokasi_wisata);
        $('#lokasiReadonly').show();

        $('.modal-title').html('<i class="fas fa-edit mr-2"></i> Edit Laporan Wisata');
        $('#modalAddLaporan').modal('show');
    }, 'json');
});

    $(document).on('click', '.btnHapus', function(){
        var id = $(this).data('id');

        Swal.fire({
            title             : 'Yakin ingin menghapus?',
            text              : 'Data yang dihapus tidak bisa dikembalikan!',
            icon              : 'warning',
            showCancelButton  : true,
            confirmButtonColor: '#d33',
            cancelButtonColor : '#6c757d',
            confirmButtonText : 'Ya, Hapus!',
            cancelButtonText  : 'Batal'
        }).then(function(result){
            if(result.isConfirmed){
                var json = {
                    action   : 'delete',
                    id       : id,
                    id_users : currentUser
                };

                var url = '/proses/proses_laporan.php';
                $.post(url, json, function(response){
                    console.log(response);
                    if(response.status == 'success'){
                        $('#row-' + id).fadeOut(400, function(){
                            $(this).remove();
                        });
                        Swal.fire({
                            icon             : 'success',
                            title            : 'Terhapus!',
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
            }
        });

    });

    loadData();

});

function loadProvinsi() {
  $('#provinsi').html('<option value="">Memuat provinsi...</option>');
  $('#kabkota').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);

  $.ajax({
    // ✅ FIX 2: tambah / di depan URL
    url: '/api.php?action=provinsi',
    method: 'GET',
    success: function (res) {
      let options = '<option value="">-- Pilih Provinsi --</option>';
      if (res.data && res.data.length > 0) {
        res.data.forEach(function (prov) {
          options += `<option value="${prov.domain_id}">${prov.domain_name}</option>`;                       
        });
      }
      $('#provinsi').html(options);
    },
    error: function () {
      Swal.fire('Error', 'Gagal memuat data provinsi dari BPS', 'error');
    }
  });
}

$(document).on('change', '#provinsi', function () {
  const kode_prov = $(this).val();

  if (!kode_prov) {
    $('#kabkota').html('<option value="">-- Pilih Kabupaten/Kota --</option>').prop('disabled', true);
    $('#lokasi_wisata').val('');
    return;
  }

  $('#kabkota').html('<option value="">Memuat kabupaten/kota...</option>').prop('disabled', true);

  $.ajax({
    // ✅ FIX 3: tambah / di depan URL
    url: `/api.php?action=kabkota&kode=${kode_prov}`,
    method: 'GET',
    success: function (res) {
      let options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
      if (res.data && res.data.length > 0) {
        res.data.forEach(function (kab) {
          options += `<option value="${kab.domain_id}">${kab.domain_name}</option>`;
        });
      }
      $('#kabkota').html(options).prop('disabled', false);
    },
    error: function () {
      Swal.fire('Error', 'Gagal memuat data kabupaten/kota dari BPS', 'error');
    }
  });
});

$(document).on('change', '#kabkota', function () {
  const namaKab      = $(this).find('option:selected').text();
  const namaProvinsi = $('#provinsi').find('option:selected').text();
  $('#lokasi_wisata').val(`${namaKab}, ${namaProvinsi}`);
});

function loadData(){
    $.get('/proses/proses_laporan.php', { action: 'read', id_users: currentUser }, function(response){
        console.log(response);
        var tbody = $('#tbodyLaporan');
        tbody.empty();

        if(!response.data || response.data.length == 0){
            tbody.append(
                '<tr>' +
                    '<td colspan="9" class="text-center text-muted py-3">' +
                        '<i class="fas fa-inbox mr-2"></i> Belum ada data laporan' +
                    '</td>' +
                '</tr>'
            );
            return;
        }

        $.each(response.data, function(i, row){
            var actionBtn = '';
            if(row.status == 'Selesai'){
                actionBtn = '<button class="btn btn-info btn-xs mr-1 btnView" data-id="' + row.id_laporan + '">' +
                                '<i class="fas fa-eye"></i>' +
                            '</button>';
            } else {
                actionBtn = '<div class="d-flex justify-content-center">' +
                    '<button class="btn btn-warning btn-xs mr-1 btnEdit" data-id="' + row.id_laporan + '">' +
                        '<i class="fas fa-edit"></i>' +
                    '</button>' +
                    '<button class="btn btn-danger btn-xs btnHapus" data-id="' + row.id_laporan + '">' +
                        '<i class="fas fa-trash"></i>' +
                    '</button>' +
                '</div>';
            }
            
            tbody.append(
                '<tr id="row-' + row.id_laporan + '">' +
                    '<td class="text-center">' + (i+1) + '</td>' +
                    '<td>' + row.id_laporan    + '</td>' +
                    '<td>' + row.nama_pelapor  + '</td>' +
                    '<td>' + row.nomer_telp    + '</td>' +
                    '<td>' + row.email         + '</td>' +
                    '<td>' + row.lokasi_wisata + '</td>' +
                    '<td>' + row.info_lokasi   + '</td>' +
                    '<td>' + row.isi_laporan   + '</td>' +
                    '<td class="text-center">' + actionBtn + '</td>' +
                '</tr>'
            );
        });

    }, 'json');
}

$(document).on('click', '.btnView', function(){
    var id = $(this).data('id');

    $.get('/proses/proses_laporan.php', { action: 'getById', id: id, id_users: currentUser }, function(response){
        var d = response.data;
        $('#id_laporan').val(d.id_laporan);
        $('#nama_pelapor').val(d.nama_pelapor).prop('readonly', true);
        $('#nomer_telp').val(d.nomer_telp).prop('readonly', true);
        $('#email').val(d.email).prop('readonly', true);
        $('#lokasi_wisata').val(d.lokasi_wisata).prop('readonly', true);
        $('#info_lokasi').val(d.info_lokasi).prop('readonly', true);
        $('#isi_laporan').val(d.isi_laporan).prop('readonly', true);

        // Sembunyikan dropdown, tampilkan lokasi readonly
        $('#provinsi').closest('.form-group').hide();
        $('#kabkota').closest('.form-group').hide();
        $('#lokasiReadonlyText').val(d.lokasi_wisata);
        $('#lokasiReadonly').show();

        // Sembunyikan tombol Save
        $('#btnSimpanLaporan').hide();

        $('.modal-title').html('<i class="fas fa-eye mr-2"></i> Detail Laporan Wisata');
        $('#modalAddLaporan').modal('show');
    }, 'json');
});