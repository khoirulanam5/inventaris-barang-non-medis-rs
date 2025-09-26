<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class KategoriModel extends CI_Model {

    private $_table = 'tb_kategori';

    public function generateId() {
        $unik = 'K';
        $kode = $this->db->query("SELECT MAX(id_kategori) LAST_NO FROM tb_kategori WHERE id_kategori LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($id_kategori, $data) {
        $this->db->where('id_kategori', $id_kategori);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id_kategori) {
        $this->db->where('id_kategori', $id_kategori);
        return $this->db->delete($this->_table);
    }

    public function getAll() {
        return $this->db->get($this->_table);
    }
}