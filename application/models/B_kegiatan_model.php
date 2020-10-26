<?php defined('BASEPATH') or exit('No direct script access allowed');

class B_kegiatan_model extends CI_model
{

    //====method mengambil seluruh data=========
    public function getDataKegiatan()
    {
        $query = $this->db->select("*")
            ->from('b_kegiatan')
            ->order_by('kg_id', 'DESC')
            ->get();
        return $query->result();
    }

    function getKegiatanByID($id)
    {
        return $this->db->get_where('b_kegiatan kg', array('kg.kg_id' => $id))->result();
    }


    function countKegiatan()
    {
        $this->db->select('count(*) as jumlah');
        $this->db->from('b_kegiatan kg');
        $this->db->join('b_ikhwan i', 'kg.i_id = i.i_id', 'left');
        $this->db->where('kg.i_id = i.i_id');
        $query = $this->db->get()->result();
        return $query;
    }

    function getAllDataKegiatan()
    {
        $this->datatables->select('kk.kg_id,
        kk.kg_nama_kegiatan,
        kk.kg_batasan_tilawah,
        kk.kg_kultum,
        kk.kg_tanggal,
        kk.i_id,
        i.i_no_ikhwan
        ');
        $this->datatables->from('b_kegiatan kk');
        $this->datatables->join('b_ikhwan i', 'i.i_id = kk.i_id', 'left');
        $this->datatables->where('i.i_id = kk.i_id');
        return $this->datatables->generate();
    }

    function addKegiatan($data)
    {
        $this->db->insert('b_kegiatan', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('b_kegiatan');
        $this->db->where('kg_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function updateKegiatan($id, $data)
    {
        $this->db->update("b_kegiatan", $data, $id);
        return $this->db->affected_rows();
    }

    function delete_by_id($id)
    {
        $this->db->where('kg_id', $id);
        $this->db->delete('b_kegiatan');
    }
}
