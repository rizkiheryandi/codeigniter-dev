<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Booking extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $booking = $this->Booking_model->get_all_query();

        $data = array(
            'booking_data' => $booking
        );

        $this->template->load('template','booking_list', $data);
    }

    public function read($id)
    {
        $row = $this->Booking_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'tgl_booking' => $row->tgl_booking,
		'id_pelanggan' => $row->id_pelanggan,
		'id_kamar' => $row->id_kamar,
		'lama' => $row->lama,
	    );
            $this->template->load('template','booking_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('booking/create_action'),
    	    'id' => set_value('id'),
    	    'tgl_booking' => set_value('tgl_booking'),
    	    'id_pelanggan' => set_value('id_pelanggan'),
    	    'id_kamar' => set_value('id_kamar'),
    	    'lama' => set_value('lama'),
            'cmb' => 'create'
	);
        $this->template->load('template','booking_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $id_kamar = $this->input->post('id_kamar');
            $data = array(
        		'tgl_booking' => $this->input->post('tgl_booking',TRUE),
        		'id_pelanggan' => $this->input->post('id_pelanggan',TRUE),
        		'id_kamar' => $this->input->post('id_kamar',TRUE),
        		'lama' => $this->input->post('lama',TRUE),
	    );

            $this->Booking_model->insert($id_kamar, $data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('booking'));
        }
    }

    public function update($id, $id_kamar_lama)
    {
        $row = $this->Booking_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('booking/update_action'),
        		'id' => set_value('id', $row->id),
        		'tgl_booking' => set_value('tgl_booking', $row->tgl_booking),
        		'id_pelanggan' => set_value('id_pelanggan', $row->id_pelanggan),
        		'id_kamar' => set_value('id_kamar', $row->id_kamar),
        		'lama' => set_value('lama', $row->lama)
	    );
            $this->template->load('template','booking_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking'));
        }

        $this->session->set_flashdata('id_kamar_lama', $id_kamar_lama);
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
        		'tgl_booking' => $this->input->post('tgl_booking',TRUE),
        		'id_pelanggan' => $this->input->post('id_pelanggan',TRUE),
        		'id_kamar' => $this->input->post('id_kamar',TRUE),
        		'lama' => $this->input->post('lama',TRUE),
    	    );

            $id_kamar_lama = $this->session->flashdata('id_kamar_lama');
            $id_kamar_baru = $this->input->post('id_kamar');

            $this->Booking_model->update($this->input->post('id', TRUE), $id_kamar_lama, $id_kamar_baru, $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('booking'));
        }
    }

    public function delete($id, $id_kamar)
    {
        $row = $this->Booking_model->get_by_id($id);

        if ($row) {
            $this->Booking_model->delete($id, $id_kamar);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('booking'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('booking'));
        }
    }

    public function _rules()
    {
	$this->form_validation->set_rules('tgl_booking', 'tgl booking', 'trim|required');
	$this->form_validation->set_rules('id_pelanggan', 'id pelanggan', 'trim|required');
	$this->form_validation->set_rules('id_kamar', 'id kamar', 'trim|required');
	$this->form_validation->set_rules('lama', 'lama', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "booking.xls";
        $judul = "booking";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Booking");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pelanggan");
	xlsWriteLabel($tablehead, $kolomhead++, "No Kamar");
	xlsWriteLabel($tablehead, $kolomhead++, "Lama");

	foreach ($this->Booking_model->get_all_query() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_booking);
	    xlsWriteNumber($tablebody, $kolombody++, $data->nama_pelanggan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->no_kamar);
	    xlsWriteNumber($tablebody, $kolombody++, $data->lama);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=booking.doc");

        $data = array(
            'booking_data' => $this->Booking_model->get_all_query(),
            'start' => 0
        );

        $this->load->view('booking_doc',$data);
    }


}
