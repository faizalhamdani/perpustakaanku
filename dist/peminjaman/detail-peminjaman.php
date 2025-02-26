<script>
    $('title').text('Detail peminjaman');
</script>


<main>
    <div class="container-fluid">
        <h2 class="mt-4">Detail peminjaman</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Detail peminjaman</li>
        </ol>
        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user menambah penyewaan baru
            if (isset($_GET['edit-anggota'])) {
                if ($_GET['edit-anggota']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Anggota yang meminjam koleksi berhasil diupdate</div>";
                } else if ($_GET['edit-anggota']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Anggota yang meminjam koleksi gagal diupdate</div>";
                }   
            }
        ?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary" id="judul_grafik" >Informasi Data Anggota</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table">
                                    <tbody>
                                    <?php
                                        include '../config/database.php';
                                        $kode_pinjam=$_GET['kode_pinjam'];
                                        $sql="select *
                                        from trs_pinjam p
                                        left join anggota an on an.kode_anggota=p.kode_anggota
                                        left join trs_kembali dp on dp.kode_pinjam=p.kode_pinjam
                                        left join koleksi pk on pk.kode_koleksi=dp.kode_koleksi
                                        where p.kode_pinjam='$kode_pinjam'";
                                        $query = mysqli_query($kon,$sql);    
                                        $ambil = mysqli_fetch_array($query);
                                        $kode_anggota=$ambil['kode_anggota'];
                                    ?>
            
                                    <tr>
                                        <td>Nama</td>
                                        <td>: <?php echo $ambil['nama_anggota'];?></td>
                                    </tr>
                                    <tr>
                                        <td>No Telp</td>
                                        <td>: <?php echo $ambil['no_telp'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>: <?php echo $ambil['email'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>: <?php echo  $ambil['alamat'];?></td>
                                    </tr>
                                 
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row" id="bagian_trs_kembali">
                    <div class="col-sm-12">
                        <div class="card mb-4">
                            <div class="card-body">
                            <?php
                                    //Validasi untuk menampilkan pesan pemberitahuan saat user menambah penyewaan baru
                                    if (isset($_GET['edit-peminjaman'])) {
                                        if ($_GET['edit-peminjaman']=='berhasil'){
                                            echo"<div class='alert alert-success'><strong>Berhasil!</strong> koleksi berhasil diupdate</div>";
                                        } else if ($_GET['edit-peminjaman']=='gagal'){
                                            echo"<div class='alert alert-danger'><strong>Gagal!</strong> koleksi gagal diupdate</div>";
                                        }   
                                    }
                                    //Validasi untuk menampilkan pesan pemberitahuan saat user menghapus penyewaan
                                    if (isset($_GET['hapus-peminjaman'])) {
                                        if ($_GET['hapus-peminjaman']=='berhasil'){
                                            echo"<div class='alert alert-success'><strong>Berhasil!</strong> koleksi telah dihapus</div>";
                                        } else if ($_GET['hapus-peminjaman']=='gagal'){
                                            echo"<div class='alert alert-danger'><strong>Gagal!</strong> koleksi gagal dihapus</div>";
                                        }    
                                    }

                                    //Validasi untuk menampilkan pesan pemberitahuan saat user menambah penyewaan baru
                                    if (isset($_GET['konfirmasi'])) {
                                        if ($_GET['konfirmasi']=='berhasil'){
                                            echo"<div class='alert alert-success'><strong>Berhasil!</strong> Status peminjaman telah ditetapkan</div>";
                                        } else if ($_GET['konfirmasi']=='gagal'){
                                            echo"<div class='alert alert-danger'><strong>Gagal!</strong> Status peminjaman gagal ditetapkan</div>";
                                        }   
                                    }

                                    if (isset($_GET['konfirmasi'])) {
                                        if ($_GET['konfirmasi']=='tolak'){
                                            echo"<div class='alert alert-warning'><strong>Gagal!</strong> Tindakan ditolak karena telah mencapai batas maksimal peminjaman. <a href='#' kode_anggota='". $kode_anggota."' id='lihat_trs_kembali'>Lihat daftar koleksi yang sedang dipinjam</a></div>";
                                        } 
                                    }

                                ?>

                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Judul koleksi</th>
                                        <th colspan="2"  class="text-center">Waktu Peminjaman</th>
                                        <th rowspan="2">Status</th>
                                        <th rowspan="2">Jenis Denda</th>
                                        <th rowspan="2">Besaran</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                          
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        include '../config/database.php';
                                        $kode_pinjam=$_GET['kode_pinjam'];
                                        // Menampilkan detail penyewaan
                                        $sql1="select * from trs_kembali inner join trs_pinjam on trs_pinjam.kode_pinjam=trs_kembali.kode_pinjam
                                        inner join koleksi on koleksi.kode_koleksi=trs_kembali.kode_koleksi where trs_pinjam.kode_pinjam='$kode_pinjam'";
                                        $result=mysqli_query($kon,$sql1);
                                        $no=0;
                                        $status="";
                                        $jenis_denda="";
                                        $tanggal_kembali="";
                                        //Menampilkan data dengan perulangan while
                                        while ($ambil = mysqli_fetch_array($result)):
                                        $no++;

                                        if ($ambil['status']==0){
                                            $status="<span class='badge badge-dark'>Belum diambil</span>";
                                        }else if ($ambil['status']==1) {
                                            $status="<span class='badge badge-primary'>Sedang Dipinjam</span>";
                                        }else if ($ambil['status']==2){
                                            $status="<span class='badge badge-success'>Telah Selesai</span>";
                                        }
                                        else if ($ambil['status']==3){
                                            $status="<span class='badge badge-danger'>Batal</span>";
                                        }
                                        
                                        if ($ambil['jenis_denda']==0){
                                            $jenis_denda="<span class='badge badge-dark'>Tidak ada</span>";
                                        }else if ($ambil['jenis_denda']==1) {
                                            $jenis_denda="<span class='badge badge-warning'>Keterlambatan</span>";
                                        }else {
                                            $jenis_denda="<span class='badge badge-danger'>Hilang/rusak</span>";
                                        }


                                        if ($ambil['tanggal_pinjam']=='0000-00-00'){
                                            $tanggal_pinjam="";
                                        }else {
                                            $tanggal_pinjam=tanggal(date("Y-m-d",strtotime($ambil['tanggal_pinjam'])));
                                        }
                                        if ($ambil['tanggal_kembali']=='0000-00-00'){
                                            $tanggal_kembali="";
                                        }else {
                                            $tanggal_kembali=tanggal(date("Y-m-d",strtotime($ambil['tanggal_kembali'])));
                                        }
                                
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $ambil['judul_koleksi']; ?></td>
                                        <td class="text-center"><?php echo $tanggal_pinjam; ?></td>
                                        <td class="text-center"><?php echo $tanggal_kembali; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td><?php echo $jenis_denda; ?></td>
                                        <td>Rp. <?php echo number_format($ambil['denda'],0,',','.'); ?></td>
                                        <td>
                                            <button class="tombol_konfirmasi btn btn-primary btn-circle" kode_anggota="<?php echo $kode_anggota; ?>" kode_koleksi="<?php echo $ambil['kode_koleksi']; ?>"  id_kembali="<?php echo $ambil['id_kembali']; ?>"  kode_pinjam="<?php echo $_GET['kode_pinjam']; ?>"  tanggal_pinjam="<?php echo $ambil['tanggal_pinjam']; ?>" status="<?php echo $ambil['status'];?>" jenis_denda="<?php echo $ambil['jenis_denda'];?>" denda="<?php echo $ambil['denda'];?>" ><i class="fas fa-check"></i></button>
                                            <button class="tombol_edit_peminjaman btn btn-warning btn-circle" id_kembali="<?php echo $ambil['id_kembali']; ?>" kode_pinjam="<?php echo $_GET['kode_pinjam']; ?>"  kode_koleksi="<?php echo $ambil['kode_koleksi']; ?>" ><i class="fas fa-edit"></i></button>
                                            <a href="peminjaman/detail-peminjaman/hapus-peminjaman.php?kode_pinjam=<?php echo $_GET['kode_pinjam']; ?>&id_kembali=<?php echo $ambil['id_kembali'];?>" class="btn-hapus-Peminjaman btn btn-danger btn-circle" ><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                        <?php endwhile;?>
                                    </tbody>
                                </table>
                                <a href="peminjaman/detail-peminjaman/invoice.php?kode_pinjam=<?php echo $kode_pinjam; ?>" target='blank' class="btn btn-dark btn-icon-pdf"><span class="text"><i class="fas fa-print fa-sm"></i> Cetak</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
    //Membuat format tanggal
    function tanggal($tanggal)
    {
        $bulan = array (1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }
?>

<input type="hidden" name="kode_pinjam" id="kode_pinjam" value="<?php echo  $_GET['kode_pinjam'];?>"/>
<!-- Modal -->
<div class="modal fade" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Bagian header -->
      <div class="modal-header">
        <h4 class="modal-title" id="judul"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Bagian body -->
      <div class="modal-body">
        
        <div id="tampil_data">
          <!-- Data akan ditampilkan disini dengan AJAX -->                   
        </div>
            
      </div>
      <!-- Bagian footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>
  
    // edit peminjaman
    $('.tombol_edit_peminjaman').on('click',function(){
        var id_kembali = $(this).attr("id_kembali");
        var kode_pinjam = $(this).attr("kode_pinjam");
        var kode_koleksi = $(this).attr("kode_koleksi");
        var tanggal_pinjam = $(this).attr("tanggal_pinjam");
        $.ajax({
            url: 'peminjaman/detail-peminjaman/edit-peminjaman.php',
            method: 'post',
            data: {id_kembali:id_kembali,kode_pinjam:kode_pinjam,kode_koleksi:kode_koleksi,tanggal_pinjam:tanggal_pinjam},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit koleksi';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // konfirmasi
    $('.tombol_konfirmasi').on('click',function(){
        var kode_anggota = $(this).attr("kode_anggota");
        var id_kembali = $(this).attr("id_kembali");
        var kode_pinjam = $(this).attr("kode_pinjam");
        var kode_koleksi = $(this).attr("kode_koleksi");
        var tanggal_pinjam = $(this).attr("tanggal_pinjam");
        var status = $(this).attr("status");
        var jenis_denda = $(this).attr("jenis_denda");
        var denda = $(this).attr("denda");
        $.ajax({
            url: 'peminjaman/detail-peminjaman/konfirmasi.php',
            method: 'post',
            data: {kode_anggota:kode_anggota,id_kembali:id_kembali,kode_pinjam:kode_pinjam,kode_koleksi:kode_koleksi,tanggal_pinjam:tanggal_pinjam,status:status,jenis_denda:jenis_denda,denda:denda},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Konfirmasi Peminjaman';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // edit penyewa
     $('#tombol_edit_anggota').on('click',function(){
     
        var kode_pinjam = $(this).attr("kode_pinjam");
        var kode_anggota = $(this).attr("kode_anggota");
        $.ajax({
            url: 'peminjaman/detail-peminjaman/edit-anggota.php',
            method: 'post',
            data: {kode_pinjam:kode_pinjam,kode_anggota:kode_anggota},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Peminjaman koleksi';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // fungsi hapus Peminjaman
    $('.btn-hapus-Peminjaman').on('click',function(){
        konfirmasi=confirm("Yakin ingin menghapus data Peminjaman ini?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });


        // lihat peminjaman
        $('#lihat_trs_kembali').on('click',function(){
        var kode_anggota = $(this).attr("kode_anggota");
        $.ajax({
            url: 'peminjaman/detail-peminjaman/data-koleksi.php',
            method: 'post',
            data: {kode_anggota:kode_anggota},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Daftar koleksi yang Sedang Dipinjam';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });



</script>



