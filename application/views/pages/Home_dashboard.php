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
                "url": "<?php echo site_url('Dashboard/Kehadiran/getAllKehadiran1') ?>",
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

<?php foreach ($countbyNama as $data1) {
    $mhs_nama[] = $data1->mhs_nama;
    $jumlah1[] = $data1->jumlah;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center right-content-between mb-4">
        <label class="d-none d-sm-inline-block btn btn-sm btn-facebook shadow-sm"> Dashboard Absensi Kegiatan Mentoring Ikhwan Ke- 27</label>
    </div>
    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info bg-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Capaian kegiatan dari 15 Pertemuan</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" aria-valuemin="0"><?php echo number_format_bulat(($count_kegiatan[0]->jumlah) / 15 * 100); ?>%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo number_format_bulat(($count_kegiatan[0]->jumlah) / 15 * 100); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info bg-gradient-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Capaian Kehadiran dari 15 Pertemuan</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-white"><?php echo number_format_bulat(($count_kehadiran[0]->jumlah) / 15 * 100); ?>%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo number_format_bulat(($count_kehadiran[0]->jumlah) / 15 * 100); ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning bg-gradient-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Jumlah Mahasiswa</div>
                            <div class="h5 mb-0 font-weight-bold text-white"><?php echo $data_mhs_ikhwan[0]->jumlah; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">
        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Kehadiran Ikhwan ke- <?php echo $ikhwan_ke[0]->i_no_ikhwan; ?> </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="height:420px;">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="BarKehadiran"></canvas>
                        <script>
                            var ctx = document.getElementById("BarKehadiran").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($h_status); ?>,
                                    datasets: [{
                                        label: 'Total',
                                        data: <?php echo json_encode($jumlah); ?>,
                                        backgroundColor: [
                                            'rgba(99, 132, 0, 0.6)',
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
        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Rasio Kehadiran Mahasiswa</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="height:420px;">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="BarKegiatan" style="height:200%;"></canvas>
                        <script>
                            var ctx = document.getElementById("BarKegiatan").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($mhs_nama); ?>,
                                    datasets: [{
                                        label: 'Jumlah Hadir',
                                        data: <?php echo json_encode($jumlah1); ?>,
                                        backgroundColor: [
                                            'rgba(99, 132, 0, 0.6)',
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

    <!-- Content Row -->
    <div class="row">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header1 py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-left"><i class="fa fa-list"></i> Daftar Kehadiran Mentoring</h6>
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
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>


        </div>
        <!-- /.container-fluid -->


    </div>
</div>
<!-- /.container-fluid -->
<script type="text/javascript">

</script>