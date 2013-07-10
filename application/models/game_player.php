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
    $players = $query->result();
    $players_id = array();
    foreach($players as $player) {
      array_push($players_id, $player->players_id);
    }
    return $players_id;
  }
  
  /*
   * Returns the number of points for the given player and game
   *
   * @param $game_id The game's id
   * @param $player_id The player's id
   * @return The number of points
   */
  function get_points($game_id, $player_id) {
    $this->db->where('games_id', $game_id);
    $this->db->where('players_id', $player_id);
    $query = $this->db->get($this::TABLE_NAME);
    $result = $query->result();
    return $result[0]->points;
  }
  
  /*
   * Returns the number of sets for the given player and game
   *
   * @param $game_id The game's id
   * @param $player_id The player's id
   * @return The number of points
   */
  function get_sets($game_id, $player_id) {
    $this->db->where('games_id', $game_id);
    $this->db->where('players_id', $player_id);
    $query = $this->db->get($this::TABLE_NAME);
    $result = $query->result();
    return $result[0]->sets;
  }
  
  /*
   * Update the points to the given game to all players
   
   * @param $game_id The game's id
   * @param $value The new points value
   */
  function update_all_points($game_id, $value) {
    $this->db->where('games_id', $game_id);
    $data = array('points'=>$value);
    $this->db->update($this::TABLE_NAME, $data); 
  }
  
  /*
   * Saves the points to the given game and player
   *
   * @param $game_id The game's id
   * @param $player_id The player's id
   * @param $value The new points value
   */
	function save_points($game_id, $player_id, $value) {
		$this->db->where('games_id', $game_id);
    $this->db->where('players_id', $player_id);
    $data = array('points'=>$value);
    $this->db->update($this::TABLE_NAME, $data); 
	}
  /*
   * Saves the sets to the given game and player
   *
   * @param $game_id The game's id
   * @param $player_id The player's id
   * @param $value The new sets value
   */
	function save_sets($game_id, $player_id, $value) {
		$this->db->where('games_id', $game_id);
    $this->db->where('players_id', $player_id);
    $data = array('sets'=>$value);
    $this->db->update($this::TABLE_NAME, $data); 
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