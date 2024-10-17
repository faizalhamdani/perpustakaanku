<?php
session_start();
    if (isset($_POST['edit_pengarang'])) {
        //Include file koneksi, untuk koneksikan ke database
        include '../../../config/database.php';

        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_pengarang=input($_POST["id_pengarang"]);
        $nama_pengarang=input($_POST["nama_pengarang"]);
        
        $sql="update pengarang set
        nama_pengarang='$nama_pengarang'
        where id_pengarang=$id_pengarang";

        //Mengeksekusi atau menjalankan query 
        $edit_pengarang=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($edit_pengarang) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../../dist/index.php?page=pengarang&edit=berhasil");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../../dist/index.php?page=pengarang&edit=gagal");
        }
        
    }

    //-------------------------------------------------------------------------------------------

    $id_pengarang=$_POST["id_pengarang"];
    include '../../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM pengarang where id_pengarang=$id_pengarang");
    $data = mysqli_fetch_array($query); 

    $kode_pengarang=$data['kode_pengarang'];
    $nama_pengarang=$data['nama_pengarang'];
 
?>
<form action="koleksi/pengarang/edit-pengarang.php" method="post">
    <div class="form-group">
        <label>Kode pengarang:</label>
        <h3><?php echo $kode_pengarang; ?></h3>
        <input name="kode_pengarang" value="<?php echo $kode_pengarang; ?>" type="hidden" class="form-control">
        <input name="id_pengarang" value="<?php echo $id_pengarang; ?>" type="hidden" class="form-control">
    </div>
    <div class="form-group">
        <label>Nama pengarang:</label>
        <input name="nama_pengarang" value="<?php echo $nama_pengarang; ?>" type="text" class="form-control" placeholder="Masukan nama" required>
    </div>

    <button type="submit" name="edit_pengarang" id="btn-pengarang" class="btn btn-dark" >Update pengarang</button>
</form>