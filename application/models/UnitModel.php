<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class UnitModel extends CI_Model {

    private $_table = 'tb_unit';

    public function generateId(){
        $unik = 'UNIT';
        $kode = $this->db->query("SELECT MAX(id_unit) LAST_NO FROM tb_unit WHERE id_unit LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 4, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($id_unit, $data) {
        $this->db->where('id_unit', $id_unit);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id_unit) {
        $this->db->where('id_unit', $id_unit);
        return $this->db->delete($this->_table);
    }

    public function getAll() {
        return $this->db->get($this->_table);
    }
}