 <!-- Begin Page Content -->
 <div class="container-fluid">

     <!-- Page Heading -->
     <h1 class="h3 mb-2 text-gray-800">Daftar Mahasiswa Ikhwan</h1>
     <p class="mb-4">Tabel ini menampilkan daftar mahasiswa muslim ikhwan sesuai dengan kelompok mentoringnya.</p>

     <!-- DataTales Example -->
     <div class="card shadow mb-4">
         <div class="card-header1 py-3">
             <h6 class="m-0 font-weight-bold text-primary text-left">Daftar Nama Mahasiswa Ikhwan ke- <?php echo $ikhwan_ke[0]->i_no_ikhwan; ?></h6>
             <button type="button" class="btn btn-info btn-sm text-right" data-toggle="modal" data-target="#modal_mhs_ikhwan"><i class="fa fa-plus"></i> Tambah Data Mahasiswa Ikhwan</button>
         </div>
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table table-bordered table-striped" id="mydata" width="100%" cellspacing="0">
                     <thead class="bg-warning">
                         <tr class="text-center text-dark">
                             <th>#</th>
                             <th>Nama</th>
                             <th>Username</th>
                             <th>Program Study</th>
                             <th>Tahun Angkatan</th>
                             <th>Tools</th>
                         </tr>
                     </thead>

                     <tbody>
                         <tr>
                             <td>Tiger Nixon</td>
                             <td>System Architect</td>
                             <td>Edinburgh</td>
                             <td>61</td>
                             <td>2011/04/25</td>
                             <td>$320,800</td>
                         </tr>

                     </tbody>
                 </table>
             </div>
         </div>
     </div>

 </div>
 <!-- /.container-fluid -->