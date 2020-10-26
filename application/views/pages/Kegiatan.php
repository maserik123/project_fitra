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
                "url": "<?php echo site_url('Dashboard/Kegiatan/getAllKegiatan') ?>",
                "method": "POST"
            },
            "order": [
                [0, "asc"]
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
        $('#form_kegiatan')[0].reset();
        $('#modal_kegiatan').modal('show');
        $('.modal-title').text(' Tambah Data Kegiatan');
    }

    function updateKegiatan(id) {
        save_method = 'update';
        $('#form_kegiatan')[0].reset();
        $('.reset-btn').hide();
        $.ajax({
            url: "<?php echo site_url('Dashboard/Kegiatan/getKegiatanbyId'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="kg_id"]').val(data.kg_id);
                $('[name="kg_nama_kegiatan"]').val(data.kg_nama_kegiatan);
                $('[name="kg_batasan_tilawah"]').val(data.kg_batasan_tilawah);
                $('[name="kg_kultum"]').val(data.kg_kultum);
                $('[name="kg_tanggal"]').val(data.kg_tanggal);
                $('[name="i_id"]').val(data.i_id);
                $('#modal_kegiatan').modal('show');
                $('.modal-title').text(' Edit Data kegiatan');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }

    function deleteKegiatan(id) {
        swal({
            title: "Apakah Yakin Akan Dihapus?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Ya",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: "<?php echo site_url('Dashboard/Kegiatan/deleteKegiatan'); ?>/" + id,
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
            url = '<?php echo base_url() ?>Dashboard/Kegiatan/addKegiatan';
        } else {
            url = '<?php echo base_url() ?>Dashboard/Kegiatan/updateKegiatan';
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
                data: $('#form_kegiatan').serialize(),
                dataType: "JSON",
                success: function(resp) {
                    if (resp['status'] == 'success') {
                        updateAllTable();
                        $("#form_kegiatan")[0].reset();

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
            <div class="card border-left-warning bg-warning shadow h-100 py-2">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-4">
                            <div class="h6 mb-0 font-weight-bold text-white text-uppercase mb-1">Pertemuan Saat Ini</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"><small><strong><?php echo $count_kegiatan[0]->jumlah; ?> Pertemuan</strong></small></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-md-6 mb-4">
            <div class="card border-left-info bg-gradient-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Capaian Kegiatan dari 15 Pertemuan</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-white"><?php echo number_format_bulat(($count_kegiatan[0]->jumlah / 15) * 100); ?>%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-gradient-dark" role="progressbar" style="width:<?php echo number_format_bulat(($count_kegiatan[0]->jumlah / 15) * 100); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-desktop fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pie Chart -->
    <!-- <div class="col-xl-3 col-lg-5">
        <div class="card shadow mb-2">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
            </div>

            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar Pertemuan</h1>
        <p class="mb-4">Tabel ini menampilkan daftar pertemuan mentoring. Jumlah pertemuan maksimal ditentukan oleh admin SII.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header1 py-3">
                <h6 class="m-0 font-weight-bold text-primary text-left"><i class="fa fa-list"></i> Daftar Pertemuan Kegiatan</h6>
                <button type="button" class="btn btn-google btn-sm text-right" data-toggle="modal" onclick="show_modal_add()"><i class="fa fa-plus"></i> Tambah Data Pertemuan</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="mydata" width="100%" cellspacing="0">
                        <thead class="bg-info">
                            <tr class="text-center text-dark">
                                <th>#</th>
                                <th>Nama Kegiatan</th>
                                <th>Batasan Tilawah</th>
                                <th>Materi/Kultum</th>
                                <th>Tanggal Kegiatan</th>
                                <th>Ikhwan ke-</th>
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
    <div class="modal fade" id="modal_kegiatan" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content modal-md">
                <div class="modal-header bg-warning">
                    <h6 class="modal-title text-dark"><i class="fa fa-list"></i> </h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="form" id="form_kegiatan">
                    <div class="modal-body">
                        <input type="hidden" value="" name="kg_id" id="kg_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control label-sm">
                                        Nama Kegiatan :
                                    </label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="kg_nama_kegiatan" id="kg_nama_kegiatan" placeholder="Masukkan Nama Kegiatan" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control label-sm">
                                        Batasan Tilawah :
                                    </label>
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" style="width:100%;" name="kg_batasan_tilawah" id="kg_batasan_tilawah" placeholder="Masukkan Batas Tilawah" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control label-sm">
                                        Materi/Kultum :
                                    </label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" style="resize: none;" name="kg_kultum" id="kg_kultum" placeholder="Masukkan Materi/Kultum" required> </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label label-control label-sm">
                                        Tanggal Kegiatan :
                                    </label>
                                    <div class="col-md-12">
                                        <input type="date" class="form-control " name="kg_tanggal" id="kg_tanggal" placeholder="Masukkan Password" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" value="2" name="i_id" id="i_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">&times; Close</button>
                            <button type="reset" class="btn btn-warning btn-sm reset-btn">Reset</button>
                            <button type="button" class="btn btn-success btn-sm" onclick="add_data()"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->