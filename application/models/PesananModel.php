<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class PesananModel extends CI_Model {

    private $_table = 'tb_pesanan';

    public function getAll() {
        $this->db->select('tb_pesanan.*, tb_user.nm_pengguna, tb_barang.nm_barang, tb_unit.nm_unit');
        $this->db->from('tb_pesanan');
        $this->db->join('tb_user', 'tb_pesanan.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_pesanan.id_barang = tb_barang.id_barang');
        $this->db->join('tb_unit', 'tb_pesanan.id_unit = tb_unit.id_unit');
        return $this->db->get();
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
}