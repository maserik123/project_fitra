<script src="<?php echo base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        table = $('#mydata').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "lengthMenu": [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            "responsive": false,
            "dataType": 'JSON',
            "scrollX": false,
            "ajax": {
                "url": "<?php echo site_url('Dashboard/Mahasiswa_ikhwan/getAllMhsIkhwan') ?>",
                "method": "POST"
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "center"
            }]
        });
    });


    function updateAllTable() {
        table.ajax.reload();
    }

    var save_method;

    function show_modal_add() {
        save_method = 'add';
        $('.reset-btn').show();
        $('#form_mhs_ikhwan')[0].reset();
        $('#modal_mhs_ikhwan').modal('show');
        $('.modal-title').text(' Tambah Data Program Study');
    }

    function updateMhsIkhwan(id) {
        save_method = 'update';
        $('#form_mhs_ikhwan')[0].reset();
        $('.reset-btn').hide();
        $.ajax({
            url: "<?php echo site_url('Dashboard/Mahasiswa_ikhwan/getDataMhsIkhwan'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="mhs_id"]').val(data.mhs_id);
                $('[name="mhs_nama"]').val(data.mhs_nama);
                $('[name="mhs_username"]').val(data.mhs_username);
                $('[name="mhs_password"]').val(data.mhs_password);
                $('[name="prodi_id"]').val(data.prodi_id);
                $('[name="mhs_angkatan"]').val(data.mhs_angkatan);
                $('[name="i_id"]').val(data.i_id);
                $('#modal_mhs_ikhwan').modal('show');
                $('.modal-title').text(' Edit Data Program Study');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }

    function deleteMhsIkhwan(id) {
        swal({
            title: "Apakah Yakin Akan Dihapus?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Ya",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: "<?php echo site_url('Dashboard/Mahasiswa_ikhwan/deleteMhsIkhwan'); ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    updateAllTable();
                    return swal({
                        html: true,
                        timer: 1300,
                        showConfirmButton: false,
                        title: data['msg'],
                        type: data['status']
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error Deleting Data');
                }
            });
        });
    }

    function add_data() {
        var url;
        if (save_method == 'add') {
            url = '<?php echo base_url() ?>Dashboard/Mahasiswa_ikhwan/addMhsIkhwan';
        } else {
            url = '<?php echo base_url() ?>Dashboard/Mahasiswa_ikhwan/updateMhsIkhwan';
        }
        swal({
            title: "Apakah Data Sudah Benar?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Ya",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#form_mhs_ikhwan').serialize(),
                dataType: "JSON",
                success: function(resp) {
                    if (resp['status'] == 'success') {
                        updateAllTable();
                        $("#form_mhs_ikhwan")[0].reset();

                    }
                    return swal({
                        html: true,
                        timer: 1300,
                        showConfirmButton: false,
                        title: resp['msg'],
                        type: resp['status']
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding/updating data');
                }
            });
        });
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">
        <!-- Pending Requests Card Example -->
        <div class="col-xl-5 col-md-6 mb-4">
            <div class="card border-left-warning bg-info shadow h-100 py-2">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-4">
                            <div class="h5 mb-0 font-weight-bold text-white text-uppercase mb-1">Jumlah Ikhwan ke- <?php echo $ikhwan_ke[0]->i_no_ikhwan; ?></div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"><small><strong><?php echo $data_mhs_ikhwan[0]->jumlah; ?> Orang Mahasiswa</strong></small></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar Mahasiswa Ikhwan</h1>
        <p class="mb-4">Tabel ini menampilkan daftar mahasiswa muslim ikhwan sesuai dengan kelompok mentoringnya.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header1 py-3">
                <h6 class="m-0 font-weight-bold text-primary text-left">Daftar Nama Mahasiswa Ikhwan <?php echo $ikhwan_ke[0]->i_no_ikhwan; ?></h6>
                <button type="button" class="btn btn-google btn-sm text-right" data-toggle="modal" onclick="show_modal_add()"><i class="fa fa-plus"></i> Tambah Data Mahasiswa Ikhwan</button>
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
                                <th>Nama Pementor</th>
                                <th>Tools</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Modal Form -->
    <div class="modal fade" id="modal_mhs_ikhwan" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content modal-md">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title text-dark"><i class="fa fa-list"></i> Tambah Data</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="form" id="form_mhs_ikhwan">
                    <div class="modal-body">
                        <input type="hidden" value="" name="mhs_id" id="mhs_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control label-sm">
                                        Nama :
                                    </label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="mhs_nama" id="mhs_nama" placeholder="Masukkan Nama Mahasiswa">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="label label-control label-sm">
                                        Username
                                    </label>

                                    <div class="col-md-12">
                                        <input type="text" class="form-control" style="width:100%;" name="mhs_username" id="mhs_username" placeholder="Masukkan Username">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control label-sm">
                                        Password :
                                    </label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control " name="mhs_password" id="mhs_password" placeholder="Masukkan Password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control">
                                        Program Study :
                                    </label>
                                    <div class="col-md-12">
                                        <select name="prodi_id" id="prodi_id" class="form-control">
                                            <option value="">Program Study</option>
                                            <?php foreach ($prodi_nama as $row) {
                                                ?>
                                                <option value="<?php echo $row->prodi_id; ?>"> <?php echo $row->prodi_nama; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control">
                                        Tahun Angkatan :
                                    </label>
                                    <div class="col-md-12">
                                        <select name="mhs_angkatan" id="mhs_angkatan" class="form-control">
                                            <option value="">Pilih Tahun</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control">
                                        No Ikhwan :
                                    </label>
                                    <div class="col-md-12">
                                        <select name="i_id" id="i_id" class="form-control">
                                            <option value="">Ikhwan ke-</option>
                                            <?php foreach ($data_ikhwan as $row) {
                                                ?>
                                                <option value="<?php echo $row->i_id; ?>"> <?php echo $row->i_no_ikhwan; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="reset" class="btn btn-warning btn-sm reset-btn"><i class="fa fa-undo"></i> Reset</button>
                        <button type="button" class="btn btn-success btn-sm" onclick="add_data()"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->