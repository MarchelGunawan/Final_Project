<?php 

class Admin extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('security');
    }

    public function index()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "Admin dashboard";
        $data['top5'] = $this->searchModel->top5_book();
        $data['statistic'] = $this->searchModel->statistic();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function add_book()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "Add Book Form";
        $this->form_validation->set_rules('isbn', 'ISBN', 'required|trim');
        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/add_book', $data);
        }else{
            $image = $_FILES['image'];
            $isbn = $this->input->post('isbn');
            $title = $this->input->post('book_title');
            $author = $this->input->post('book_author');
            $year = $this->input->post('year');
            $qty = $this->input->post('qty');

            $data = array(
                "isbn" => $isbn,
                "Book_title" => $title,
                "Book_author" => $author,
                "original-publication_year" => $year,
                "Book_qty" => $qty,
                "image" => null,
                "link_image" => null,
                "average_rating" => 0,
                "ratings_count" => 0,
                "is_active" => 1
            );

            $this->db->insert("book", $data);
            
            $last_bookid = $this->searchModel->lastBookID();

            if(!empty($image)){
                $temp = explode(".", $image['name']);
                $new_name = "Book-Image-". intval($last_bookid['Book_id']) . "." . $temp[1];

                $config['upload_path'] = "./assets/img/book_img";
                $config['allowed_types'] = "jpg|jpeg|png";

                $this->load->library('upload', $config);
                move_uploaded_file($image['tmp_name'], "./assets/img/book_img/".$new_name);
                $this->db->set("image", $new_name);
                $this->db->where("Book_id", $last_bookid['Book_id']);
                $this->db->update('book');
            }
            redirect('admin/add_book');
        }

    }

    public function table()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "Table Update and Delete Book";

        //config 
        $config['base_url'] = 'http://localhost/LibrarySystem/admin/table';
        $config['total_rows'] = intval(($this->searchModel->countBook())['number']);
        $config['per_page'] = 10;
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

        $data['table'] = $this->searchModel->table_book($config['per_page'],$data['start']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/table', $data);
    }

    public function accept_borrow()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "Borrow Book";
        $data['borrow'] = $this->searchModel->list_borrow_book();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/accept_borrow', $data);
    }

    public function accepting_borrow()
    {
        $borrow_id = $this->input->post('id');
        $user_id = $this->input->post('user');
        $this->searchModel->update_accept_book($borrow_id, $user_id);
    }
    
    public function declining_borrow()
    {
        $borrow_id = $this->input->post('id');
        $user_id = $this->input->post('user');
        $book_id = $this->input->post('book');
        $this->searchModel->declining_borrow_book($borrow_id, $user_id);
        $this->searchModel->update_return_book($book_id);
    }

    public function update($id)
    {
        $isbn = $this->input->post('isbn');
        $book_title = $this->input->post('book_title');
        $book_author = $this->input->post('book_author');
        $year = $this->input->post('year');
        $qty = $this->input->post('qty');
        $this->searchModel->update_book_things($id, $book_title, $book_author, $year, $qty);
        redirect('admin/table');
    }

    public function delete($id)
    {
        $this->searchModel->update_book($id);
        redirect('admin/table');
    }

    public function return_book()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "User Return Book";
        $data['return'] = $this->searchModel->list_return_book();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/return_book', $data);
    }

    public function accept_return_book()
    {
        $borrow_id = $this->input->post('id');
        $user_id = $this->input->post('user');
        $book_id = $this->input->post('book');
        $this->searchModel->accept_book_return($borrow_id, $user_id);
        $this->searchModel->update_return_book($book_id);
    }
}
