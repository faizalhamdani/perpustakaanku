
<script>
    $('title').text('Laporan Koleksi');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Laporan Koleksi</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Laporan Koleksi</li>
        </ol>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div id="filter_laporan" class="collapse show">
                    <!-- form -->
                    <form method="post" id="form">
                        <div class="form-row">
                            <div class="col-sm-4">
                            <input type="text" class="form-control" name="kata_kunci" placeholder="Masukan kode, judul, kategori, pengarang atau penulis">
                            </div>
                            <div class="col-sm-3">
                            <button  type="button" id="btn-tampil"  class="btn btn-dark"><span class="text"><i class="fas fa-search fa-sm"></i> Cari</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Tampil Laporan -->
        <div id="tampil_laporan">
        
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

    $(document).ready( function () {
        tabel_koleksi();
    });

    function tabel_koleksi(){
        var data = $('#form').serialize();
        $.ajax({
            type	: 'POST',
            url: 'laporan/koleksi/tampil-koleksi.php',
            data: data,
            cache	: false,
            success	: function(data){
                $("#tampil_laporan").html(data);

            }
        });
    }

    function loading(){
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
    }



    //Menampilkan laporan peminjaman dengan menggunakan ajax
    $('#btn-tampil').on('click',function(){
        loading();
        tabel_koleksi();
    });

</script>