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
            "responsive": true,
            "dataType": 'JSON',
            "scrollX": false,
            "ajax": {
                "url": "<?php echo site_url('Dashboard/Kehadiran/getAllKehadiran') ?>",
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
        $('#form_kehadiran')[0].reset();
        $('#modal_kehadiran').modal('show');
        $('.modal-title').text(' Tambah Data Kehadiran');
    }

    function updateKehadiran(id) {
        save_method = 'update';
        $('#form_kehadiran')[0].reset();
        $('.reset-btn').hide();
        $.ajax({
            url: "<?php echo site_url('Dashboard/Kehadiran/getKehadiran'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="h_id"]').val(data.h_id);
                $('[name="mhs_id"]').val(data.mhs_id);
                $('[name="kg_id"]').val(data.kg_id);
                $('[name="i_id"]').val(data.i_id);
                $('[name="h_status"]').val(data.h_status);
                $('#modal_kehadiran').modal('show');
                $('.modal-title').text(' Edit Data kegiatan');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });
    }

    function deleteKehadiran(id) {
        swal({
            title: "Apakah Yakin Akan Dihapus?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Ya",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: "<?php echo site_url('Dashboard/Kehadiran/deleteKehadiran/'); ?>/" + id,
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
            url = '<?php echo base_url() ?>Dashboard/Kehadiran/addKehadiran';
        } else {
            url = '<?php echo base_url() ?>Dashboard/Kehadiran/updateKehadiran';
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
                data: $('#form_kehadiran').serialize(),
                dataType: "JSON",
                success: function(resp) {
                    if (resp['status'] == 'success') {
                        updateAllTable();
                        $("#form_kehadiran")[0].reset();

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

<?php foreach ($count_hadir as $data) {
    $h_status[] = $data->h_status;
    $jumlah[] = $data->jumlah;
} ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="col-md-12">
        <!-- Content Row -->
        <div class="row">
            <!-- Pending Requests Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning bg-gradient-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Total Mahasiswa</div>
                                <div class="h5 mb-0 font-weight-bold text-white"><?php print $data_mhs_ikhwan[0]->jumlah; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-8 col-md-6 mb-4">
                <div class="card border-left-info bg-gradient-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Capaian Kehadiran dari 15 Pertemuan</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-white"><?php echo number_format_bulat(($count_kehadiran[0]->jumlah / 15) * 100); ?>%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-gradient-dark" role="progressbar" style="width:<?php echo number_format_bulat(($count_kehadiran[0]->jumlah / 15) * 100); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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

    </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Kehadiran Kegiatan Mentoring</h1>
    <p class="mb-4">Tabel ini menampilkan daftar Kehadiran mentoring. Jumlah kehadiran maksimal ditentukan oleh admin SII.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header1 py-3">
            <h6 class="m-0 font-weight-bold text-primary text-left"><i class="fa fa-list"></i> Daftar Kehadiran Mentoring</h6>
            <button type="button" class="btn btn-google btn-sm text-right" data-toggle="modal" onclick="show_modal_add()"><i class="fa fa-plus"></i> Tambah Data Kehadiran</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="mydata" width="100%" cellspacing="0">
                    <thead class="bg-info">
                        <tr class="text-center text-dark">
                            <th>#</th>
                            <th> Mente</th>
                            <th> Pementor</th>
                            <th> Kegiatan</th>
                            <th>Materi/Kultum</th>
                            <th>Tanggal </th>
                            <th>Status Kehadiran</th>
                            <th>Tools</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="col-xl-12 col-md-2 mb-2">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Nilai Pencapaian</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="grafikBatang" style="height:100%;"></canvas>
                        <script>
                            var ctx = document.getElementById("grafikBatang").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($h_status); ?>,
                                    datasets: [{
                                        label: '# Jumlah Survei',
                                        data: <?php echo json_encode($jumlah); ?>,
                                        backgroundColor: [
                                            'rgba(0, 99, 132, 0.6)',
                                            'rgba(30, 99, 132, 0.6)',
                                            'rgba(60, 99, 132, 0.6)',
                                            'rgba(90, 99, 132, 0.6)',
                                            'rgba(120, 99, 132, 0.6)',
                                            'rgba(150, 99, 132, 0.6)',
                                            'rgba(180, 99, 132, 0.6)',
                                            'rgba(210, 99, 132, 0.6)',
                                            'rgba(240, 99, 132, 0.6)'

                                        ],
                                        borderColor: [
                                            'rgba(0, 99, 132, 1)',
                                            'rgba(30, 99, 132, 1)',
                                            'rgba(60, 99, 132, 1)',
                                            'rgba(90, 99, 132, 1)',
                                            'rgba(120, 99, 132, 1)',
                                            'rgba(150, 99, 132, 1)',
                                            'rgba(180, 99, 132, 1)',
                                            'rgba(210, 99, 132, 1)',
                                            'rgba(240, 99, 132, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->



<!-- Modal Form -->
<div class="modal fade" id="modal_kehadiran" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content modal-md">
            <div class="modal-header bg-warning">
                <h6 class="modal-title text-dark"><i class="fa fa-list"></i> </h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="form" id="form_kehadiran">
                <div class="modal-body">
                    <input type="hidden" value="" name="h_id" id="h_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label label-control label-sm">
                                    Nama Mahasiswa :
                                </label>
                                <div class="col-md-12">
                                    <select class="form-control" name="mhs_id" id="mhs_id">
                                        <option value="">Pilih Nama Ikhwan</option>
                                        <?php foreach ($data_mhs as $row) { ?>
                                            <option value="<?php echo $row->mhs_id; ?>"> <?php echo $row->mhs_nama; ?> </option>
                                        <?php } ?>
                                    </select>
                                    <!-- <input type="number" class="form-control" name="mhs_id"> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label label-control label-sm">
                                    Nama Kegiatan :
                                </label>
                                <div class="col-md-12">
                                    <select class="form-control" name="kg_id" id="kg_id">
                                        <option value="">Pilih Nama Kegiatan</option>
                                        <?php foreach ($data_kegiatan as $row) { ?>
                                            <option value="<?php echo $row->kg_id; ?>"><?php echo $row->kg_nama_kegiatan; ?></option>
                                        <?php } ?>
                                    </select>
                                    <!-- <select type="number" class="form-control" name="kg_id"> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label label-control label-sm">
                                    Ikhwan ke :
                                </label>
                                <div class="col-md-12">
                                    <select class="form-control" name="i_id" id="i_id">
                                        <option value="">Pilih No Ikhwan</option>
                                        <?php foreach ($data_ikhwan as $row) { ?>
                                            <option value="<?php echo $row->i_id; ?>"><?php echo $row->i_no_ikhwan; ?></option>
                                        <?php } ?>
                                    </select>
                                    <!-- <input type="number" class="form-control" name="i_id"> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label label-control label-sm">
                                    Status kehadiran :
                                </label>
                                <div class="col-md-12">
                                    <select class="form-control" name="h_status" id="h_status">
                                        <option value="">Pilih Status</option>
                                        <option value="hadir">Hadir</option>
                                        <option value="tidak">Tidak Hadir</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

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