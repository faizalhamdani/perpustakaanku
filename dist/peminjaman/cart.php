<?php
session_start();
    if (isset($_POST['kode_koleksi'])) {
        $kode_koleksi=$_POST['kode_koleksi'];
           
        include '../../config/database.php';
        $sql= "SELECT * from koleksi p
        inner join pengarang s on s.id_pengarang=p.pengarang
        inner join penerbit t on t.id_penerbit=p.penerbit
        where p.kode_koleksi='$kode_koleksi'";
        $query = mysqli_query($kon,$sql);
        $data = mysqli_fetch_array($query);
        $judul_koleksi=$data['judul_koleksi'];
        $nama_pengarang=$data['nama_pengarang'];
        $nama_penerbit=$data['nama_penerbit'];
        $tahun=$data['tahun'];
    }else {
        $kode_koleksi="";
    }
    if (isset($_POST['aksi'])) {
        $aksi=$_POST['aksi'];
    }else {
        $aksi="";
    }


    //Memasukan data ke dalam array
    if (isset($_POST['aksi'])) {
    $itemArray = array($data['kode_koleksi']=>array('kode_koleksi'=>$kode_koleksi,'judul_koleksi'=>$judul_koleksi,'nama_pengarang'=>$nama_pengarang,'nama_penerbit'=>$nama_penerbit,'tahun'=>$tahun));
    }
    switch($aksi) {	
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
                        if($_POST["kode_koleksi"] == $k)
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
            <div class="col-sm-3">
                <div class="form-group">
                    <button type="button" name="tombol_pilih_koleksi" id="tombol_pilih_koleksi" class="btn btn-primary">Pilih Koleksi</button>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Judul koleksi</th>
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
                        <td><?php echo $item["judul_koleksi"]; ?></td>
                        <td><?php echo $item["nama_pengarang"]; ?></td>
                        <td><?php echo $item["nama_penerbit"]; ?></td>
                        <td><?php echo $item["tahun"]; ?></td>
                       
                        <td><button type="button" kode_koleksi="<?php echo $item["kode_koleksi"]; ?>"  class="hapus_koleksi btn btn-danger btn-circle"  ><i class="fas fa-trash"></i></button></td>
                    </tr>
                <?php 
                    endforeach;
                    endif;
                ?>
                </tbody>
            </table>
            <?php 
            if ($_SESSION["max_jml_koleksi"] <= $jum){
                echo "<script> document.getElementById('tombol_pilih_koleksi').disabled = true; </script>";
        
                echo"<span class='text-danger'>Telah mencapai batas maksimal peminjaman</span>";
            }
            ?>
        </div>
    </div>
</div>
<script>

    //Fungsi untuk menghapus penyewaan mobil dari cart (keranjang belanja)
    $('.hapus_koleksi').on('click',function(){
        var kode_koleksi = $(this).attr("kode_koleksi");
        var aksi ='hapus_koleksi';
        $.ajax({
            url: 'peminjaman/cart.php',
            method: 'POST',
            data:{kode_koleksi:kode_koleksi,aksi:aksi},
            success:function(data){
                $('#tampil_cart').html(data);
            }
        }); 
    });

    //Fungsi untuk menampilkan pemberitahuan caart masih kosong saat pengguna mengklik tombol selanjutnya
    $('#simpan_peminjaman').on('click',function(){
        var kode_koleksi=$(".kode_koleksi").val();

        if(kode_koleksi==null) {
            alert('Belum ada koleksi yang diilih');
            return false;
        }

    });

    // edit pembayaran
    $('#tombol_pilih_koleksi').on('click',function(){
        var id_koleksi = $(this).attr("id_koleksi");
        var kode_koleksi = $(this).attr("kode_koleksi");
        $.ajax({
            url: 'peminjaman/daftar-koleksi.php',
            method: 'post',
            data: {id_koleksi:id_koleksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Pilih Koleksi';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
</script>