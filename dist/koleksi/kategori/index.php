<script>
    $('title').text('Data kategori_koleksi');
</script>


<main>
    <div class="container-fluid">
        <h2 class="mt-4">Data Kategori Koleksi</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Data Kategori Koleksi</li>
        </ol>

        <?php
            //Validasi untuk menampilkan pesan pemberitahuan saat user menambah kategori_koleksi
            if (isset($_GET['add'])) {
                if ($_GET['add']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Kategori Koleksi telah ditambah!</div>";
                }else if ($_GET['add']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Kategori Koleksi gagal ditambahkan!</div>";
                }    
            }

            if (isset($_GET['edit'])) {
                if ($_GET['edit']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Kategori Koleksi telah diupdate!</div>";
                }else if ($_GET['edit']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Kategori Koleksi gagal diupdate!</div>";
                }    
            }
            if (isset($_GET['hapus'])) {
                if ($_GET['hapus']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Kategori Koleksi telah dihapus!</div>";
                }else if ($_GET['hapus']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Kategori Koleksi gagal dihapus!</div>";
                }    
            }
        ?>

        <div class="card mb-4">
          <div class="card-header py-3">
            <!-- Tombol tambah kategori_koleksi -->
            <button  class="btn-tambah btn btn-dark btn-icon-split"><span class="text">Tambah</span></button>
          </div>
            <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabel_kategori" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode</th>
                          <th>Nama Kategori</th>
                          <th width="10%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                              // include database
                              include '../config/database.php';
                              // perintah sql untuk menampilkan daftar kategori_koleksi yang berelasi dengan tabel kategori kategori_koleksi
                              $sql="select * from kategori_koleksi order by kode_kategori_koleksi asc";
                              $hasil=mysqli_query($kon,$sql);
                              $no=0;
                              //Menampilkan data dengan perulangan while
                              while ($data = mysqli_fetch_array($hasil)):
                              $no++;
                          ?>
                          <tr>
                              <td><?php echo $no; ?></td>
                              <td><?php echo $data['kode_kategori_koleksi']; ?></td>
                              <td><?php echo $data['nama_kategori_koleksi']; ?></td>
                              <td>
                                  <button class="btn-edit btn btn-warning btn-circle" id_kategori_koleksi="<?php echo $data['id_kategori_koleksi']; ?>" kode_kategori_koleksi="<?php echo $data['kode_kategori_koleksi']; ?>"><i class="fas fa-edit"></i></button>
                                  <a href="koleksi/kategori/hapus-kategori.php?id_kategori_koleksi=<?php echo $data['id_kategori_koleksi']; ?>" class="btn-hapus btn btn-danger btn-circle" ><i class="fa fa-trash"></i></a>
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
        $('#tabel_kategori').DataTable();
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

    // Tambah kategori_koleksi
    $('.btn-tambah').on('click',function(){
        $.ajax({
            url: 'koleksi/kategori/tambah-kategori.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Kategori koleksi Baru';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi edit kategori_koleksi
    $('.btn-edit').on('click',function(){

        var id_kategori_koleksi = $(this).attr("id_kategori_koleksi");
        var kode_kategori_koleksi = $(this).attr("kode_kategori_koleksi");
        $.ajax({
            url: 'koleksi/kategori/edit-kategori.php',
            method: 'post',
            data: {id_kategori_koleksi:id_kategori_koleksi},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Kategori koleksi #'+kode_kategori_koleksi;
            }
        });
            // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi hapus kategori_koleksi
    $('.btn-hapus').on('click',function(){
        konfirmasi=confirm("Yakin ingin menghapus kategori koleksi ini?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>

