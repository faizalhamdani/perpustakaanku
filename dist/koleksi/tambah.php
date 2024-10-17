<?php
session_start();
    if (isset($_POST['tambah_anggota'])) {
        //Include file koneksi, untuk koneksikan ke database
        include '../../config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            mysqli_query($kon,"START TRANSACTION");

            $kode=input($_POST["kode"]);
            $judul_koleksi=$_POST["judul_koleksi"];
            $kategori_koleksi=input($_POST["kategori_koleksi"]);
            $pengarang=input($_POST["pengarang"]);
            $pengarang=input($_POST["pengarang"]);
            $tahun=input($_POST["tahun"]);
            $halaman=input($_POST["halaman"]);
            $dimensi=input($_POST["dimensi"]);
            $stok=input($_POST["stok"]);
            $rak=input($_POST["rak"]);

            $tanggal=date("Y-m-d");

            $ekstensi_diperbolehkan	= array('png','jpg');
            $gambar_koleksi = $_FILES['gambar_koleksi']['name'];
            $x = explode('.', $gambar_koleksi);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['gambar_koleksi']['size'];
            $file_tmp = $_FILES['gambar_koleksi']['tmp_name'];	

            if (!empty($gambar_koleksi)){
                if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                    if($ukuran < 1044070){	
                        //Mengupload gambar
                        move_uploaded_file($file_tmp, 'gambar/'.$gambar_koleksi);
                        $sql="insert into koleksi (kode_koleksi,judul_koleksi,kategori_koleksi,pengarang,penerbit,tahun,gambar_koleksi,halaman,dimensi,stok,rak) values
                        ('$kode','$judul_koleksi','$kategori_koleksi','$pengarang','$penerbit','$tahun','$gambar_koleksi','$halaman','$dimensi','$stok','$rak')";
                    }
                }
            }else {
                $gambar_koleksi="gambar_default.png";
                $sql="insert into koleksi (kode_koleksi,judul_koleksi,kategori_koleksi,pengarang,penerbit,tahun,gambar_koleksi,halaman,dimensi,stok,rak) values
                ('$kode','$judul_koleksi','$kategori_koleksi','$pengarang','$penerbit','$tahun','$gambar_koleksi','$halaman','$dimensi','$stok','$rak')";
            }


            $simpan_koleksi=mysqli_query($kon,$sql);

            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($simpan_koleksi) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../dist/index.php?page=koleksi&add=berhasil");
            }
            else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../dist/index.php?page=koleksi&add=gagal");
            }
        }
    }
      // mengambil data koleksi dengan kode paling besar
      include '../../config/database.php';
      $query = mysqli_query($kon, "SELECT max(id_koleksi) as kodeTerbesar FROM koleksi");
      $data = mysqli_fetch_array($query);
      $id_koleksi = $data['kodeTerbesar'];
      $id_koleksi++;
      $huruf = "K";
      $kodekoleksi = $huruf . sprintf("%04s", $id_koleksi);

?>
<form action="koleksi/tambah.php" method="post" enctype="multipart/form-data">
    <!-- rows -->
    <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
                <label>Judul koleksi:</label>
                <input name="judul_koleksi" type="text" class="form-control" placeholder="Masukan judul koleksi" required>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label>Kode:</label>
                <h3><?php echo $kodekoleksi; ?></h3>
                <input name="kode" value="<?php echo $kodekoleksi; ?>" type="hidden" class="form-control">
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
                    $sql="select * from kategori_koleksi order by id_kategori_koleksi asc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($data = mysqli_fetch_array($hasil)):
                ?>
                    <option value="<?php echo $data['id_kategori_koleksi']; ?>"><?php echo $data['nama_kategori_koleksi']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
            <label>Kategori:</label>
                <select name="kategori_koleksi" class="form-control">
                <?php
                    $sql="select * from kategori_koleksi order by id_kategori_koleksi asc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($data = mysqli_fetch_array($hasil)):
                ?>
                    <option value="<?php echo $data['id_kategori_koleksi']; ?>"><?php echo $data['nama_kategori_koleksi']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
    </div>
    <!-- rows -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>pengarang:</label>
                <select name="pengarang" class="form-control">
                <?php
                    $sql="select * from pengarang order by id_pengarang asc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($data = mysqli_fetch_array($hasil)):
                ?>
                    <option value="<?php echo $data['id_pengarang']; ?>"><?php echo $data['nama_pengarang']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Tahun Terbit:</label>
                <input name="tahun" type="number" class="form-control" placeholder="Masukan tahun" required>
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
                        <input name="halaman" type="number" class="form-control" placeholder="Masukan jumlah halaman" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Dimensi:</label>
                        <input name="dimensi" type="text" class="form-control" placeholder="Masukan dimensi" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Stok:</label>
                        <input name="stok" type="number" class="form-control" placeholder="Masukan stok" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Posisi Rak:</label>
                        <input name="rak" type="text" class="form-control" placeholder="Masukan posisi rak" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rows -->   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div id="msg"></div>
                <label>Gambar koleksi:</label>
                <input type="file" name="gambar_koleksi" class="file" >
                    <div class="input-group my-3">
                        <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                        <div class="input-group-append">
                            <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                        </div>
                    </div>
                <img src="../src/img/img80.png" id="preview" class="img-thumbnail">
            </div>
        </div>
    </div>

    <!-- rows -->   
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
             <button type="submit" name="tambah_anggota" class="btn btn-success">Tambah</button>
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
