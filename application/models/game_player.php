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
	
  function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this::TABLE_NAME);
	}
  
	function delete_by_game($game_id) {
		$this->db->where('games_id',$game_id);
		$this->db->delete($this::TABLE_NAME);
	}
  
  function delete_by_player($player_id) {
		$this->db->where('players_id',$player_id);
    $query = $this->db->get($this::TABLE_NAME);
    $array = $query->result();
    foreach($array as $item) {
      $this->delete_by_game($item->games_id);
    }
    $this->db->where('players_id',$player_id);
		$this->db->delete($this::TABLE_NAME);
	}
}
?>