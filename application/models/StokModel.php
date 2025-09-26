<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class StokModel extends CI_Model {

    private $_table = 'tb_stok';

    public function generateId(){
        $unik = 'S';
        $kode = $this->db->query("SELECT MAX(id_stok) LAST_NO FROM tb_stok WHERE id_stok LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($id_stok, $data) {
        $this->db->where('id_stok', $id_stok);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id_stok) {
        $this->db->where('id_stok', $id_stok);
        return $this->db->delete($this->_table);
    }

    public function getAll() {
        $this->db->select('tb_stok.*, tb_barang.*');
        $this->db->from('tb_stok');
        $this->db->join('tb_barang', 'tb_stok.id_barang = tb_barang.id_barang');
        return $this->db->get();
    }

    public function getJumlah($id_barang) {
        $this->db->select('jumlah');
        $this->db->from($this->_table);
        $this->db->where('id_barang', $id_barang);
        return $this->db->get();
    }

    public function update($item) {
        $this->db->set('jumlah', 'jumlah - ' . (int)$item->jml_pesan, FALSE);
        $this->db->where('id_barang', $item->id_barang);
        return $this->db->update($this->_table);
    }
}