<?php
    session_start();
    include '../../config/database.php';

    //Memulai transaksi
    mysqli_query($kon,"START TRANSACTION");

    $query = mysqli_query($kon, "SELECT max(id_pinjam) as id_pinjam_terbesar FROM trs_pinjam");
    $data = mysqli_fetch_array($query);
    $id_pinjam = $data['id_pinjam_terbesar'];
    $id_pinjam++;
    $kode_pinjam = sprintf("%05s", $id_pinjam);
    $tanggal=date('Y-m-d');
    $kode_anggota=$_SESSION['kode_pengguna'];

    $simpan_tabel_peminjaman=mysqli_query($kon,"insert into trs_pinjam (kode_pinjam,kode_anggota,tanggal) values ('$kode_pinjam','$kode_anggota','$tanggal')");

    //Simpan detail transaksi
    if(!empty($_SESSION["cart_koleksi"])):
        foreach ($_SESSION["cart_koleksi"] as $item):
            $kode_koleksi=$item['kode_koleksi'];
            $simpan_tabel_detail=mysqli_query($kon,"insert into trs_kembali(kode_pinjam,kode_koleksi) values ('$kode_pinjam','$kode_koleksi')");
        endforeach;
    endif;

    if ($simpan_tabel_peminjaman and $simpan_tabel_detail) {
        //Jika semua query berhasil, lakukan commit
        mysqli_query($kon,"COMMIT");

        //Kosongkan kerangjang belanja
        unset($_SESSION["cart_koleksi"]);
        header("Location:../index.php?page=booking&kode_pinjam=$kode_pinjam");
    }
    else {
        //Jika ada query yang gagal, lakukan rollback
        mysqli_query($kon,"ROLLBACK");

        //Kosongkan kerangjang koleksi
        unset($_SESSION["cart_koleksi"]);
        header("Location:../index.php?page=booking&add=gagal");
    }
?>