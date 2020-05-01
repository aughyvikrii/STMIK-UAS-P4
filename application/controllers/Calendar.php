<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class calendar extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->database();
        $this->load->library('session');
    }

	public function index()
	{

        $year = $this->uri->segment(3);
        if( !$year ) $year = date('Y');

        $month = $this->uri->segment(4);
        if( !$month ) $month = date('m');

        $prefs = array(
            'show_next_prev'    => TRUE,
            'next_prev_url'     => site_url("/calendar/index"),
        );

        $prefs['template'] = '

                {table_open}<table class="table table-bordered" border="0" cellpadding="4" cellspacing="0">{/table_open}

                {heading_row_start}<tr>{/heading_row_start}

                {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
                {heading_title_cell}<th colspan="{colspan}" class="text-center">{heading}</th>{/heading_title_cell}
                {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

                {heading_row_end}</tr>{/heading_row_end}

                {week_row_start}<tr class="text-center">{/week_row_start}
                {week_day_cell}<td>{week_day}</td>{/week_day_cell}
                {week_row_end}</tr>{/week_row_end}

                {cal_row_start}<tr class="text-center">{/cal_row_start}
                {cal_cell_start}<td>{/cal_cell_start}
                {cal_cell_start_today}<td>{/cal_cell_start_today}
                {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

                {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
                {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

                {cal_cell_no_content} <a href="'.base_url('calendar/agenda/'.$year.'/'.$month.'/{day}').'" style="color:black;">{day}</a> {/cal_cell_no_content}
                {cal_cell_no_content_today}<a href="'.base_url('calendar/agenda/'.$year.'/'.$month.'/{day}').'">{day}</a>{/cal_cell_no_content_today}

                {cal_cell_blank}&nbsp;{/cal_cell_blank}

                {cal_cell_other}<a href="#">{day}</a>{/cal_cel_other}

                {cal_cell_end}</td>{/cal_cell_end}
                {cal_cell_end_today}</td>{/cal_cell_end_today}
                {cal_cell_end_other}</td>{/cal_cell_end_other}
                {cal_row_end}</tr>{/cal_row_end}

                {table_close}</table>{/table_close}
        ';

        $this->load->library('calendar',$prefs);
        $data['varkal']     = $this->calendar->generate($year,$month);
        $data['judulapp']   = 'UAS P4 Eksekutif 1218624';

		$this->load->view('view_calender',$data);
    }
    
    public function agenda(){
        $year   = $this->uri->segment(3);
        $month  = $this->uri->segment(4);
        $day    = $this->uri->segment(5);

        if( !$year || !$month || !$day ){
            echo "<h1>URL Tidak Valid</h1>";
            die;
        }

        $tanggal = "{$year}-{$month}-{$day}";

        $date_data = $this->db->query("SELECT * FROM agenda WHERE tanggal = '{$tanggal}'")->result();
        $is_edit = isset($_GET['edit']) ? true : false;

        if( count($date_data) == 0|| $is_edit ){

            $judul = 'Tambah data kegiatan';
            if( $is_edit ) $judul = 'Edit data kegiatan';

            $data = [
                'judulapp'  => $judul,
                'year'      => $year,
                'month'     => $month,
                'day'       => $day,
                'date_data' => $date_data
            ];

            $this->load->view('add_agenda',$data);
        } else {
            $data = [
                'judulapp'  => 'Detail data kegiatan',
                'year'      => $year,
                'month'     => $month,
                'day'       =>  $day,
                'data'      => $date_data
            ];

            $this->load->view('view_agenda',$data);
        }
    }

    public function tambah_agenda(){
        $year   = $this->uri->segment(3);
        $month  = $this->uri->segment(4);
        $day    = $this->uri->segment(5);

        if( !$year || !$month || !$day ){
            echo "<h1>URL Tidak Valid</h1>";
            die;
        }

        $tanggal = "{$year}-{$month}-{$day}";

        $date_data = $this->db->query("SELECT * FROM agenda WHERE tanggal = '{$tanggal}'")->result();

        $config['upload_path']      = FCPATH.'/assets/upload/';
        $config['allowed_types']    = '*';

        $this->load->library('upload', $config);

        $upload = $this->upload->do_upload('user_file');

        if( !$upload ) {
            $this->session->set_flashdata('error','Gagal submit data');
            return redirect( base_url('/calendar/index/'.$year.'/'.$month.'/'.$day) );
        }

        $file_name = $_FILES['user_file']['name'];

        $nama = $_POST['nama_agenda'];

        if( !$date_data ){

            $insert = $this->db->query("INSERT INTO agenda(nama,tanggal,file) VALUES('{$nama}','{$tanggal}','{$file_name}')");
            $this->session->set_flashdata('success','Berhasil upload data');
            return redirect( base_url('/calendar/index/'.$year.'/'.$month) );

        } else {

            $insert = $this->db->query("UPDATE agenda SET nama='{$nama}',file='{$file_name}' WHERE tanggal = '{$tanggal}'");
            $this->session->set_flashdata('success','Berhasil update data');
            return redirect( base_url('/calendar/index/'.$year.'/'.$month.'/'.$day) );
        }
    }
}
