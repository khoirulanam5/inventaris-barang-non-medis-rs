<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangModel extends CI_Model {

    private $_table = 'tb_barang';

    public function generateId(){
        $unik = 'B';
        $kode = $this->db->query("SELECT MAX(id_barang) LAST_NO FROM tb_barang WHERE id_barang LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($id_barang, $data) {
        $this->db->where('id_barang', $id_barang);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id_barang) {
        $this->db->where('id_barang', $id_barang);
        return $this->db->delete($this->_table);
    }

    public function getAll() {
        $this->db->select('tb_barang.*, tb_kategori.*');
        $this->db->from($this->_table);
        $this->db->join('tb_kategori', 'tb_barang.id_kategori = tb_kategori.id_kategori');
        return $this->db->get();
    }

    public function getSelect() {
        return $this->db->get($this->_table);
    }
}