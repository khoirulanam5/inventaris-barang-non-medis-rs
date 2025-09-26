<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class DistribusiModel extends CI_Model {

    private $_table = 'tb_distribusi';

    public function generateId() {
        $unik = 'D';
        $kode = $this->db->query("SELECT MAX(id_distribusi) LAST_NO FROM tb_distribusi WHERE id_distribusi LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($id_distribusi, $data) {
        $this->db->where('id_distribusi', $id_distribusi);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id_distribusi) {
        $this->db->where('id_distribusi', $id_distribusi);
        return $this->db->delete($this->_table);
    }

    public function acc($id_distribusi) {
        $this->db->set('status', 'selesai');
        $this->db->where('id_distribusi', $id_distribusi);
        return $this->db->update($this->_table);
    }

    public function getAll() {
        $this->db->select('tb_distribusi.*, tb_user.nm_pengguna, tb_barang.nm_barang');
        $this->db->from('tb_distribusi');
        $this->db->join('tb_user', 'tb_distribusi.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_distribusi.id_barang = tb_barang.id_barang');
        return $this->db->get();
    }
}