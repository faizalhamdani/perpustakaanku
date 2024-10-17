<?php
    //Memulai session dan koneksi database
    session_start();
    include '../../config/database.php';



        //Memulai transaksi
        mysqli_query($kon,"START TRANSACTION");

        $query = mysqli_query($kon, "SELECT max(id_pinjam) as id_pinjam_terbesar FROM trs_pinjam");
        $data = mysqli_fetch_array($query);
        $id_pinjam = $data['id_pinjam_terbesar'];
        $id_pinjam++;
        $kode_pinjam = sprintf("%05s", $id_pinjam);
        
        $kode_anggota=$_GET['kode_anggota'];
        $tanggal_pinjam=date('Y-m-d');
        $status="1";
    
        $simpan_tabel_peminjaman=mysqli_query($kon,"insert into trs_pinjam (kode_pinjam,kode_anggota,tanggal) values ('$kode_pinjam','$kode_anggota','$tanggal_pinjam')");
    


        //Simpan detail transaksi
        if(!empty($_SESSION["cart_koleksi"])):
            foreach ($_SESSION["cart_koleksi"] as $item):
                $kode_koleksi=$item['kode_koleksi'];
                $simpan_trs_kembali=mysqli_query($kon,"insert into trs_kembali (kode_pinjam,kode_koleksi,tanggal_pinjam,status) values ('$kode_pinjam','$kode_koleksi','$tanggal_pinjam','$status')");
            
                $ambil_koleksi= mysqli_query($kon, "SELECT stok FROM koleksi where kode_koleksi='$kode_koleksi'");
                $data = mysqli_fetch_array($ambil_koleksi); 
                $stok=$data['stok']-1;
    
                //Update stok koleksi
                $update_stok=mysqli_query($kon,"update koleksi set stok=$stok where kode_koleksi='$kode_koleksi'");
            
            endforeach;
        endif;

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi beberapa query diatas
        if ($simpan_tabel_peminjaman and $simpan_trs_kembali and $update_stok) {
            //and $simpan_trs_kembali and $update_stok  and $simpan_aktivitas
            //Jika semua query berhasil, lakukan commit
            mysqli_query($kon,"COMMIT");

            //Kosongkan kerangjang belanja
            unset($_SESSION["cart_koleksi"]);
            header("Location:../index.php?page=daftar-peminjaman&add=berhasil");
        }
        else {
            //Jika ada query yang gagal, lakukan rollback
            mysqli_query($kon,"ROLLBACK");

            //Kosongkan kerangjang belanja
            unset($_SESSION["cart_koleksi"]);
            header("Location:../index.php?page=daftar-peminjaman&add=gagal");
        }
    

?>
