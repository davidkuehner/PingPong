<?php

/**
 * Game_player is the model representation of the games and players relation
 * 
 * @author David Kühner
 */
class Game_player extends CI_Model
{
  // Constants
	const TABLE_NAME = 'games_players';
	
  /*
   * Instantiate a Game
   */
	function __construct()
	{}

  /*
   * Returns all game_player
   *
   * @return A Game_player object array
   */
	function get_all() {
		$query = $this->db->get($this::TABLE_NAME);
		return $query->result();
	}
  
  /*
   * Returns the game_player corresponding to the given game id
   *
   * @param $id The game's id
   * @return A Game_player object
   */
  function get_all_players_id($game_id) {
    $this->db->where('games_id', $game_id);
    $query = $this->db->get($this::TABLE_NAME);
		return $query->result();
  }
	
  /*
   * Saves the given informations in the database
   *
   * @param $data Game_player description informations
   * @return The new Game_player id
   */
	function save($data) {
		$this->db->insert($this::TABLE_NAME, $data);
    return $this->db->insert_id();
	}
	
  /*
   * Deletes a Game_player
   *
   * @param $id The Game_player's id
   */
  function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this::TABLE_NAME);
	}
  
  /*
   * Deletes all a Game_player including the given game 
   *
   * @param $id The game's id
   */
	function delete_by_game($game_id) {
		$this->db->where('games_id',$game_id);
		$this->db->delete($this::TABLE_NAME);
	}
  
  /*
   * Deletes all Game_player including the given player
   *
   * @param $id The player's id
   */
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