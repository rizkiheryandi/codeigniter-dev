<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipe_kamar extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Tipe_kamar_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $tipe_kamar = $this->Tipe_kamar_model->get_all();

        $data = array(
            'tipe_kamar_data' => $tipe_kamar
        );

        $this->template->load('template','tipe_kamar_list', $data);
    }

    public function read($id)
    {
        $row = $this->Tipe_kamar_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'tipe_kamar' => $row->tipe_kamar,
		'keterangan' => $row->keterangan,
	    );
            $this->template->load('template','tipe_kamar_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tipe_kamar'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tipe_kamar/create_action'),
	    'id' => set_value('id'),
	    'tipe_kamar' => set_value('tipe_kamar'),
	    'keterangan' => set_value('keterangan'),
	);
        $this->template->load('template','tipe_kamar_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tipe_kamar' => $this->input->post('tipe_kamar',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Tipe_kamar_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tipe_kamar'));
        }
    }

    public function update($id)
    {
        $row = $this->Tipe_kamar_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tipe_kamar/update_action'),
		'id' => set_value('id', $row->id),
		'tipe_kamar' => set_value('tipe_kamar', $row->tipe_kamar),
		'keterangan' => set_value('keterangan', $row->keterangan),
	    );
            $this->template->load('template','tipe_kamar_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tipe_kamar'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'tipe_kamar' => $this->input->post('tipe_kamar',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Tipe_kamar_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tipe_kamar'));
        }
    }

    public function delete($id)
    {
        $row = $this->Tipe_kamar_model->get_by_id($id);

        if ($row) {
            $this->Tipe_kamar_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tipe_kamar'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tipe_kamar'));
        }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('tipe_kamar', 'tipe kamar', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tipe_kamar.xls";
        $judul = "tipe_kamar";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tipe Kamar");
	xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

	foreach ($this->Tipe_kamar_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tipe_kamar);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tipe_kamar.doc");

        $data = array(
            'tipe_kamar_data' => $this->Tipe_kamar_model->get_all(),
            'start' => 0
        );

        $this->load->view('tipe_kamar_doc',$data);
    }

}

