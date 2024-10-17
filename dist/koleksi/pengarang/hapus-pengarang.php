<?php

    include '../../../config/database.php';

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id_pengarang=input($_GET["id_pengarang"]);

    $hapus_pengarang=mysqli_query($kon,"delete from pengarang where id_pengarang=$id_pengarang");

    //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($hapus_pengarang) {
        header("Location:../../../dist/index.php?page=pengarang&hapus=berhasil");
    }
    else {
        header("Location:../../../dist/index.php?page=pengarang&hapus=gagal");
    }
    
?>
