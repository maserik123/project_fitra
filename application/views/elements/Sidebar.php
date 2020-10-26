   <script type="text/javascript">
       function menu(value) {
           window.location = "<?php echo base_url() ?>Dashboard/" + value;
       }
   </script>
   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
       <!-- Sidebar - Brand -->
       <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
           <div class="sidebar-brand-icon rotate-n-15">
               <i class="fas fa-desktop"></i>
           </div>
           <div class="sidebar-brand-text mx-3">Si-Mentor <small>Log Kehadiran</small></div>

       </a>

       <!-- Divider -->
       <hr class="sidebar-divider my-0">

       <!-- Nav Item - Dashboard -->
       <li class="nav-item start <?php if (isset($active_dashboard)) {
                                        echo $active_dashboard;
                                    } ?>">
           <a class="nav-link" href="<?php echo site_url('Dashboard'); ?>">
               <i class="fas fa-fw fa-tachometer-alt"></i>
               <span>Dashboard</span></a>
       </li>

       <!-- Divider -->
       <hr class="sidebar-divider">
       <!-- Nav Item - Mahasiswa -->
       <li class="nav-item <?php if (isset($active_abs_keh)) {
                                echo $active_abs_keh;
                            } ?>">
           <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapseTwo">
               <i class="fa fa-running"></i>
               <span>Absensi & Kegiatan</span>
           </a>
           <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
               <div class="bg-gray-200 py-2 collapse-inner rounded">
                   <a class="collapse-item <?php if (isset($active_kegiatan)) {
                                                echo $active_kegiatan;
                                            } ?>" href="javascript::" onclick="menu('Kegiatan')"> <i class="fa fa-trello"></i> Daftar Kegiatan</a>
                   <a class="collapse-item <?php if (isset($active_kehadiran)) {
                                                echo $active_kehadiran;
                                            } ?>" href="javascript::" onclick="menu('Kehadiran')"><i class="fa fa-tasks"></i> Daftar Kehadiran</a>

               </div>
           </div>
       </li>
       <li class="nav-item start <?php if (isset($active_mhs_ikhwan)) {
                                        echo $active_mhs_ikhwan;
                                    } ?>">
           <a class="nav-link" href="<?php echo site_url('Dashboard/Mahasiswa_ikhwan'); ?>">
               <i class="fas fa-fw fa-users"></i>
               <span>Data Ikhwan</span></a>
       </li>
       <!-- Nav Item - Charts -->

       <li class="nav-item start <?php if (isset($active_prodi)) {
                                        echo $active_prodi;
                                    } ?>">
           <a class="nav-link" href="<?php echo site_url('Dashboard/Program_study'); ?>">
               <i class="fas fa-fw fa-book-open"></i>
               <span>Program Study</span></a>
       </li>
       <!-- Divider -->
       <hr class="sidebar-divider d-none d-md-block">
       <!-- Sidebar Toggler (Sidebar) -->
       <div class="text-center d-none d-md-inline">
           <button class="rounded-circle border-0" id="sidebarToggle"></button>
       </div>

   </ul>
   <!-- End of Sidebar -->