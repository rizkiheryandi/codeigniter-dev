<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kamar extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Kamar_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $kamar = $this->Kamar_model->get_all();

        $data = array(
            'kamar_data' => $kamar
        );

        $this->template->load('template','kamar_list', $data);
    }

    public function read($id)
    {
        $row = $this->Kamar_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'no_kamar' => $row->no_kamar,
		'nama_kamar' => $row->nama_kamar,
		'tipe_kamar' => $row->tipe_kamar,
		'harga_kamar' => $row->harga_kamar,
	    );
            $this->template->load('template','kamar_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kamar'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kamar/create_action'),
	    'id' => set_value('id'),
	    'no_kamar' => set_value('no_kamar'),
	    'nama_kamar' => set_value('nama_kamar'),
	    'tipe_kamar' => set_value('tipe_kamar'),
	    'harga_kamar' => set_value('harga_kamar'),
	);
        $this->template->load('template','kamar_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_kamar' => $this->input->post('no_kamar',TRUE),
		'nama_kamar' => $this->input->post('nama_kamar',TRUE),
		'tipe_kamar' => $this->input->post('tipe_kamar',TRUE),
		'harga_kamar' => $this->input->post('harga_kamar',TRUE),
	    );

            $this->Kamar_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kamar'));
        }
    }

    public function update($id)
    {
        $row = $this->Kamar_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kamar/update_action'),
		'id' => set_value('id', $row->id),
		'no_kamar' => set_value('no_kamar', $row->no_kamar),
		'nama_kamar' => set_value('nama_kamar', $row->nama_kamar),
		'tipe_kamar' => set_value('tipe_kamar', $row->tipe_kamar),
		'harga_kamar' => set_value('harga_kamar', $row->harga_kamar),
	    );
            $this->template->load('template','kamar_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kamar'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'no_kamar' => $this->input->post('no_kamar',TRUE),
		'nama_kamar' => $this->input->post('nama_kamar',TRUE),
		'tipe_kamar' => $this->input->post('tipe_kamar',TRUE),
		'harga_kamar' => $this->input->post('harga_kamar',TRUE),
	    );

            $this->Kamar_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kamar'));
        }
    }

    public function delete($id)
    {
        $row = $this->Kamar_model->get_by_id($id);

        if ($row) {
            $this->Kamar_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kamar'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kamar'));
        }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('no_kamar', 'no kamar', 'trim|required');
	$this->form_validation->set_rules('nama_kamar', 'nama kamar', 'trim|required');
	$this->form_validation->set_rules('tipe_kamar', 'tipe kamar', 'trim|required');
	$this->form_validation->set_rules('harga_kamar', 'harga kamar', 'trim|required|numeric');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "kamar.xls";
        $judul = "kamar";
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
	xlsWriteLabel($tablehead, $kolomhead++, "No Kamar");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Kamar");
	xlsWriteLabel($tablehead, $kolomhead++, "Tipe Kamar");
	xlsWriteLabel($tablehead, $kolomhead++, "Harga Kamar");

	foreach ($this->Kamar_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->no_kamar);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_kamar);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tipe_kamar);
	    xlsWriteNumber($tablebody, $kolombody++, $data->harga_kamar);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=kamar.doc");

        $data = array(
            'kamar_data' => $this->Kamar_model->get_all(),
            'start' => 0
        );

        $this->load->view('kamar_doc',$data);
    }

}

