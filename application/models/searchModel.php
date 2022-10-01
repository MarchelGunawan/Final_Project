<?php 
class searchModel extends CI_Model
{
    public function listBook()
    {
        $query = "SELECT * FROM book LIMIT 50";
        return $this->db->query($query)->result_array();
    }

    public function specific_book($id)
    {
        $query = "SELECT * FROM book WHERE Book_id = ".$id."";
        return $this->db->query($query)->row_array();
    }
}
