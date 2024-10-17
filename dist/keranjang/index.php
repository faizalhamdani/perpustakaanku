<script>
    $('title').text('Keranjang koleksi');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Keranjang koleksi</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Keranjang koleksi</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php

                            include '../config/database.php';
                            $kode_anggota=$_SESSION['kode_pengguna'];
                            $query1 = mysqli_query($kon, " SELECT * FROM anggota where kode_anggota='$kode_anggota'");
                            $data1 = mysqli_fetch_array($query1);    
                            
                            $query3 = mysqli_query($kon, "SELECT * FROM trs_kembali d inner join trs_pinjam p on d.kode_pinjam=p.kode_pinjam where p.kode_anggota='$kode_anggota' and d.status='1'");
                            $jumlah_pinjam = mysqli_num_rows($query3);

                            $query4=mysqli_query($kon,"select max_jml_koleksi from kebijakan limit 1");
                            $data4 = mysqli_fetch_array($query4); 
                            $max_jml_koleksi=$data4['max_jml_koleksi']-$jumlah_pinjam;

                            if ($max_jml_koleksi < 0){
                                $max_jml_koleksi=0;
                            }

                            $_SESSION["max_jml_koleksi"]=$max_jml_koleksi;

                        ?>

                        <?php if ($max_jml_koleksi!=0){?>
                            <div class="alert alert-info">
                            Hallo <?php echo $data1['nama_anggota'];?> saat ini kamu dapat melakukan peminjaman maksimal sebanyak <?php echo $max_jml_koleksi; ?> koleksi.
                            </div>
                        <?php }else{ ?>
                            <div class="alert alert-warning">
                                Hallo <?php echo $data1['nama_anggota'];?> saat ini kamu telah mencapai batas maksimal peminjaman. Kembalikan terlebih dahulu koleksi yang sedang dipinjam agar dapat melakukan peminjaman berikutnya.
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <a href="index.php?page=koleksi"  id="tombol_pilih_koleksi" class="btn btn-dark"> Pilih koleksi</a>
                        </div>
                    </div>
                </div>
                <?php
                    if (isset($_GET['kode_koleksi'])) {

                        $kode_koleksi=$_GET['kode_koleksi'];
                        
                        include '../config/database.php';
                        $sql= "SELECT * from koleksi p
                        inner join pengarang s on s.id_pengarang=p.pengarang
                        inner join penerbit t on t.id_penerbit=p.penerbit
                        inner join kategori_koleksi k on k.id_kategori_koleksi=p.kategori_koleksi
                        where p.kode_koleksi='$kode_koleksi'";

                        $query = mysqli_query($kon,$sql);
                        $data = mysqli_fetch_array($query);

                        $judul_koleksi=$data['judul_koleksi'];
                        $nama_kategori_koleksi=$data['nama_kategori_koleksi'];
                        $nama_pengarang=$data['nama_pengarang'];
                        $nama_penerbit=$data['nama_penerbit'];
                        $tahun=$data['tahun'];

                    }else {
                        $kode_koleksi="";
                    }

                    if (isset($_GET['aksi'])) {
                        $aksi=$_GET['aksi'];
                    }else {
                        $aksi="";
                    }


                    //Memasukan data ke dalam array
                    if (isset($_GET['aksi'])) {
                    $itemArray = array($data['kode_koleksi']=>array('kode_koleksi'=>$kode_koleksi,'judul_koleksi'=>$judul_koleksi,'nama_kategori_koleksi'=>$nama_kategori_koleksi,'nama_pengarang'=>$nama_pengarang,'nama_penerbit'=>$nama_penerbit,'tahun'=>$tahun));
                    }
                    switch($aksi){	
                        //Fungsi untuk menambah penyewaan kedalam cart
                        case "pilih_koleksi":
                        if(!empty($_SESSION["cart_koleksi"])) {
                            if(in_array($data['kode_koleksi'],array_keys($_SESSION["cart_koleksi"]))) {
                                foreach($_SESSION["cart_koleksi"] as $k => $v) {
                                        if($data['kode_koleksi'] == $k) {
                                            $_SESSION["cart_koleksi"] = array_merge($_SESSION["cart_koleksi"],$itemArray);
                                        }
                                }
                            } else {
                                $_SESSION["cart_koleksi"] = array_merge($_SESSION["cart_koleksi"],$itemArray);
                            }
                        } else {
                            $_SESSION["cart_koleksi"] = $itemArray;
                        }
                        break;
                        //Fungsi untuk menghapus penyewaan dari cart
                        case "hapus_koleksi":
                            if(!empty($_SESSION["cart_koleksi"])) {
                                foreach($_SESSION["cart_koleksi"] as $k => $v) {
                                        if($_GET["kode_koleksi"] == $k)
                                            unset($_SESSION["cart_koleksi"][$k]);
                                        if(empty($_SESSION["cart_koleksi"]))
                                            unset($_SESSION["cart_koleksi"]);
                                }
                            }
                        break;
                    }
                ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Judul koleksi</th>
                                    <th>Kategori</th>
                                    <th>pengarang</th>
                                    <th>Perbit</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $no=0;
                                    $jum=0;
                        
                                    if(!empty($_SESSION["cart_koleksi"])):
                                    foreach ($_SESSION["cart_koleksi"] as $item):
                                        $no++;
                                        $jum+=1;
                                ?>
                                    <input type="hidden" name="kode_koleksi[]" class="kode_koleksi" value="<?php echo $item["kode_koleksi"]; ?>"/>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $item["kode_koleksi"]; ?></td>
                                        <td><?php echo $item["judul_koleksi"]; ?></td>
                                        <td><?php echo $item["nama_kategori_koleksi"]; ?></td>
                                        <td><?php echo $item["nama_pengarang"]; ?></td>
                                        <td><?php echo $item["nama_penerbit"]; ?></td>
                                        <td><?php echo $item["tahun"]; ?></td>
                                        <td><a href="index.php?page=keranjang&kode_koleksi=<?php echo $item['kode_koleksi']; ?>&aksi=hapus_koleksi" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                <?php 
                                    endforeach;
                                    endif;
                                ?>
                                </tbody>
                            </table>
                            <div id="pesan"> </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <?php if(!empty($_SESSION["cart_koleksi"])): ?>
                            <a href="keranjang/submit.php" id="ajukan" class="btn btn-success"> Ajukan Sekarang</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
    if ($jum<$_SESSION["max_jml_koleksi"]){
        echo "<script>  $('#tombol_pilih_koleksi').show(); </script>";
        echo "<script>  $('#ajukan').show(); </script>";
    } else if ($jum==$_SESSION["max_jml_koleksi"]){
    ?>
        <script>  
            $('#tombol_pilih_koleksi').hide(); 
            $('#ajukan').show();
            $('#pesan').html("<span class='text-danger'>Telah mencapai batas maksimal peminjaman</span>"); 
        </script>
    <?php 
    }else {
    ?>
        <script>  
            $('#tombol_pilih_koleksi').hide(); 
            $('#ajukan').hide();
            $('#pesan').html("<span class='text-warning'>Tidak boleh melebihi batas peminjaman. Kurangi salah satu koleksi dalam keranjang</span>"); 
        </script>
    <?php
    }
?>

<script>
   // konfirmasi pengajuan
   $('#ajukan').on('click',function(){
        konfirmasi=confirm("Apakah anda yakin ingin mengajukan peminjaman koleksi ini?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>



