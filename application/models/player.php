<?php

/**
 * Player is the model representation of the players
 * 
 * @author David Kühner
 */
class Player extends CI_Model
{
  // Constants
	const TABLE_NAME = 'players';
	
  /*
   * Instantiate a Player
   */
	function __construct()
	{}

  /*
   * Returns all players
   *
   * @return A Player object array
   */
	function get_all()
	{
		$query = $this->db->get($this::TABLE_NAME);
		return $query->result();
	}
  
  /*
   * Returns the player corresponding to the given id
   *
   * @param $id The player's id
   * @return A Player object
   */
  function get($id)
  {
    $this->db->where('id', $id);
		$query = $this->db->get($this::TABLE_NAME);
    return $query->result();
  }
  
  /*
   *  Returns the player's name corresponding to the given id
   *
   * @param $id The player's id
   * @return A string with the name
   */
  function get_name($id)
  {
  $player = $this->get($id);
   return $player[0]->name;
  }
	
  /*
   * Saves the given informations in the database
   *
   * @param $data Player description informations
   * @return The new player id
   */
	function save($data)
	{
		$this->db->insert($this::TABLE_NAME, $data);
    return $this->db->insert_id();
	}
	
  /*
   * Updates a player 
   *
   * @param $data Player description informations
   * @param $id The player's id
   */
	function update($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update($this::TABLE_NAME, $data);
	}
	
  /*
   * Deletes a player 
   *
   * @param $id The player's id
   */
	function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete($this::TABLE_NAME);
	}
  
  /*
   * Check if the given player already exists in the database
   * If not creates a new one and return the id
   * Else returns the corresponding id
   *
   * @param $data Player's description informations
   * @returns The player's id
   */
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