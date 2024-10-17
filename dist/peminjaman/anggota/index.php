<script>
    $('title').text('Peminjaman Saya');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Peminjaman Saya</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Peminjaman</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
               

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Kode</th>
                                <th rowspan="2">koleksi</th>
                                <th colspan="2">Waktu Peminjaman</th>
                                <th rowspan="2">Status</th>
                            </tr>
                            <tr>
                                <th>Mulai</th>
                                <th>Selesai</th>
                    
                            </tr>
                        </thead>
        
                        <tbody>
                        <?php
                   
                            include '../config/database.php';
                         
                            $kode_anggota = $_SESSION["kode_pengguna"];
                           
                            if (isset($_GET['kode_pinjam']) and $_GET['kode_pinjam']!=''){

                                $kode_pinjam = $_GET['kode_pinjam'];

                                $sql="select *
                                from trs_pinjam p
                                inner join trs_kembali d on d.kode_pinjam=p.kode_pinjam
                                inner join koleksi k on k.kode_koleksi=d.kode_koleksi
                                where p.kode_anggota='$kode_anggota' and p.kode_pinjam='".$kode_pinjam."'
                                order by p.kode_pinjam desc";

                            }else {
                                $sql="select *
                                from trs_pinjam p
                                inner join trs_kembali d on d.kode_pinjam=p.kode_pinjam
                                inner join koleksi k on k.kode_koleksi=d.kode_koleksi
                                where p.kode_anggota='$kode_anggota'
                                order by p.kode_pinjam desc";
                            }

                            $hasil=mysqli_query($kon,$sql);
                            $no=0;
                            $jum=0;
                            $status="";
                            //Menampilkan data dengan perulangan while
                            while ($data = mysqli_fetch_array($hasil)):
                            $no++;
                            $jum+=1;

                            if ($data['status']==0){
                                $status="<span class='badge badge-dark'>Belum diambil</span>";
                            }else if ($data['status']==1) {
                                $status="<span class='badge badge-primary'>Sedang Dipinjam</span>";
                            }else if ($data['status']==2){
                                $status="<span class='badge badge-success'>Telah Selesai</span>";
                            }
                            else if ($data['status']==3){
                                $status="<span class='badge badge-danger'>Batal</span>";
                            }

                            if ($data['tanggal_pinjam']=='0000-00-00'){
                                $tanggal_pinjam="";
                            }else {
                                $tanggal_pinjam=tanggal(date("Y-m-d",strtotime($data['tanggal_pinjam'])));
                            }
                            if ($data['tanggal_kembali']=='0000-00-00'){
                                $tanggal_kembali="";
                            }else {
                                $tanggal_kembali=tanggal(date("Y-m-d",strtotime($data['tanggal_kembali'])));
                            }
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $data['kode_pinjam']; ?></td>
                            <td><?php echo $data['judul_koleksi']; ?></td>
                            <td><?php echo $tanggal_pinjam; ?></td>
                            <td><?php echo $tanggal_kembali; ?></td>
                            <td><?php echo $status; ?></td>
                        </tr>
                        <!-- bagian akhir (penutup) while -->
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($jum!=0):?>
                <a href="peminjaman/detail-peminjaman/invoice.php?kode_pinjam=<?php if (isset($_GET['kode_pinjam']) and $_GET['kode_pinjam']!='') echo $_GET['kode_pinjam']; ?>&kode_anggota=<?php echo $kode_anggota; ?>" target='blank' class="btn btn-dark btn-icon-pdf"><span class="text"><i class="fas fa-print fa-sm"></i> Cetak</span></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php 
    //Membuat format tanggal
    function tanggal($tanggal)
    {
        $bulan = array (1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }
?>
