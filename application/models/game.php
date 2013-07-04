<?php
class game extends CI_Model
{
	const TABLE_NAME = 'games';
	
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
  
  function set_winner($id, $player_id)
  {
    $this->db->where('id', $id);
    $data = array(
      'id_winner' => $player_id,
    );
    $this->db->update($this::TABLE_NAME, $data);
  }
}
?>