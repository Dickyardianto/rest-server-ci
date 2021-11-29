<?php

class Kontak_model extends CI_Model {

    public function getKontak($id = null) {
        if($id === NULL) {
            return $this->db->get('kontak_telepon')->result_array();
        }else {
            return $this->db->get_where('kontak_telepon', ['id' => $id])->result_array();
        }
    }

    public function deleteKontak($id) {
        $this->db->delete('kontak_telepon', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function createNewKontak($data) {
        $this->db->insert('kontak_telepon', $data);
        return $this->db->affected_rows();
    }

    public function updateKontak($data, $id) {
        $this->db->update('kontak_telepon', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}