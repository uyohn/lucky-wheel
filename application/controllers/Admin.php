<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    private $data = [];

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
        if (!($this->session->has_userdata('logged') && $this->session->has_userdata('logged') === true)) {
            redirect(base_url('admin/login'));
        }
    }

    private final function loadAdminView($page)
    {
        $this->load->view('admin/partials/header');
        $this->load->view('admin/partials/nav');
        $this->load->view("admin/pages/$page", $this->data);
        $this->load->view('admin/partials/footer');
    }

    public function index()
    {
        $this->data['wheels'] = $this->db->order_by('created', 'DESC')->get('wheels')->result_array();
        self::loadAdminView('home');
    }

    public function createWheel()
    {


        $this->db->insert('wheels', array(
            'wheel_number' => time(),
            'wheel_name' => $this->input->post('wheel_name'),
            'win_mail' => $this->input->post('wheel_name'),
        ));

        $wheel_id = $this->db->insert_id();

        if ($this->input->post('new_wheel_options')) {

            foreach ($this->input->post('new_wheel_options') as $item) {
                $this->db->insert('wheels_options', array(
                    'wheel_id' => $wheel_id,
                    'option_name' => $item['option_name'],
                    'option_chance' => $item['option_chance'],
                    'option_text_color' => $item['option_text_color'],
                    'option_bg_color' => $item['option_bg_color'],
                ));
            }

        }

        echo json_encode(array(
            'status' => true
        ));

    }

    public function getWheelOptions($wheelNumber)
    {
        $this->db->select('wheels_options.*');
        $this->db->from('wheels');
        $this->db->join('wheels_options', 'wheels_options.wheel_id = wheels.id');
        $this->db->where('wheels.wheel_number', $wheelNumber);
        $query = $this->db->get()->result_array();
        echo json_encode($query);

    }

    public function editWheelByWheelNumber($wheelNumber)
    {
//        echo json_encode($this->input->post());
//        return;

        $this->db->where('wheel_number', $wheelNumber)->update('wheels', array(
            'wheel_name' => $this->input->post('wheel_name'),
            'win_mail' => $this->input->post('win_mail')
        ));

        $wheel_options = $this->input->post('new_wheel_options');
        if ($wheel_options) {

            $wheel_id = $this->db->where('wheel_number', $wheelNumber)->get('wheels')->row()->id;
            $this->db->where('wheel_id', $wheel_id)->delete('wheels_options');

            foreach ($wheel_options as $item) {

                $data = array(
                    'wheel_id' => $wheel_id,
                    'option_name' => $item['option_name'],
                    'option_chance' => $item['option_chance'],
                    'option_text_color' => $item['option_text_color'],
                    'option_bg_color' => $item['option_bg_color'],
                );

                if (isset($item['id'])) {
                    $data['id'] = $item['id'];
                }

                $this->db->insert('wheels_options', $data);
            }


        }

        echo json_encode(array(
            'status' => true
        ));

    }

    public function singleWheel($n)
    {
        $wheel_id = $this->db->where('wheel_number', $n)->get('wheels')->row()->id;

        $this->db->select('wheels_options.option_name,wheels_winners.created,wheels_winners.winner_mail,wheels_winners.id');
        $this->db->from('wheels_winners');
        $this->db->join('wheels_options', 'wheels_options.id = wheels_winners.option_id');
        $this->db->where('wheels_winners.wheel_id', $wheel_id);
        $query = $this->db->get()->result();

        $this->data['winners'] = $query;
        $this->data['wheel'] = $n;
        $this->data['wheel_id'] = $wheel_id;

        self::loadAdminView('wheel');
    }

    public function exportSingleWheel($id)
    {
        $winners = $this->db->where('wheel_id', $id)->get('wheels_winners')->result();

        $export_file = FCPATH . 'public/export.txt';
        file_put_contents($export_file, "");

        $winners_list = '';
        foreach ($winners as $winner) {
            $winners_list .= $winner->winner_mail . "\r\n";
        }
//
        file_put_contents($export_file,  $winners_list);
//        file_put_contents($export_file, "\xEF\xBB\xBF" . $winners_list);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename('export.txt'));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($export_file));
        readfile($export_file);

        return 1;
    }

    public function deleteWheelWinner($w, $i)
    {
        $this->db->where('id', $i)->delete('wheels_winners');
        redirect(base_url('admin/wheel/' . $w));
    }

    public function deleteWheel($id)
    {
        $this->db->where('id', $id)->delete('wheels');
        $this->db->where('wheel_id', $id)->delete('wheels_options');
        $this->db->where('wheel_id', $id)->delete('wheels_winners');
        redirect(base_url('admin'));

    }


}
