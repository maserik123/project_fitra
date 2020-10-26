<?php
defined('BASEPATH') or exit('No direct script access allowed');

class B_prodi_model extends CI_Model
{
    public function getDataProdi()
    {
        $query = $this->db->select("*")
            ->from('b_prodi')
            ->order_by('prodi_id', 'DESC')
            ->get();
        return $query->result();
    }

    function getProdiByID($id)
    {
        return $this->db->get_where('b_mhs_ikhwan mi', array('mi.mhs_id' => $id))->result();
    }


    function countProdi()
    {
        $this->db->select('count(*) as jumlah');
        $this->db->from('b_mhs_ikhwan mi');
        $this->db->join('b_ikhwan i', 'mi.i_id = i.i_id', 'left');
        $this->db->where('mi.i_id = i.i_id');
        $query = $this->db->get()->result();
        return $query;
    }

    function getAllDataProdi()
    {
        $this->datatables->select('kk.khd_id,
        kk.khd_nama_kegiatan,
        mi.mhs_nama,
        kk.khd_batasan_tilawah,
        kk.khd_kultum,
        kk.khd_tanggal_agenda,
        kk.i_id,
        kk.status_kehadiran');
        $this->datatables->from('b_kehadiran_kegiatan kk');
        $this->datatables->join('b_mhs_ikhwan mi', 'mi.mhs_id = kk.mhs_id', 'left');
        $this->datatables->join('b_ikhwan i', 'i.i_id = kk.i_id', 'left');
        $this->datatables->where('i.i_id = kk.i_id');
        return $this->datatables->generate();
    }

    function addProdi($data)
    {
        $this->db->insert('b_mhs_ikhwan', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('b_mhs_ikhwan');
        $this->db->where('mhs_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function updateProdi($id, $data)
    {
        $this->db->update("b_mhs_ikhwan", $data, $id);
        return $this->db->affected_rows();
    }

    function delete_by_id($id)
    {
        $this->db->where('mhs_id', $id);
        $this->db->delete('b_mhs_ikhwan');
    }
}

/* End of file ModelName.php */
