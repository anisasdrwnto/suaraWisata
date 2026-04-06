$(document).ready(function(){
    $('#messagelogout').click(function(){
        Swal.fire({
            title             : 'Yakin ingin log out?',
            icon              : 'warning',
            showCancelButton  : true,
            confirmButtonColor: '#d33',
            cancelButtonColor : '#6c757d',
            confirmButtonText : 'Ya, Log Out',
            cancelButtonText  : 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                window.location.href = "index.php";
            }
        })
    });
})