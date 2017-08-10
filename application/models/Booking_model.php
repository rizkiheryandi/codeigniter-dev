<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Booking_model extends CI_Model
{

    public $table = 'booking';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_all_query()
    {
        $sql = "SELECT b.*, k.no_kamar,  p.nama_pelanggan FROM booking as b, kamar as k, pelanggan as p WHERE b.id_pelanggan = p.id AND b.id_kamar = k.id";
        return $this->db->query($sql)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('tgl_booking', $q);
	$this->db->or_like('id_pelanggan', $q);
	$this->db->or_like('id_kamar', $q);
	$this->db->or_like('lama', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('tgl_booking', $q);
	$this->db->or_like('id_pelanggan', $q);
	$this->db->or_like('id_kamar', $q);
	$this->db->or_like('lama', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($id_kamar, $data)
    {
        $this->db->insert($this->table, $data);
        $sql = "UPDATE kamar SET reservasi=1 WHERE id=$id_kamar";
        $this->db->query($sql);
    }

    // update data
    function update($id, $id_kamar_lama, $id_kamar_baru, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);

        $kosongKamar = "UPDATE kamar SET reservasi=0 WHERE id=$id_kamar_lama";
        $this->db->query($kosongKamar);
        $isiKamar = "UPDATE kamar SET reservasi=1 WHERE id=$id_kamar_baru";
        $this->db->query($isiKamar);
    }

    // delete data
    function delete($id, $id_kamar)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
        $sql = "UPDATE kamar SET reservasi=0 WHERE id=$id_kamar";
        $this->db->query($sql);
    }

}

