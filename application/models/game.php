<?php

/**
 * Game is the model representation of the games
 * 
 * @author David Kühner
 */
class Game extends CI_Model
{
  // Constants
	const TABLE_NAME = 'games';
	
  /*
   * Instantiate a Game
   */
	function __construct()
	{}
  
  /*
   * Returns all games
   *
   * @return A Game object array
   */
	function get_all()
	{
		$query = $this->db->get($this::TABLE_NAME);
		return $query->result();
	}
  
  /*
   * Returns the game corresponding to the given id
   *
   * @param $id The game's id
   * @return A Game object
   */
  function get($id)
  {
    $this->db->where('id', $id);
		$query = $this->db->get($this::TABLE_NAME);
    return $query->result();
  }
  
  /*
   * Returns the number of victory for the given player id
   *
   * @param $player_id The player's id
   * @return The number of victory
   */
  function get_number_victory($player_id)
  {
    $this->db->where('id_winner', $player_id);
    $this->db->from($this::TABLE_NAME);
    return $this->db->count_all_results();
  }
	
  /*
   * Saves the given informations in the database
   *
   * @param $data Game description informations
   * @return The new game id
   */
	function save($data)
	{
		$this->db->insert($this::TABLE_NAME, $data);
    return $this->db->insert_id();
	}
	
  /*
   * Updates a game 
   *
   * @param $data Game description informations
   * @param $id The game's id
   */
	function update($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update($this::TABLE_NAME, $data);
	}
	
  /*
   * Deletes a game 
   *
   * @param $id The game's id
   */
	function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this::TABLE_NAME);
	}
  
  /*
   * Deletes all game where the given player is the winner
   *
   * @param $id The player's id
   */
  function delete_by_winner($winner_id)
  {
    $this->db->where('id_winner',$winner_id);
		$this->db->delete($this::TABLE_NAME);
  }
  
  /*
   * Sets a game's winner
   *
   * @param $id The game's id
   * @param $player_id The player's id
   */
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