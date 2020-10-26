<?php defined('BASEPATH') or exit('No direct script access allowed');

class B_kehadiran_model extends CI_model
{

    //====method mengambil seluruh data=========
    public function getDataKehadiran()
    {
        $query = $this->db->select("*")
            ->from('b_kehadiran')
            ->order_by('h_id', 'DESC')
            ->get();
        return $query->result();
    }

    function getKehadiranByID($id)
    {
        return $this->db->get_where('b_kehadiran mi', array('mi.h_id' => $id))->result();
    }


    function countKehadiran()
    {
        $this->db->select('count(*) as jumlah');
        $this->db->from('b_kehadiran h');
        $this->db->join('b_ikhwan i', 'h.i_id = i.i_id', 'left');
        $this->db->where('h.i_id = i.i_id');
        $query = $this->db->get()->result();
        return $query;
    }

    function getCountKehadiran()
    {
        $query = $this->db->query("SELECT h_status,COUNT(h_status) AS jumlah FROM b_kehadiran GROUP BY h_status");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    public function countHadirByNama()
    {
        $this->db->select('h.h_status,
        count(h.h_status) as jumlah,
        mi.mhs_nama
        ');
        $this->db->from('b_kehadiran h');
        $this->db->join('b_mhs_ikhwan mi', 'mi.mhs_id = h.mhs_id', 'left');
        $this->db->group_by('mi.mhs_nama');
        $this->db->where('h.h_status = "hadir"');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $data) {
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function getAllDataKehadiran()
    {
        $this->datatables->select('h.h_id,
        m.mhs_nama,
        k.kg_nama_kegiatan,
        k.kg_kultum,
        k.kg_tanggal,
        i.i_nama_pementor,
        h.h_status');
        $this->datatables->from('b_kehadiran h');
        $this->datatables->join('b_mhs_ikhwan m', 'm.mhs_id = h.mhs_id', 'left');
        $this->datatables->join('b_kegiatan k', 'k.kg_id = h.kg_id', 'left');
        $this->datatables->join('b_ikhwan i', 'i.i_id = h.i_id', 'left');
        $this->datatables->where('i.i_id = h.i_id');
        return $this->datatables->generate();
    }

    function addKehadiran($data)
    {
        $this->db->insert('b_kehadiran', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('b_kehadiran');
        $this->db->where('h_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function updateKehadiran($id, $data)
    {
        $this->db->update("b_kehadiran", $data, $id);
        return $this->db->affected_rows();
    }

    function delete_by_id($id)
    {
        $this->db->where('h_id', $id);
        $this->db->delete('b_kehadiran');
    }
}
