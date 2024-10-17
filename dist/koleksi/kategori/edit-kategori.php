<?php
session_start();
    if (isset($_POST['edit_kategori_koleksi'])) {
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
        $id_kategori_koleksi=input($_POST["id_kategori_koleksi"]);
        $nama_kategori_koleksi=input($_POST["nama_kategori_koleksi"]);
        
        $sql="update kategori_koleksi set
        nama_kategori_koleksi='$nama_kategori_koleksi'
        where id_kategori_koleksi=$id_kategori_koleksi";

        //Mengeksekusi atau menjalankan query 
        $edit_kategori_koleksi=mysqli_query($kon,$sql);
        
        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($edit_kategori_koleksi) {
            mysqli_query($kon,"COMMIT");
            header("Location:../../../dist/index.php?page=kategori&edit=berhasil");
        }
        else {
            mysqli_query($kon,"ROLLBACK");
            header("Location:../../../dist/index.php?page=kategori&edit=gagal");
        }
        
    }

    //-------------------------------------------------------------------------------------------

    $id_kategori_koleksi=$_POST["id_kategori_koleksi"];
    include '../../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM kategori_koleksi where id_kategori_koleksi=$id_kategori_koleksi");
    $data = mysqli_fetch_array($query); 

    $kode_kategori_koleksi=$data['kode_kategori_koleksi'];
    $nama_kategori_koleksi=$data['nama_kategori_koleksi'];
 
?>
<form action="koleksi/kategori/edit-kategori.php" method="post">
    <div class="form-group">
        <label>Kode kategori koleksi:</label>
        <h3><?php echo $kode_kategori_koleksi; ?></h3>
        <input name="kode_kategori_koleksi" value="<?php echo $kode_kategori_koleksi; ?>" type="hidden" class="form-control">
        <input name="id_kategori_koleksi" value="<?php echo $id_kategori_koleksi; ?>" type="hidden" class="form-control">
    </div>
    <div class="form-group">
        <label>Nama kategori koleksi:</label>
        <input name="nama_kategori_koleksi" value="<?php echo $nama_kategori_koleksi; ?>" type="text" class="form-control" placeholder="Masukan nama kategori" required>
    </div>

    <button type="submit" name="edit_kategori_koleksi" id="btn-kategori_koleksi" class="btn btn-dark" >Update</button>
</form>