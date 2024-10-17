<?php
session_start();
    if (isset($_POST['tambah_pengarang'])) {
        
        //Include file koneksi, untuk koneksikan ke database
        include '../../../config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Memulai transaksi
            mysqli_query($kon,"START TRANSACTION");

            $kode_pengarang=input($_POST["kode_pengarang"]);
            $nama_pengarang=input($_POST["nama_pengarang"]);

            $sql="insert into pengarang (kode_pengarang,nama_pengarang) values
                ('$kode_pengarang','$nama_pengarang')";

            //Mengeksekusi/menjalankan query 
            $simpan_pengarang=mysqli_query($kon,$sql);

            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($simpan_pengarang) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../../dist/index.php?page=pengarang&add=berhasil");
            }
            else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../../dist/index.php?page=pengarang&add=gagal");
            }

        }
       
    }
?>


<?php
    // mengambil data barang dengan kode paling besar
    include '../../../config/database.php';
    $query = mysqli_query($kon, "SELECT max(id_pengarang) as kodeTerbesar FROM pengarang");
    $data = mysqli_fetch_array($query);
    $id_pengarang = $data['kodeTerbesar'];
    $id_pengarang++;
    $huruf = "P";
    $kodepengarang = $huruf . sprintf("%03s", $id_pengarang);
?>
<form action="koleksi/pengarang/tambah-pengarang.php" method="post">
    <div class="form-group">
        <label>Kode pengarang:</label>
        <h3><?php echo $kodepengarang; ?></h3>
        <input name="kode_pengarang" value="<?php echo $kodepengarang; ?>" type="hidden" class="form-control">
    </div>
    <div class="form-group">
        <label>Nama pengarang:</label>
        <input name="nama_pengarang" type="text" class="form-control" placeholder="Masukan nama pengarang" required>
    </div>

    <button type="submit" name="tambah_pengarang" id="btn-pengarang" class="btn btn-dark">Tambah</button>
</form>

