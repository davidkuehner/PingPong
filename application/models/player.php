<?php
class player extends CI_Model
{
	const TABLE_NAME = 'players';
	
	function __construct()
	{}

	function get_all()
	{
		$query = $this->db->get($this::TABLE_NAME);
		return $query->result();
	}
  
  function get($id)
  {
    $this->db->where('id', $id);
		$query = $this->db->get($this::TABLE_NAME);
    return $query->result();
  }
	
	function save($data)
	{
		$this->db->insert($this::TABLE_NAME, $data);
    return $this->db->insert_id();
	}
	
	function update($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update($this::TABLE_NAME, $data);
	}
	
	function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this::TABLE_NAME);
	}
  
  function check_if_exsists($data)
  {
   $query = $this->db->get_where($this::TABLE_NAME, $data);
    if( $query->num_rows == 1 ) {
      return $this->db->get_where($this::TABLE_NAME, $data)->result_array()[0]['id'];
      }
      else {
      return $this->save($data);
      }
  }
}
?>