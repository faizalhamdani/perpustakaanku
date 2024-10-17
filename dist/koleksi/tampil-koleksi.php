<?php
session_start();
$kategori="";
$penulis="";
$pengarang="";

if (isset($_POST['kategori_koleksi'])) {
	foreach ($_POST['kategori_koleksi'] as $value)
	{
		$kategori .= "'$value'". ",";
	}
	$kategori = substr($kategori,0,-1);
}else {
    $kategori = "0"; 
}

if (isset($_POST['penulis'])) {
	foreach ($_POST['penulis'] as $value)
	{
		$penulis .= "'$value'". ",";
	}
	$penulis = substr($penulis,0,-1);
}

if (isset($_POST['pengarang'])) {
	foreach ($_POST['pengarang'] as $value)
	{
		$pengarang .= "'$value'". ",";
	}
	$pengarang = substr($pengarang,0,-1);

}
?>

<div class="row">
    <div class="col-sm-2">
        <div class="form-group">
        <?php 
            if ($_SESSION['level']=='Karyawan' or $_SESSION['level']=='karyawan'):
        ?>
            <button type="button" id="btn-tambah-koleksi" class="btn btn-warning"><span class="text"><i class="fas fa-book fa-sm"></i> Tambah koleksi</span></button>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">

<?php         
    // include database
    include '../../config/database.php';



    if (isset($_POST['kategori_koleksi']) and !isset($_POST['penulis']) and !isset($_POST['pengarang'])){
        $sql="select * from koleksi where kategori_koleksi in($kategori)";
    }else if (isset($_POST['kategori_koleksi']) and isset($_POST['penulis']) and !isset($_POST['pengarang'])){
        $sql="select * from koleksi where kategori_koleksi in($kategori) and penulis in($penulis)";
    }else if (isset($_POST['kategori_koleksi']) and !isset($_POST['penulis']) and isset($_POST['pengarang'])){
        $sql="select * from koleksi where kategori_koleksi in($kategori) and pengarang in($pengarang)";
    }else if (isset($_POST['kategori_koleksi']) and isset($_POST['penulis']) and isset($_POST['pengarang'])){
        $sql="select * from koleksi where kategori_koleksi in($kategori) and penulis in($penulis) and pengarang in($pengarang)";
    }else if (!isset($_POST['kategori_koleksi']) and isset($_POST['penulis']) and !isset($_POST['pengarang'])){
        $sql="select * from koleksi where penulis in($penulis)";
    }else if (!isset($_POST['kategori_koleksi']) and isset($_POST['penulis']) and isset($_POST['pengarang'])){
        $sql="select * from koleksi where penulis in($penulis) and pengarang in($pengarang)";
    }else if (!isset($_POST['kategori_koleksi']) and !isset($_POST['penulis']) and isset($_POST['pengarang'])){
        $sql="select * from koleksi where pengarang in($pengarang)";
    }else{
        $sql="select * from koleksi";
    }

    $hasil=mysqli_query($kon,$sql);
    $cek=mysqli_num_rows($hasil);

    if ($cek<=0){
        echo"<div class='col-sm-12'><div class='alert alert-warning'>Data tidak ditemukan!</div></div>";
        exit;
    }
    $no=0;
    //Menampilkan data dengan perulangan while
    while ($data = mysqli_fetch_array($hasil)):
    $no++;
?>
<div class="col-sm-2">
    <div class="card">

        <div class="card bg-basic">
            <img class="card-img-top" src="../dist/koleksi/gambar/<?php echo $data['gambar_koleksi'];?>"  alt="Card image cap">
            <div class="card-body text-center">
            <?php 
                if ($_SESSION['level']=='Karyawan' or $_SESSION['level']=='karyawan'):
            ?>
                <button  type="button" class="btn-detail-koleksi btn btn-light" id_koleksi="<?php echo $data['id_koleksi'];?>"  kode_koleksi="<?php echo $data['kode_koleksi'];?>" ><span class="text"><i class="fas fa-mouse-pointer"></i></span></button>
				<button  type="button" class="btn-edit-koleksi btn btn-light" id_koleksi="<?php echo $data['id_koleksi'];?>" kode_koleksi="<?php echo $data['kode_koleksi'];?>" ><span class="text"><i class="fas fa-edit"></i></span></button>
				<a href="koleksi/hapus.php?id_koleksi=<?php echo $data['id_koleksi']; ?>&gambar_koleksi=<?php echo $data['gambar_koleksi']; ?>" class="btn-hapus btn btn-light" ><i class="fa fa-trash"></i></a>
            <?php endif; ?>
            <?php 
                if ($_SESSION['level']=='Anggota' or $_SESSION['level']=='anggota'):
            ?>
             <button  type="button" class="btn-detail-koleksi btn btn-warning btn-block" id_koleksi="<?php echo $data['id_koleksi'];?>"  kode_koleksi="<?php echo $data['kode_koleksi'];?>" ><span class="text">Lihat</span></button>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
</div>


<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <!-- Bagian header -->
        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Bagian body -->
        <div class="modal-body">
            <div id="tampil_data">

            </div>  
        </div>
        <!-- Bagian footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>


<script>
    // Tambah koleksi
    $('#btn-tambah-koleksi').on('click',function(){
        $.ajax({
            url: 'koleksi/tambah.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah koleksi Baru';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // Melihat detail koleksi
    $('.btn-detail-koleksi').on('click',function(){
		var id_koleksi = $(this).attr("id_koleksi");
        var kode_koleksi = $(this).attr("kode_koleksi");
        $.ajax({
            url: 'koleksi/detail.php',
            method: 'post',
			data: {id_koleksi:id_koleksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Detail koleksi #'+kode_koleksi;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // Edit koleksi
    $('.btn-edit-koleksi').on('click',function(){
		var id_koleksi = $(this).attr("id_koleksi");
		var kode_koleksi = $(this).attr("kode_koleksi");
        $.ajax({
            url: 'koleksi/edit.php',
            method: 'post',
			data: {id_koleksi:id_koleksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit koleksi #'+kode_koleksi;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


       // fungsi hapus karyawan
    $('.btn-hapus').on('click',function(){
        konfirmasi=confirm("Yakin ingin menghapus koleksi ini?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>
