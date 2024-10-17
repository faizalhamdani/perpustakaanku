<?php
session_start();
    //Koneksi database
    include '../../config/database.php';
    //Memulai peminjaman
    mysqli_query($kon,"START TRANSACTION");

    $kode_pinjam=$_GET['kode_pinjam'];

    //Menghapus data peminjaman dan detail peminjaman
    $hapus_peminjaman=mysqli_query($kon,"delete from trs_pinjam where kode_pinjam='$kode_pinjam'");
    $hapus_detail_peminjaman=mysqli_query($kon,"delete from trs_kembali where kode_pinjam='$kode_pinjam'");

    $waktu=date("Y-m-d H:i");
    $log_aktivitas="Hapus peminjaman Kode #$kode_pinjam";
    $id_pengguna= $_SESSION["id_pengguna"];


    //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($hapus_peminjaman && $hapus_detail_peminjaman) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../dist/index.php?page=daftar-peminjaman&hapus=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../dist/index.php?page=daftar-peminjaman&hapus=berhasil");

    }

?>