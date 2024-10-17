<?php
session_start();
if (isset($_POST['edit_peminjaman_koleksi'])) {

    include '../../../config/database.php';

    mysqli_query($kon,"START TRANSACTION");

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id_kembali=input($_POST["id_kembali"]);
    $kode_pinjam=input($_POST["kode_pinjam"]);
    $kode_koleksi=input($_POST["kode_koleksi"]);

    


    $sql="update trs_kembali set
    kode_koleksi='$kode_koleksi'
    where id_kembali=$id_kembali";


    //Mengeksekusi atau menjalankan query diatas
    $edit_peminjaman_koleksi=mysqli_query($kon,$sql);

    $id_pengguna=$_SESSION["id_pengguna"];
    $waktu=date("Y-m-d h:i:s");
    $log_aktivitas="Edit Peminjaman koleksi #$kode_koleksi ";
    $simpan_aktivitas=mysqli_query($kon,"insert into log_aktivitas (waktu,aktivitas,id_pengguna) values ('$waktu','$log_aktivitas',$id_pengguna)");


    //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($edit_peminjaman_koleksi) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../index.php?page=detail-peminjaman&kode_pinjam=$kode_pinjam&edit-peminjaman=berhasil#bagian_trs_kembali");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../index.php?page=detail-peminjaman&kode_pinjam=$kode_pinjam&edit-peminjaman=gagal#bagian_trs_kembali");

    }

}
//----------------------------------------------------------------------------
?>



<?php
  $kode_koleksi=$_POST['kode_koleksi'];
?>
<form action="peminjaman/detail-peminjaman/edit-peminjaman.php" method="post">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <input type="hidden" class="form-control" name="id_kembali" value="<?php echo $_POST['id_kembali'];?>">   
                <input type="hidden" class="form-control" name="kode_pinjam" value="<?php echo $_POST['kode_pinjam'];?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>koleksi:</label>
                <select class="form-control" name="kode_koleksi">
                    <?php
                        include '../../../config/database.php';
                        if ($kode_koleksi=='') echo "<option value='0'>-</option>";
                        $hasil=mysqli_query($kon,"select * from koleksi order by id_koleksi asc");
                        while ($data = mysqli_fetch_array($hasil)):
                    ?>
                        <option <?php if ($kode_koleksi==$data['kode_koleksi']) echo "selected"; ?>  value="<?php echo $data['kode_koleksi']; ?>"><?php echo $data['judul_koleksi']; ?></option>
                        <?php endwhile; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <button class="btn btn-warning btn-circle" name="edit_peminjaman_koleksi" ><i class="fas fa-cart-plus"></i> Update</button>
            </div>
        </div>
    </div>
</form>