<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PesananModel extends CI_Model {

    private $_table = 'tb_pesanan';

    public function generateId() {
        $unik = 'P';
        $kode = $this->db->query("SELECT MAX(id_pesanan) LAST_NO FROM tb_pesanan WHERE id_pesanan LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($id_pesanan, $data) {
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id_pesanan) {
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->delete($this->_table);
    }

    public function getBarang($id_pesanan) {
        $this->db->select('id_barang, jml_pesan');
        $this->db->from($this->_table);
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->get();
    }

    public function update($id_pesanan) {
        $this->db->set('status', 'dikirim');
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->update($this->_table);
    }
    
    public function clear($id_pesanan) {
        $this->db->set('status', 'selesai');
        $this->db->where('id_pesanan', $id_pesanan);
        return $this->db->update($this->_table);
    }

    public function getAll() {
        $this->db->select('tb_pesanan.*, tb_user.nm_pengguna, tb_barang.nm_barang, tb_unit.nm_unit');
        $this->db->from($this->_table);
        $this->db->join('tb_user', 'tb_pesanan.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_pesanan.id_barang = tb_barang.id_barang');
        $this->db->join('tb_unit', 'tb_pesanan.id_unit = tb_unit.id_unit');
        return $this->db->get();
    }
    public function getHistory() {
        $this->db->select('tb_pesanan.*, tb_user.nm_pengguna, tb_barang.nm_barang, tb_unit.nm_unit');
        $this->db->from($this->_table);
        $this->db->join('tb_user', 'tb_pesanan.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_pesanan.id_barang = tb_barang.id_barang');
        $this->db->join('tb_unit', 'tb_pesanan.id_unit = tb_unit.id_unit');
        $this->db->where('tb_pesanan.status', 'selesai');
        return $this->db->get();
    }
}