<?php
class User extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('security');
    }

    public function index()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "Dashboard";

        //set the curl
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://127.0.0.1:8000/dashboard/".intval(Date('j')),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        //encode the API into array
        $data['response'] = json_decode($response, true);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function table()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "List Book";
        
        //config 
        $config['base_url'] = 'http://localhost/LibrarySystem/user/table';
        $config['total_rows'] = intval(($this->searchModel->countBook())['number']);
        $config['per_page'] = 12;
        $config['full_tag_open'] = "<nav><ul class='pagination justify-content-center'>";
        $config['full_tag_close'] = "</ul></nav>";
        $config['first_link'] = "First";
        $config['first_tag_open'] = "<li class='page-item'>";
        $config['first_tag_close'] = "</li>";
        
        $config['last_link'] = "Last";
        $config['last_tag_open'] = "<li class='page-item'>";
        $config['last_tag_close'] = "</li>";
        
        $config['next_link'] = "&raquo";
        $config['next_tag_open'] = "<li class='page-item'>";
        $config['next_tag_close'] = "</li>";
        
        $config['prev_link'] = "&laquo";
        $config['prev_tag_open'] = "<li class='page-item'>";
        $config['prev_tag_close'] = "</li>";
        
        $config['cur_tag_open'] = "<li class='page-item active'><a class='page-link'>";
        $config['cur_tag_close'] = "</a></li>";
        
        $config['num_tag_open'] = "<li class='page-item'>";
        $config['num_tag_close'] = "</li>";

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['table'] = $this->searchModel->listBook($config['per_page'],$data['start']);

        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/table', $data);
        $this->load->view('templates/footer', $data);
    }

    public function recommendation()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "Recommendation Book";

        //set the curl
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://127.0.0.1:8000/".$data['user']['id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        //encode the API into array
        $data['response'] = json_decode($response, true);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/recommendation', $data);
        $this->load->view('templates/footer', $data);
    }

    public function borrow_book($id='')
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "Borrow Book";
        $this->form_validation->set_rules('days', 'Days', 'required|trim');
        if($this->form_validation->run() == false){
            $data['book'] = $this->searchModel->specific_book($id);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/borrow_book', $data);
        }else{
            $userid = $this->input->post('userid');
            $bookid = $this->input->post('bookid');
            $days = $this->input->post('days');

            $data = array(
                "book_id" => $bookid,
                "user_id" => $userid,
                "borrow_date" => date("Y-m-d"),
                "return_date" => null,
                "due_date" => date('Y-m-d', (strtotime($days.' day', strtotime(Date("Y-m-d"))))),
                "staff_id" => 0,
                "is_active" => 1
            );

            $this->db->insert('borrow_records', $data);

            $this->searchModel->update_qty_book($bookid);
            
            redirect("user/");
        }
    }

    public function all_history()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "History";
        $data['history'] = $this->searchModel->user_borrowHistory($data['user']['id']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/all_history', $data);
        $this->load->view('templates/footer', $data);
    }

    public function return_history()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "History";
        $data['history'] = $this->searchModel->user_returnHistory($data['user']['id']);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/return_history', $data);
        $this->load->view('templates/footer', $data);
    }
}
