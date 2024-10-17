<?php

    include '../../../config/database.php';

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id_koleksi=input($_GET["id_koleksi"]);
  
    $hapus_koleksi=mysqli_query($kon,"delete from koleksi where id_koleksi=$id_koleksi");

    //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($hapus_koleksi) {
        header("Location:../../../dist/index.php?page=koleksi&hapus=berhasil");
    }
    else {
        header("Location:../../../dist/index.php?page=koleksi&hapus=gagal");
    }

?>
