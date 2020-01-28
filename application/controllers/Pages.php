<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller
{
    private $data = [];

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        parent::__construct();
    }

    public function login()
    {
        $this->load->view('admin/partials/header');
        $this->load->view('admin/pages/login', $this->data);
        $this->load->view('admin/partials/footer');
    }

    public function loginAction()
    {
        if ($this->input->post('name') == 'admin' && $this->input->post('password') == 'admin1') {
            $this->session->set_userdata(['logged' => true]);
            redirect(base_url('admin'));
        } else {
            $this->data['errors'][] = 'Nesprávne meno alebo heslo';
            self::login();
        }
    }

    public function logoutAction()
    {
        $this->session->sess_destroy();
        redirect(base_url('admin'));
    }

    public function testPage()
    {
        $this->load->view('test');
    }


    public function apiCreateWheel($n)
    {
        $wheel_id = $this->db->where('wheel_number', $n)->get('wheels')->row()->id;
        $wheel_options = $this->db->where('wheel_id', $wheel_id)->get('wheels_options')->result();


        $prices = [];
        foreach ($wheel_options as $option) {
            for ($i = 0; $i < $option->option_chance; $i++) {
                $prices[] = $option;
            }
        }

        shuffle($prices);

        $win_index = rand(0, count($prices) - 1);
        $win_id = $prices[$win_index]->id;

        $w_number = $win_id;
        for ($i = 0; $i < count($wheel_options); $i++) {
            if ($wheel_options[$i]->id == $win_id) {
                $w_number = $i;
            }
        }


        $formated_options = [];
        foreach ($wheel_options as $option) {
            $formated_options[] = [
                'title' => $option->option_name,
                'foreground' => $option->option_text_color,
                'background' => $option->option_bg_color,
            ];
        }

        echo json_encode(array(
            'options' => $formated_options,
            'number' => $w_number,
            'win' => $win_id,
        ));
    }


    public function apiWheelWin($wheel, $mail, $price)
    {

        function hexToStr($str)
        {
            $sbin = "";
            $len = strlen($str);
            for ($i = 0; $i < $len; $i += 2) {
                $sbin .= pack("H*", substr($str, $i, 2));
            }

            return $sbin;
        }

        $w_mail = hexToStr($mail);
        $w_mail = $this->input->get('mail');

        $wheel_id = $this->db->where('wheel_number', $wheel)->get('wheels')->row()->id;

        $mail_spinned = $this->db->where(array(
            'wheel_id' => $wheel_id,
            'winner_mail' => $w_mail
        ))->get('wheels_winners')->num_rows();

        $win = false;

        if ($mail_spinned) {
            echo json_encode(array('status' => false));
        } else {
            $this->db->insert('wheels_winners', array(
                'wheel_id' => $wheel_id,
                'option_id' => $price,
                'winner_mail' => $w_mail
            ));
            $win = true;
            echo json_encode(array('status' => true, 's' => $mail, 's2' => $w_mail));
        }

        if ($win) {
            self::sendPrice($price, $wheel_id, $w_mail);
//            echo json_encode(array('status' => 'win', 'mail' => $mail, '$wheel_id' => $wheel_id));
        }
        
        return 1;


    }

    private function sendPrice($price_id, $wheel_id, $mail)
    {
        $this->load->library('email');

        $wheel = $this->db->where('id', $wheel_id)->get('wheels')->row();
        $price = $this->db->where('id', $price_id)->get('wheels_options')->row()->option_name;
		
        /* $win_text = str_replace($wheel->win_mail, '[vyhra]', $price); */
        $win_text = str_replace('[vyhra]', $price, $wheel->win_mail);

        $this->email
            ->from('kolesostastia@dpmarketing.sk', 'DP Marketing')
            ->to($mail)
            ->subject('Vaša výhra na: xyz.com')
            ->message($win_text)
            ->set_mailtype('html');

        $this->email->send();
    }

}
