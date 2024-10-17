<?php
session_start();
     

    include '../../../config/database.php';
    //Memulai peminjaman
    mysqli_query($kon,"START TRANSACTION");

    $id_trs_kembali=$_GET["id_trs_kembali"];
    $kode_pinjam=$_GET["kode_pinjam"];

    //Mengeksekusi atau menjalankan query 
    $hapus_trs_kembali=mysqli_query($kon,"delete from trs_kembali where id_trs_kembali=$id_trs_kembali");

    $hasil=mysqli_query($kon,"select * from trs_kembali where kode_pinjam='$kode_pinjam'");

    $cek = mysqli_num_rows($hasil);

    if ($cek==0){
        $hapus_peminjaman=mysqli_query($kon,"delete from trs_pinjam where kode_pinjam='$kode_pinjam'");

        if ($hapus_trs_kembali and $hapus_peminjaman) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../../dist/index.php?page=daftar-peminjaman&hapus-peminjaman=berhasil");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../../dist/index.php?page=daftar-peminjaman&hapus-peminjaman=gagal");
        }
    } else {

        if ($hapus_trs_kembali) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../../dist/index.php?page=detail-peminjaman&kode_pinjam=$kode_pinjam&hapus-peminjaman=berhasil&#bagian_peminjaman");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../../dist/index.php?page=detail-peminjaman&id_pinjam=$id_pinjam&hapus-peminjaman=gagal&#bagian_peminjaman");
        }

    }

    
?>
<form action="peminjaman/detail-peminjaman/hapus-peminjaman.php" method="post">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                    <h5>Yakin ingin menghapus peminjaman ini?</h5>
            </div>
        </div>
    </div>
    <input type="hidden" name="id_trs_kembali" value="<?php echo $_POST["id_trs_kembali"]; ?>" />
    <input type="hidden" name="kode_pinjam" value="<?php echo $_POST["kode_pinjam"]; ?>" />
    <button type="submit" name="hapus_peminjaman" class="btn btn-primary">Hapus</button>
</form>

