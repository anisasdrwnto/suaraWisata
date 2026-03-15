$(document).ready(function(){
    $("#btnKirim").click(function(){
        event.preventDefault(); 
        //Ambil nilai form
        var namaPelapor   = $('#idNama').val();
        var alamatPelapor = $('#idAlamatPelapor').val();
        var lokasiWisata  = $('#idLokasi').val();
        var isiLaporan    = $('#idIsi').val();

        //Buat objek sederhana
        var laporan = {
            nama: namaPelapor,
            alamat: alamatPelapor,
            lokasi: lokasiWisata,
            isi: isiLaporan
        };

        //Ambil data lama dari localstorage
        var semuaLaporan = localStorage.getItem("laporanWisata");
        if(semuaLaporan){
            semuaLaporan = JSON.parse(semuaLaporan);
        }else{
            semuaLaporan = [];
        }

        //Tambah laporan baru
        semuaLaporan.push(laporan);

        //Simpan kembali ke localStorage
        localStorage.setItem("laporanWisata", JSON.stringify(semuaLaporan));

        alert("Laporan Wisata berhasil disimpan");
    })

})