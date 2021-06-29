<?php
class Barang_model extends CI_Model
{
    public function getBarang($id = null)
    {
        if ($id === null) {
            return $this->db->get('barang')->result_array();
        } else {
            return $this->db->get_where('barang', ['kode' => $id])->result_array();
        }
    }

    public function deleteBarang($id)
    {
        $this->db->delete('barang', ['kode' => $id]);
        return $this->db->affected_rows();
    }

    public function createBarang($data)
    {
        $this->db->insert('barang', $data);
        return $this->db->affected_rows();
    }

    public function updateBarang($data, $id)
    {
        $this->db->update('barang', $data, ['kode' => $id]);
        return $this->db->affected_rows();
    }
}
