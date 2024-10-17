<?php
session_start();
?>
<div class="card mb-4">
    <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>pengarang</th>
                            <th>Penerbit</th>
                            <th>Jumlah Stok</th>
                            <th>Posisi Rak</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // include database
                        include '../../../config/database.php';
                        $kondisi="";
                        $kata_kunci=$_POST['kata_kunci'];
                        $sql="select *
                        from koleksi p
                        inner join penerbit t on t.id_penerbit=p.penerbit
                        inner join kategori_koleksi k on k.id_kategori_koleksi=p.kategori_koleksi
                        inner join pengarang s on s.id_pengarang=p.pengarang
                        where p.kode_koleksi like'%".$kata_kunci."%' or p.judul_koleksi like'%".$kata_kunci."%' or nama_kategori_koleksi like'%".$kata_kunci."%' or nama_pengarang like'%".$kata_kunci."%' or nama_penerbit like'%".$kata_kunci."%'
                        ";
                        
                        $hasil=mysqli_query($kon,$sql);
                        $no=0;
                        $status='';
                        $tanggal_kembali="-";
                        //Menampilkan data dengan perulangan while
                        while ($data = mysqli_fetch_array($hasil)):
                        $no++;
    
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data['kode_koleksi']; ?> </td>
                        <td><?php echo $data['judul_koleksi']; ?> </td>
                        <td><?php echo $data['nama_kategori_koleksi']; ?> </td>
                        <td><?php echo $data['nama_pengarang']; ?> </td>
                        <td><?php echo $data['nama_penerbit']; ?> </td>
                        <td><?php echo $data['stok']; ?> </td>
                        <td><?php echo $data['rak']; ?> </td>
                    </tr>
                    <!-- bagian akhir (penutup) while -->
                    <?php endwhile; ?>
                    </tbody>
                </table>
            <a href="laporan/koleksi/cetak-pdf.php?kata_kunci=<?php if (!empty($_POST["kata_kunci"])) echo $_POST["kata_kunci"]; ?>" target='blank' class="btn btn-danger btn-icon-pdf"><span class="text"><i class="fas fa-file-pdf fa-sm"></i> Export PDF</span></a>
	        </div>
    </div>
</div>