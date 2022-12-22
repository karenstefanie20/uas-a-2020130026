<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
// Code by: Ade Yudha Pratama
    class Dashboard_Model extends CI_Model {
        public function __construct() {
            parent::__construct();
        }
        public function cek_meja($nomor_meja) {
            $this->db->select('*');
            $this->db->from('meja');
            $this->db->where('nomor_meja', $nomor_meja);
            $query = $this->db->get();
            if($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
        public function home() {
            $this->db->select('*');
            $this->db->from('meja');
            $data = $this->db->get();
            if($data->num_rows() > 0) {
                return $data->result_array();
            } else {
                return false;
            }
        }
        public function list_menu() {
            $this->db->select('*');
            $this->db->from('menu');
            $data = $this->db->get();
            if($data->num_rows() > 0) {
                return $data->result_array();
            } else {
                return false;
            }
        }
    }
?>