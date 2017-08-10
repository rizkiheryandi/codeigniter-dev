<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Pelanggan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $pelanggan = $this->Pelanggan_model->get_all();

        $data = array(
            'pelanggan_data' => $pelanggan
        );

        $this->template->load('template','pelanggan_list', $data);
    }

    public function read($id)
    {
        $row = $this->Pelanggan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nama_pelanggan' => $row->nama_pelanggan,
		'email' => $row->email,
		'no_telp' => $row->no_telp,
		'alamat' => $row->alamat,
	    );
            $this->template->load('template','pelanggan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pelanggan/create_action'),
	    'id' => set_value('id'),
	    'nama_pelanggan' => set_value('nama_pelanggan'),
	    'email' => set_value('email'),
	    'no_telp' => set_value('no_telp'),
	    'alamat' => set_value('alamat'),
	);
        $this->template->load('template','pelanggan_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_pelanggan' => $this->input->post('nama_pelanggan',TRUE),
		'email' => $this->input->post('email',TRUE),
		'no_telp' => $this->input->post('no_telp',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
	    );

            $this->Pelanggan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pelanggan'));
        }
    }

    public function update($id)
    {
        $row = $this->Pelanggan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pelanggan/update_action'),
		'id' => set_value('id', $row->id),
		'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
		'email' => set_value('email', $row->email),
		'no_telp' => set_value('no_telp', $row->no_telp),
		'alamat' => set_value('alamat', $row->alamat),
	    );
            $this->template->load('template','pelanggan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nama_pelanggan' => $this->input->post('nama_pelanggan',TRUE),
		'email' => $this->input->post('email',TRUE),
		'no_telp' => $this->input->post('no_telp',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
	    );

            $this->Pelanggan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pelanggan'));
        }
    }

    public function delete($id)
    {
        $row = $this->Pelanggan_model->get_by_id($id);

        if ($row) {
            $this->Pelanggan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pelanggan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('nama_pelanggan', 'nama pelanggan', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('no_telp', 'no telp', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "pelanggan.xls";
        $judul = "pelanggan";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pelanggan");
	xlsWriteLabel($tablehead, $kolomhead++, "Email");
	xlsWriteLabel($tablehead, $kolomhead++, "No Telp");
	xlsWriteLabel($tablehead, $kolomhead++, "Alamat");

	foreach ($this->Pelanggan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->email);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_telp);
	    xlsWriteLabel($tablebody, $kolombody++, $data->alamat);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pelanggan.doc");

        $data = array(
            'pelanggan_data' => $this->Pelanggan_model->get_all(),
            'start' => 0
        );

        $this->load->view('pelanggan_doc',$data);
    }

}
