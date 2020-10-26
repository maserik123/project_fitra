<?php defined('BASEPATH') or exit('No direct script access allowed');

class B_mhs_ikhwan_model extends CI_model
{

    //====method mengambil seluruh data=========
    public function getDataMhsIkhwan()
    {
        $query = $this->db->select("*")
            ->from('b_mhs_ikhwan ')
            ->order_by('mhs_id', 'DESC')
            ->get();
        return $query->result();
    }
    public function getDataIkhwan()
    {
        $query = $this->db->select("*")
            ->from('b_ikhwan')
            ->order_by('i_id', 'DESC')
            ->get();
        return $query->result();
    }

    public function getPementor()
    {
        $query = $this->db->select("*")
            ->from('b_ikhwan')
            ->order_by('i_id', 'DESC')
            ->get();
        return $query->result();
    }

    function getMhsIkhwanByID($id)
    {
        return $this->db->get_where('b_mhs_ikhwan mi', array('mi.mhs_id' => $id))->result();
    }

    function getIkhwanKe()
    {
        $this->db->select('mi.i_id,
        i.i_no_ikhwan,
        i.i_nama_pementor');
        $this->db->from('b_mhs_ikhwan mi');
        $this->db->join('b_ikhwan i', 'mi.i_id = i.i_id', 'left');
        $query = $this->db->get()->result();
        return $query;
    }

    function countMhsIkhwan()
    {
        $this->db->select('count(*) as jumlah');
        $this->db->from('b_mhs_ikhwan mi');
        $this->db->join('b_ikhwan i', 'mi.i_id = i.i_id', 'left');
        $this->db->where('mi.i_id = i.i_id');
        $query = $this->db->get()->result();
        return $query;
    }

    function getAllDataMhsIkhwan()
    {
        $this->datatables->select('mi.mhs_id,
        mi.mhs_username,
        mi.mhs_nama,
        mi.mhs_angkatan,
        pro.prodi_nama,
        i.i_no_ikhwan,
       i.i_nama_pementor');
        $this->datatables->from('b_mhs_ikhwan mi');
        $this->datatables->join('b_ikhwan i', 'mi.i_id = i.i_id', 'left');
        $this->datatables->join('b_prodi pro', 'mi.prodi_id = pro.prodi_id', 'left');
        $this->datatables->where('i.i_id = mi.i_id');
        return $this->datatables->generate();
    }

    function addMhsIkhwan($data)
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

    function updateMhsIkhwan($id, $data)
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
