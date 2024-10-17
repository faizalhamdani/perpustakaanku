<script>
   $(document).ready(function () {
         $(".select2").select2({
         });
   });
</script>

<main>
    <div class="container-fluid">
        <h2 class="mt-4">Data Koleksi</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data Koleksi</li>
        </ol>

        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user menambah koleksi
            if (isset($_GET['add'])) {
                //Mengecek nilai variabel add yang telah di enskripsi dengan method md5()
                if ($_GET['add']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Koleksi telah ditambah!</div>";
                }else if ($_GET['add']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Koleksi gagal ditambahkan!</div>";
                }else if  ($_GET['add']=='format_gambar_tidak_sesuai'){
                    echo"<div class='alert alert-warning'><strong>Gagal!</strong> Format gambar tidak sesuai!</div>";
                }   
            }

            if (isset($_GET['edit'])) {
            //Mengecek nilai variabel edit yang telah di enskripsi dengan method md5()
            if ($_GET['edit']=='berhasil'){
                echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Koleksi telah diupdate!</div>";
            }else if ($_GET['edit']=='gagal'){
                echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Koleksi gagal diupdate!</div>";
            }    
            }
            if (isset($_GET['hapus'])) {
            //Mengecek notifikasi hapus
            if ($_GET['hapus']=='berhasil'){
                echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Koleksi telah dihapus!</div>";
            }else if ($_GET['hapus']=='gagal'){
                echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Koleksi gagal dihapus!</div>";
            }    
            }
        ?>
      
        <div id="tampil_koleksi">
            <!-- Daftar koleksi akan ditampilkan disini -->
        </div>
        <div id='ajax-wait'>
            <img alt='loading...' src='../src/img/Rolling-1s-84px.png' />
        </div>
        <style>
            #ajax-wait {
                display: none;
                position: fixed;
                z-index: 1999
            }
        </style>
    </div>
</main>

<script>

    //Menampilkan form penyewaan
    $(document).ready(function(){
        
        $.ajax({
            type	: 'POST',
            url: 'koleksi/tampil-koleksi.php',
            data	: '',
            cache	: false,
            success	: function(data){
                $("#tampil_koleksi").html(data);
            }
        });
    });

    $('#btn-cari').on('click',function(){
        $( document ).ajaxStart(function() {
        $( "#ajax-wait" ).css({
            left: ( $( window ).width() - 32 ) / 2 + "px", // 32 = lebar gambar
            top: ( $( window ).height() - 32 ) / 2 + "px", // 32 = tinggi gambar
            display: "block"
        })
        })
        .ajaxComplete( function() {
            $( "#ajax-wait" ).fadeOut();
        });

        var data = $('#form_pencarian_koleksi').serialize();
        $.ajax({
            type	: 'POST',
            url: 'koleksi/tampil-koleksi.php',
            data: data,
            cache	: false,
            success	: function(data){
                $("#tampil_koleksi").html(data);

            }
        });
    });

</script>