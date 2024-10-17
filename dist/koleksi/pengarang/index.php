<script>
    $('title').text('Data pengarang');
</script>

<main>
    <div class="container-fluid">
        <h2 class="mt-4">Data pengarang</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data pengarang</li>
        </ol>

        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user menambah pengarang
            if (isset($_GET['add'])) {
                if ($_GET['add']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data pengarang telah ditambah!</div>";
                }else if ($_GET['add']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data pengarang gagal ditambahkan!</div>";
                }    
            }

            if (isset($_GET['edit'])) {
                if ($_GET['edit']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data pengarang telah diupdate!</div>";
                }else if ($_GET['edit']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data pengarang gagal diupdate!</div>";
                }    
            }
            if (isset($_GET['hapus'])) {
                if ($_GET['hapus']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data pengarang telah dihapus!</div>";
                }else if ($_GET['hapus']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data pengarang gagal dihapus!</div>";
                }    
            }
        ?>

        <div class="card mb-4">
          <div class="card-header py-3">
            <!-- Tombol tambah pengarang -->
            <button  class="btn-tambah btn btn-dark btn-icon-split"><span class="text">Tambah</span></button>
          </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabel_pengarang" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode</th>
                          <th>Nama pengarang</th>
                          <th width="10%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                              // include database
                              include '../config/database.php';
                              // perintah sql untuk menampilkan daftar pengarang yang berelasi dengan tabel pengarang
                              $sql="select * from pengarang order by id_pengarang desc";
                              $hasil=mysqli_query($kon,$sql);
                              $no=0;
                              //Menampilkan data dengan perulangan while
                              while ($data = mysqli_fetch_array($hasil)):
                              $no++;
                          ?>
                          <tr>
                              <td><?php echo $no; ?></td>
                              <td><?php echo $data['kode_pengarang']; ?></td>
                              <td><?php echo $data['nama_pengarang']; ?></td>
                              <td>
                                  <button class="btn-edit btn btn-warning btn-circle" id_pengarang="<?php echo $data['id_pengarang']; ?>" kode_pengarang="<?php echo $data['kode_pengarang']; ?>"><i class="fas fa-edit"></i></button>
                                  <a href="koleksi/pengarang/hapus-pengarang.php?id_pengarang=<?php echo $data['id_pengarang']; ?>" class="btn-hapus btn btn-danger btn-circle" ><i class="fa fa-trash"></i></a>
                              </td>
                          </tr>
                          <!-- bagian akhir (penutup) while -->
                          <?php endwhile; ?>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function(){
        $('#tabel_pengarang').DataTable();
    });
</script>

<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div id="tampil_data">
                 <!-- Data akan di load menggunakan AJAX -->                   
            </div>  
        </div>
  
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>

<script>

    // Tambah pengarang
    $('.btn-tambah').on('click',function(){
        var level = $(this).attr("level");
        $.ajax({
            url: 'koleksi/pengarang/tambah-pengarang.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah pengarang';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi edit pengarang
    $('.btn-edit').on('click',function(){

        var id_pengarang = $(this).attr("id_pengarang");
        var kode_pengarang = $(this).attr("kode_pengarang");
        $.ajax({
            url: 'koleksi/pengarang/edit-pengarang.php',
            method: 'post',
            data: {id_pengarang:id_pengarang},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit pengarang #'+kode_pengarang;
            }
        });
            // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi hapus pengarang
    $('.btn-hapus').on('click',function(){
        konfirmasi=confirm("Yakin ingin menghapus pengarang ini?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>

