<?php
session_start();
if (isset($_POST['edit_koleksi'])) {

    include '../../config/database.php';

    mysqli_query($kon,"START TRANSACTION");

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id_koleksi=input($_POST["id_koleksi"]);
    $kode=input($_POST["kode"]);
    $judul_koleksi=input($_POST["judul_koleksi"]);
    $kategori_koleksi=input($_POST["kategori_koleksi"]);
    $pengarang=input($_POST["pengarang"]);
    $penerbit=input($_POST["penerbit"]);
    $tahun=input($_POST["tahun"]);
    $halaman=input($_POST["halaman"]);
    $dimensi=input($_POST["dimensi"]);
    $stok=input($_POST["stok"]);
    $rak=input($_POST["rak"]);

    $gambar_saat_ini=$_POST['gambar_saat_ini'];
 
    $gambar_baru = $_FILES['gambar_baru']['name'];
    $ekstensi_diperbolehkan	= array('png','jpg');
    $x = explode('.', $gambar_baru);
    $ekstensi = strtolower(end($x));
    $ukuran	= $_FILES['gambar_baru']['size'];
    $file_tmp = $_FILES['gambar_baru']['tmp_name'];

    
    if (!empty($gambar_baru)){
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true){
            if ($ukuran < 2044070){

                //Mengupload logo baru
                move_uploaded_file($file_tmp, 'gambar/'.$gambar_baru);
                //menghapus logo lama
                unlink("gambar/".$gambar_saat_ini);

                $sql="update koleksi set
                judul_koleksi='$judul_koleksi',
                kategori_koleksi='$kategori_koleksi',
                pengarang='$pengarang',
                penerbit='$penerbit',
                tahun='$tahun',
                halaman='$halaman',
                dimensi='$dimensi',
                stok='$stok',
                rak='$rak',
                gambar_koleksi='$gambar_baru'
                where id_koleksi=$id_koleksi";
            }
        }
    }else {

        $sql="update koleksi set
        judul_koleksi='$judul_koleksi',
        kategori_koleksi='$kategori_koleksi',
        pengarang='$pengarang',
        penerbit='$penerbit',
        tahun='$tahun',
        halaman='$halaman',
        dimensi='$dimensi',
        stok='$stok',
        rak='$rak'
        where id_koleksi=$id_koleksi";
    }

    //Mengeksekusi atau menjalankan query diatas
    $edit_koleksi=mysqli_query($kon,$sql);

    //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
    if ($edit_koleksi) {
        mysqli_query($kon,"COMMIT");
        header("Location:../../dist/index.php?page=koleksi&edit=berhasil");
    }
    else {
        mysqli_query($kon,"ROLLBACK");
        header("Location:../../dist/index.php?page=koleksi&edit=gagal");

    }

}

?>
  <!-- ------------------------------------------------------------------------------------ -->
<?php

    $id_koleksi=$_POST["id_koleksi"];
    // mengambil data koleksi dengan kode paling besar
    include '../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM koleksi where id_koleksi=$id_koleksi");
    $data = mysqli_fetch_array($query); 

    $kode_koleksi=$data['kode_koleksi'];
    $judul_koleksi=$data['judul_koleksi'];
    $kategori_koleksi=$data['kategori_koleksi'];
    $pengarang=$data['pengarang'];
    $penerbit=$data['penerbit'];
    $tahun=$data['tahun'];
    $halaman=$data['halaman'];
    $dimensi=$data['dimensi'];
    $stok=$data['stok'];
    $rak=$data['rak'];
    $gambar_koleksi=$data['gambar_koleksi'];
   

?>
<form action="koleksi/edit.php" method="post" enctype="multipart/form-data">
    <!-- rows -->
    <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
                <label>Judul koleksi:</label>
                <input name="judul_koleksi" type="text" value="<?php echo $judul_koleksi; ?>" class="form-control" placeholder="Masukan judul koleksi" required>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label>Kode:</label>
                <h3><?php echo $kode_koleksi; ?></h3>
                <input name="kode" value="<?php echo $kode_koleksi; ?>" type="hidden" class="form-control">
                <input name="id_koleksi" value="<?php echo $id_koleksi; ?>" type="hidden" class="form-control">
            </div>
        </div>
    </div>
    <!-- rows -->                 
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Kategori:</label>
                <select name="kategori_koleksi" class="form-control">
                <?php
                  if ($kategori_koleksi==0) echo "<option value='0'>-</option>";
                    $sql="select * from kategori_koleksi order by id_kategori_koleksi asc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($data = mysqli_fetch_array($hasil)):
                ?>
                    <option <?php if ($kategori_koleksi==$data['id_kategori_koleksi']) echo "selected"; ?> value="<?php echo $data['id_kategori_koleksi']; ?>"><?php echo $data['nama_kategori_koleksi']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>pengarang:</label>
                <select name="pengarang" class="form-control">
                <?php
                    if ($pengarang==0) echo "<option value='0'>-</option>";
                    $sql="select * from pengarang order by id_pengarang asc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($data = mysqli_fetch_array($hasil)):
                ?>
                    <option <?php if ($pengarang==$data['id_pengarang']) echo "selected"; ?> value="<?php echo $data['id_pengarang']; ?>"><?php echo $data['nama_pengarang']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
    </div>
    <!-- rows -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Penerbit:</label>
                <select name="penerbit" class="form-control">
                <?php
                    if ($penerbit==0) echo "<option value='0'>-</option>";
                    $sql="select * from penerbit order by id_penerbit asc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($data = mysqli_fetch_array($hasil)):
                ?>
                    <option <?php if ($penerbit==$data['id_penerbit']) echo "selected"; ?>  value="<?php echo $data['id_penerbit']; ?>"><?php echo $data['nama_penerbit']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Tahun Terbit:</label>
                <input name="tahun" type="number" value="<?php echo $tahun; ?>" class="form-control" placeholder="Masukan tahun" required>
            </div>
        </div>
    </div>
    <!-- rows -->                 
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Halaman:</label>
                        <input name="halaman" type="number" value="<?php echo $halaman; ?>" class="form-control" placeholder="Masukan jumlah halaman" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Dimensi:</label>
                        <input name="dimensi" type="text" value="<?php echo $dimensi; ?>" class="form-control" placeholder="Masukan dimensi" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Stok:</label>
                        <input name="stok" type="number" value="<?php echo $stok; ?>" class="form-control" placeholder="Masukan stok" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Posisi Rak:</label>
                        <input name="rak" type="text" value="<?php echo $rak; ?>" class="form-control" placeholder="Masukan posisi rak" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rows -->                 
    <div class="row">
        <div class="col-sm-6">
        <label>Gambar saat ini:</label>
            <img src="../dist/koleksi/gambar/<?php echo $gambar_koleksi;?>" class="rounded" width="70%" alt="Cinque Terre">
            <input type="hidden" name="gambar_saat_ini" value="<?php echo $gambar_koleksi;?>" class="form-control" />
        </div>
        <div class="col-sm-6">
            <div id="msg"></div>
            <label>Gambar Baru:</label>
            <input type="file" name="gambar_baru" class="file" >
                <div class="input-group my-3">
                    <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                    <div class="input-group-append">
                            <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                    </div>
                </div>
            <img src="../src/img/img80.png" id="preview" class="img-thumbnail">
        </div>
    </div>
    <br>
    <!-- rows -->   
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
             <button type="submit" name="edit_koleksi" class="btn btn-success">Update</button>
            </div>
        </div>
    </div>

       
</form>
<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>
<script>
    $(document).on("click", "#pilih_gambar", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    });
</script>
