<?php
session_start();
$koleksi= "";
if (isset($_POST['koleksi'])) {
	foreach ($_POST['koleksi'] as $value)
	{
		$koleksi .= "'$value'". ",";
	}
	$koleksi = substr($koleksi,0,-1);
}

?>


<?php
    $kode_koleksi="";
    if(!empty($_SESSION["cart_koleksi"])):
        foreach ($_SESSION["cart_koleksi"] as $item):
            $kode=$item["kode_koleksi"];
            $kode_koleksi .= "'$kode'". ",";
        endforeach;
    $kode_koleksi = substr($kode_koleksi,0,-1);
    endif;

?>

<div class="row">
<?php         
// include database
include '../../config/database.php';
// perintah sql untuk menampilkan daftar pengguna yang berelasi dengan tabel kategori pengguna
if(!empty($_SESSION["cart_koleksi"])) {
    $sql="select * from koleksi where kode_koleksi not in($kode_koleksi) and stok>=1";
}else {
    $sql="select * from koleksi where stok>=1";
}

$hasil=mysqli_query($kon,$sql);
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
                <button  type="button" data-dismiss="modal" class="btn-pilih-koleksi btn btn-dark btn-block" aksi="pilih_koleksi" id_koleksi="<?php echo $data['id_koleksi'];?>"  kode_koleksi="<?php echo $data['kode_koleksi'];?>" ><span class="text"><i class="fas fa-mouse-pointer"></i></span> Pilih </button>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
</div>

<script>
$('.btn-pilih-koleksi').on('click',function(){
    var aksi = $(this).attr("aksi");
    var kode_koleksi= $(this).attr("kode_koleksi");

    $.ajax({
        url: 'peminjaman/cart.php',
        method: 'POST',
        data:{kode_koleksi:kode_koleksi,aksi:aksi},
        success:function(data){
            $('#tampil_cart').html(data);
        }
    }); 

});
</script>