<?php
session_start();
    if (isset($_POST['tambah_kategori_koleksi'])) {
        
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

            $kode_kategori_koleksi=input($_POST["kode_kategori_koleksi"]);
            $nama_kategori_koleksi=input($_POST["nama_kategori_koleksi"]);

            $sql="insert into kategori_koleksi (kode_kategori_koleksi,nama_kategori_koleksi) values
                ('$kode_kategori_koleksi','$nama_kategori_koleksi')";


            //Mengeksekusi/menjalankan query 
            $simpan_kategori_koleksi=mysqli_query($kon,$sql);

            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($simpan_kategori_koleksi) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../../dist/index.php?page=kategori&add=berhasil");
            }
            else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../../dist/index.php?page=kategori&add=gagal");
            }

        }
       
    }
?>


<?php
    // mengambil data barang dengan kode paling besar
    include '../../../config/database.php';
    $query = mysqli_query($kon, "SELECT max(id_kategori_koleksi) as kodeTerbesar FROM kategori_koleksi");
    $data = mysqli_fetch_array($query);
    $id_kategori_koleksi = $data['kodeTerbesar'];
    $id_kategori_koleksi++;
    $huruf = "K";
    $kodekategori_koleksi = $huruf . sprintf("%03s", $id_kategori_koleksi);
?>
<form action="koleksi/kategori/tambah-kategori.php" method="post">
    <div class="form-group">
        <label>Kode kategori koleksi:</label>
        <h3><?php echo $kodekategori_koleksi; ?></h3>
        <input name="kode_kategori_koleksi" value="<?php echo $kodekategori_koleksi; ?>" type="hidden" class="form-control">
    </div>
    <div class="form-group">
        <label>Nama kategori koleksi:</label>
        <input name="nama_kategori_koleksi" type="text" class="form-control" placeholder="Masukan nama kategori koleksi" required>
    </div>

    <button type="submit" name="tambah_kategori_koleksi" id="btn-kategori_koleksi" class="btn btn-dark">Tambah</button>
</form>

