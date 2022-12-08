<?php 
class searchModel extends CI_Model
{
    public function listBook($limit, $start)
    {
        return $this->db->get('book', $limit, $start)->result_array();
    }

    public function specific_book($id)
    {
        $query = "SELECT * FROM book WHERE Book_id = ".$id."";
        return $this->db->query($query)->row_array();
    }

    public function countBook()
    {
        $query = "SELECT COUNT(Book_id) as number FROM book";
        return $this->db->query($query)->row_array();
    }

    public function user_borrowHistory($user_id)
    {
        $query = "SELECT t1.* , t2.Book_title FROM `borrow_records` t1
        JOIN `book` t2 ON t2.Book_id = t1.book_id WHERE t1.user_id = ".$user_id." ;";
        return $this->db->query($query)->result_array();
    }

    public function user_returnHistory($user_id)
    {
        $query = "SELECT t1.* , t2.Book_title, t3.return_id, t3.return_date FROM `borrow_records` t1
        JOIN `book` t2 ON t2.Book_id = t1.book_id
        JOIN `return_record` t3 ON t3.borrow_id = t1.borrow_id WHERE t1.user_id = ".$user_id;
        return $this->db->query($query)->result_array();
    }

    public function table_book($limit, $start)
    {
        return $this->db->get('book', $limit, $start)->result_array();
    }

    public function update_book($id)
    {
        $query = "UPDATE `book` SET is_active = 0 WHERE Book_id = ".$id;
        $this->db->query($query);
    }

    public function update_book_things($id, $book_title, $book_author, $year, $qty){
        $query = "UPDATE `book` SET Book_title = '".$book_title."', Book_author = '".$book_author."', `original-publication_year` = '".$year."', Book_qty = '".$qty."' WHERE Book_id = ".$id.";";
        $this->db->query($query);
    }

    public function lastBookID()
    {
        $query = "SELECT * FROM `book` ORDER BY Book_id DESC LIMIT 1;";
        return $this->db->query($query)->row_array();
    }

    public function update_qty_book($book_id)
    {
        $query = "UPDATE `book` SET Book_qty = Book_qty - 1 WHERE Book_id = ".$book_id;
        $this->db->query($query);
    }

    public function list_borrow_book()
    {
        $query = "SELECT t1.borrow_id, t2.Book_title, t3.username, t1.borrow_date, t1.due_date, t3.image, t2.Book_id FROM borrow_records t1
        JOIN book t2 ON t2.Book_id = t1.book_id
        JOIN user t3 ON t3.id = t1.user_id WHERE t1.staff_id = 0 AND t1.is_active = 1";
        return $this->db->query($query)->result_array();
    }

    public function update_accept_book($borrow_id, $user)
    {
        $query = "UPDATE borrow_records SET staff_id = ". $user ." WHERE borrow_id = ".$borrow_id;
        $this->db->query($query);
    }

    public function declining_borrow_book($borrow_id, $user_id)
    {
        $query = "UPDATE borrow_records SET is_active = 0, staff_id = ". $user_id ." WHERE borrow_id = ".$borrow_id;
        $this->db->query($query);
    }

    public function list_return_book()
    {
        $query = "SELECT t1.borrow_id, t2.Book_title, t3.username, t1.borrow_date, t1.due_date, t1.return_date, t2.Book_id FROM borrow_records t1
        JOIN book t2 ON t2.Book_id = t1.book_id
        JOIN user t3 ON t3.id = t1.user_id WHERE t1.staff_id <> 0 AND (t1.is_active = 1 OR t1.is_active = 2)";
        return $this->db->query($query)->result_array();
    }

    public function accept_book_return($borrow_id, $user_id)
    {
        $query = "UPDATE borrow_records SET return_date = '".Date('Y-m-d')."', staff_id = ". $user_id ." WHERE borrow_id = ".$borrow_id;
        $this->db->query($query);
    }

    public function update_return_book($book_id)
    {
        $query = "UPDATE book SET Book_qty = Book_qty + 1 WHERE Book_id = ".$book_id;
        $this->db->query($query);
    }

    public function top5_book(){
        $query = "SELECT * FROM book ORDER BY average_rating DESC LIMIT 0,10 ";
        return $this->db->query($query)->result_array();
    }

    // function for take data for today borrow book and return it
    public function statistic(){
        $date = Date('Y-m-d');
        $query = "SELECT * FROM borrow_records WHERE borrow_date = '".$date."'";
        return $this->db->query($query)->result_array();
    }
}
