<?php
class game_player extends CI_Model
{
	const TABLE_NAME = 'games_players';
	
	function __construct()
	{}

	function get_all() {
		$query = $this->db->get($this::TABLE_NAME);
		return $query->result();
	}
  
  function get_all_players_id($game_id) {
    $this->db->where('games_id', $game_id);
    $query = $this->db->get($this::TABLE_NAME);
		return $query->result();
  }
	
	function save($data) {
		$this->db->insert($this::TABLE_NAME, $data);
    return $this->db->insert_id();
	}
	
	function delete($game_id) {
		$this->db->where('game_id',$game_id);
		$this->db->delete($this::TABLE_NAME);
	}
}
?>