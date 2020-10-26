<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('b_mhs_ikhwan_model');
        $this->load->model('b_kehadiran_model');
        $this->load->model('b_kegiatan_model');
        $this->load->model('b_prodi_model');


        // untuk pemanggilan Helper
        $this->load->helper('datetime');
        $this->load->helper('encrypt');
        $this->load->helper('format');
        $this->load->helper('upload');
        $this->load->helper('userlog');
        $this->load->helper('button');
    }

    function index()
    {
        $data = array(
            'active_dashboard'    => 'active',
            'title'               => 'Beranda Mentoring System',
            'getAllMhsIkhwan'     => $this->b_mhs_ikhwan_model->getDataMhsIkhwan(),
            'count_hadir'         => $this->b_kehadiran_model->getCountKehadiran(),
            'data_mhs_ikhwan'     => $this->b_mhs_ikhwan_model->countMhsIkhwan(),
            'count_kegiatan'      => $this->b_kegiatan_model->countKegiatan(),
            'count_kehadiran'     => $this->b_kehadiran_model->countKehadiran(),
            'countbyNama'         => $this->b_kehadiran_model->countHadirByNama(),
            'ikhwan_ke'           => $this->b_mhs_ikhwan_model->getIkhwanKe(),
        );
        $this->load->view('elements/header', $data);
        $this->load->view('pages/Home');
        $this->load->view('elements/footer');
    }

    function Home_dashboard()
    {
        $data = array(
            'active_dashboard'    => 'active',
            'title'               => 'Beranda Mentoring System',
            'getAllMhsIkhwan'     => $this->b_mhs_ikhwan_model->getDataMhsIkhwan(),
            'count_hadir'         => $this->b_kehadiran_model->getCountKehadiran(),
            'data_mhs_ikhwan'     => $this->b_mhs_ikhwan_model->countMhsIkhwan(),
            'count_kegiatan'      => $this->b_kegiatan_model->countKegiatan(),
            'count_kehadiran'     => $this->b_kehadiran_model->countKehadiran(),
            'countbyNama'         => $this->b_kehadiran_model->countHadirByNama(),
            'ikhwan_ke'           => $this->b_mhs_ikhwan_model->getIkhwanKe(),
        );
        $this->load->view('elements/header_dashboard', $data);
        $this->load->view('pages/Home_dashboard');
        $this->load->view('elements/footer');
    }


    public function Mahasiswa_ikhwan($param = '', $id = '')
    {
        if ($param == '') {
            $data                     = array(
                'active_d_mhs'        => 'active',
                'active_mhs_ikhwan'   => 'active',
                'title'               => 'Data Mahasiswa',
                'data_mhs_ikhwan'     => $this->b_mhs_ikhwan_model->countMhsIkhwan(),
                'ikhwan_ke'           => $this->b_mhs_ikhwan_model->getIkhwanKe(),
                'data_ikhwan'         => $this->b_mhs_ikhwan_model->getDataIkhwan(),
                'nama_mentor'         => $this->b_mhs_ikhwan_model->getPementor(),
                'prodi_nama'          => $this->b_prodi_model->getDataProdi()
            );
            $this->load->view('elements/header', $data);
            $this->load->view('pages/Mahasiswa_ikhwan');
            $this->load->view('elements/footer');
        } else if ($param == 'getAllMhsIkhwan') {
            $dt         = $this->b_mhs_ikhwan_model->getAllDataMhsIkhwan();
            $start      = $this->input->post('start');
            $data       = array();
            foreach ($dt['data'] as $row) {
                $id     = $row->mhs_id;
                $th1    = '<div class="text-center">' . ++$start . '</div>';
                $th2    = $row->mhs_nama;
                $th3    = $row->mhs_username;
                $th4    = $row->prodi_nama;
                $th5    = '<div class="text-center">' . $row->mhs_angkatan . '</div>';
                $th6    = $row->i_nama_pementor;
                $th7    = get_btn_group1('updateMhsIkhwan(' . $id . ')', "deleteMhsIkhwan(" . $id . ")");
                $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7));
            }
            $dt['data'] = $data;
            echo json_encode($dt);
            die;
        } else if ($param == 'addMhsIkhwan') {

            $data['mhs_username']       = $this->input->post('mhs_username');
            $data['mhs_password']       = md5($this->input->post('mhs_password'));
            $data['mhs_nama']           = $this->input->post('mhs_nama');
            $data['prodi_id']           = $this->input->post('prodi_id');
            $data['mhs_angkatan']       = $this->input->post('mhs_angkatan');
            $data['i_id']               = $this->input->post('i_id');
            $empty = check_empty_form($data, array('mhs_username', 'mhs_password', 'mhs_nama', 'mhs_prodi'));
            if ($empty) {
                $result = array('status' => 'error', 'msg' => 'Form penting tidak boleh kosong !');
            } else {
                $result = array('status' => 'success', 'msg' => 'Data Berhasil ditambahkan');
                $this->b_mhs_ikhwan_model->addMhsIkhwan($data);
            }
            echo json_encode($result);
            die;
        } else if ($param == 'getDataMhsIkhwan') {
            $data = $this->b_mhs_ikhwan_model->get_by_id($id);
            echo json_encode($data);
        } else if ($param == 'updateMhsIkhwan') {
            $id1['mhs_id'] = $this->input->post('mhs_id');
            $data['mhs_nama']           = $this->input->post('mhs_nama');
            $data['mhs_username']       = $this->input->post('mhs_username');
            $data['mhs_password']       = md5($this->input->post('mhs_password'));
            $data['prodi_id']           = $this->input->post('prodi_id');
            $data['mhs_angkatan']       = $this->input->post('mhs_angkatan');
            $data['i_id']               = $this->input->post('i_id');
            $this->b_mhs_ikhwan_model->updateMhsIkhwan($id1, $data);

            echo json_encode(array('status' => 'success', 'msg' => 'Data berhasil diperbaharui'));
            die;
        } else if ($param == 'deleteMhsIkhwan') {
            $this->b_mhs_ikhwan_model->delete_by_id($id);
            echo json_encode(array("status" => 'success', 'msg' => 'Data berhasil Dihapus!'));
        }
    }

    public function Kegiatan($param = '', $id = '')
    {
        if ($param == '') {
            $data                     = array(
                'active_abs_keh'    => 'active',
                'active_kegiatan'   => 'active',
                'title'             => 'Data Mahasiswa',
                'count_kegiatan'    => $this->b_kegiatan_model->countKegiatan(),
            );
            $this->load->view('elements/header', $data);
            $this->load->view('pages/Kegiatan');
            $this->load->view('elements/footer');
        } else if ($param == 'getAllKegiatan') {
            $dt         = $this->b_kegiatan_model->getAllDataKegiatan();
            $start      = $this->input->post('start');
            $data       = array();
            foreach ($dt['data'] as $row) {
                $id     = $row->kg_id;
                $th1    = '<div class="text-center">' . ++$start . '</div>';
                $th2    = $row->kg_nama_kegiatan;
                $th3    = '<div class="text-center">' . $row->kg_batasan_tilawah . '</div>';
                $th4    = $row->kg_kultum;
                $th5    = '<div class="text-center">' . indo_date($row->kg_tanggal) . '</div>';
                $th6    = '<div class="text-center">' . $row->i_no_ikhwan . '</div>';
                $th7    = get_btn_group1('updateKegiatan(' . $id . ')', "deleteKegiatan(" . $id . ")");
                $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7));
            }
            $dt['data'] = $data;
            echo json_encode($dt);
            die;
        } else if ($param == 'addKegiatan') {

            $data['kg_nama_kegiatan']   = $this->input->post('kg_nama_kegiatan');
            $data['kg_batasan_tilawah'] = $this->input->post('kg_batasan_tilawah');
            $data['kg_kultum']          = $this->input->post('kg_kultum');
            $data['kg_tanggal']         = $this->input->post('kg_tanggal');
            $data['i_id']               = $this->input->post('i_id');
            $empty = check_empty_form($data, array('kg_nama_kegiatan'));
            if ($empty) {
                $result = array('status' => 'error', 'msg' => 'Form penting tidak boleh kosong !');
            } else {
                $result = array('status' => 'success', 'msg' => 'Data Berhasil ditambahkan');
                $this->b_kegiatan_model->addKegiatan($data);
            }
            echo json_encode($result);
            die;
        } else if ($param == 'getKegiatanbyId') {
            $data = $this->b_kegiatan_model->get_by_id($id);
            echo json_encode($data);
        } else if ($param == 'updateKegiatan') {
            $id_data['kg_id'] = $this->input->post('kg_id');
            $data['kg_nama_kegiatan']   = $this->input->post('kg_nama_kegiatan');
            $data['kg_batasan_tilawah'] = $this->input->post('kg_batasan_tilawah');
            $data['kg_kultum']          = $this->input->post('kg_kultum');
            $data['kg_tanggal']         = $this->input->post('kg_tanggal');
            $data['i_id']               = $this->input->post('i_id');
            $this->b_kegiatan_model->updateKegiatan($id_data, $data);

            echo json_encode(array('status' => 'success', 'msg' => 'Pengguna berhasil diperbaharui'));
            die;
        } else if ($param == 'deleteKegiatan') {
            $this->b_kegiatan_model->delete_by_id($id);
            echo json_encode(array("status" => 'success', 'msg' => 'Data berhasil Dihapus!'));
        }
    }

    public function Kehadiran($param = '', $id = '')
    {
        if ($param == '') {
            $data                     = array(
                'active_abs_keh'    => 'active',
                'active_kehadiran'  => 'active',
                'title'             => 'Daftar Kehadiran Mentoring',
                'data_mhs_ikhwan'     => $this->b_mhs_ikhwan_model->countMhsIkhwan(),
                'count_kehadiran'   => $this->b_kehadiran_model->countKehadiran(),
                'data_mhs'          => $this->b_mhs_ikhwan_model->getDataMhsIkhwan(),
                'data_kegiatan'     => $this->b_kegiatan_model->getDataKegiatan(),
                'data_ikhwan'       => $this->b_mhs_ikhwan_model->getDataIkhwan(),
                'count_hadir'      => $this->b_kehadiran_model->getCountKehadiran()
            );
            $this->load->view('elements/header', $data);
            $this->load->view('pages/Kehadiran');
            $this->load->view('elements/footer');
        } else if ($param == 'getAllKehadiran') {
            $dt         = $this->b_kehadiran_model->getAllDataKehadiran();
            $start      = $this->input->post('start');
            $data       = array();
            foreach ($dt['data'] as $row) {
                $id     = $row->h_id;
                $th1    = '<div class="text-center">' . ++$start . '</div>';
                $th2    = $row->mhs_nama;
                $th3    = $row->i_nama_pementor;
                $th4    = $row->kg_nama_kegiatan;
                $th5    = $row->kg_kultum;
                $th6    = indo_date($row->kg_tanggal);
                $th7    = '<div class="text-center">' . $row->h_status . '</div>';
                $th8    = get_btn_group1('updateKehadiran(' . $id . ')', 'deleteKehadiran(' . $id . ')');
                $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7, $th8));
            }
            $dt['data'] = $data;
            echo json_encode($dt);
            die;
        } else if ($param == 'getAllKehadiran1') {
            $dt         = $this->b_kehadiran_model->getAllDataKehadiran();
            $start      = $this->input->post('start');
            $data       = array();
            foreach ($dt['data'] as $row) {
                $id     = $row->h_id;
                $th1    = '<div class="text-center">' . ++$start . '</div>';
                $th2    = $row->mhs_nama;
                $th3    = $row->i_nama_pementor;
                $th4    = $row->kg_nama_kegiatan;
                $th5    = $row->kg_kultum;
                $th6    = indo_date($row->kg_tanggal);
                $th7    = $row->h_status == 'hadir' ? '<div class="text-center"><div class="btn-success">Hadir</div></div>' : '<div class="text-center"><div class=" btn-danger">Tidak Hadir</div></div>';
                $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7));
            }
            $dt['data'] = $data;
            echo json_encode($dt);
            die;
        } else if ($param == 'addKehadiran') {
            $data['mhs_id']   = $this->input->post('mhs_id');
            $data['kg_id']    = $this->input->post('kg_id');
            $data['i_id']     = $this->input->post('i_id');
            $data['h_status'] = $this->input->post('h_status');
            $empty = check_empty_form($data, array('mhs_id'));
            if ($empty) {
                $result = array('status' => 'error', 'msg' => 'Form penting tidak boleh kosong !');
            } else {
                $result = array('status' => 'success', 'msg' => 'Data Berhasil ditambahkan');
                $this->b_kehadiran_model->addKehadiran($data);
            }
            echo json_encode($result);
            die;
        } else if ($param == 'getKehadiran') {
            $data = $this->b_kehadiran_model->get_by_id($id);
            echo json_encode($data);
        } else if ($param == 'updateKehadiran') {
            $id1['h_id'] = $this->input->post('h_id');
            $data['mhs_id']   = $this->input->post('mhs_id');
            $data['kg_id']    = $this->input->post('kg_id');
            $data['i_id']     = $this->input->post('i_id');
            $data['h_status'] = $this->input->post('h_status');
            $this->b_kehadiran_model->updateKehadiran($id1, $data);

            echo json_encode(array('status' => 'success', 'msg' => 'Data berhasil diperbaharui'));
            die;
        } else if ($param == 'deleteKehadiran') {
            $this->b_kehadiran_model->delete_by_id($id);
            echo json_encode(array("status" => 'success', 'msg' => 'Data berhasil Dihapus!'));
        }
    }

    public function Program_study($param = '', $id = '')
    {
        if ($param == '') {
            $data                     = array(
                'active_prodi'    => 'active',
                'title'           => 'Data Mahasiswa',
                'data_mhs_ikhwan' => $this->b_mhs_ikhwan_model->countMhsIkhwan(),
                'ikhwan_ke'       => $this->b_mhs_ikhwan_model->getIkhwanKe(),
                'data_ikhwan'     => $this->b_mhs_ikhwan_model->getDataIkhwan(),
                'nama_mentor'     => $this->b_mhs_ikhwan_model->getPementor(),
                'prodi_nama'      => $this->b_prodi_model->getDataProdi()
            );
            $this->load->view('elements/header', $data);
            $this->load->view('pages/Mahasiswa_ikhwan');
            $this->load->view('elements/footer');
        }
    }
}

/* End of file Controllername.php */
