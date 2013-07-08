<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Playerlist Displays an ordered list of the whole players
 * 
 * @author David Kühner
 */
class Playerlist extends CI_Controller {

  // Private attributes
  private $data;
  
  /*
   * Instantiates a Playerlist
   */
  public function __construct() {
    parent::__construct();

    $this->load->model('game');
    $this->load->model('player');
    $this->load->model('game_player');
    $this->load->library('layout');
    $this->load->library('debug');
    $this->layout->ajouter_css('reset');
    $this->layout->ajouter_css('typography');
    $this->layout->ajouter_css('forms');
    $this->layout->ajouter_css('ie');
    $this->layout->ajouter_css('mainstyle');

    $this->data = array(
        'title' => 'Ranking',
        'signature' => 'Ping pong at DevFactory',
        );
  }
  
  /**
   * Displays the ordered list of players
   * Dose the player's sorting
   */
	public function index()	{
    
    $this->layout->views('playerlist/header',$this->data);

    $players_object = $this->player->get_all();
    $players_array;
    
    if( $players_object!=NULL) {
    
      // Victory count
      $keys = array_keys($players_object);
      foreach($keys as $key) {
        $players_array[$key]['id'] = $players_object[$key]->id;
        $players_array[$key]['name'] = $players_object[$key]->name;
        $players_array[$key]['victory'] = $this->game->get_number_victory($players_object[$key]->id);
      }
      
      // Ranking sort
      // list of colums
      foreach($players_array as $key => $row) {
        $victory[$key] = $row['victory'];
      }
      // Sort by victory descendent
      array_multisort($victory, SORT_DESC, $players_array);
    
      $i = 1;
      foreach($players_array as $player) {
        $this->data['player_id'] = $player['id'];
        $this->data['player_name'] = $player['name'];
        $this->data['player_victory'] = $player['victory'];
        $this->data['player_position'] = $i;
        $this->layout->views('playerlist/ranking',$this->data);
        ++$i;
      }
    }
    $this->layout->view('playerlist/footer');
	}

  /**
   * Deletes a player and his relation in the database
   *
   * @param $id Player's id 
   */
  public function delete_player($player_id) {
    $this->game_player->delete_by_player($player_id);
    $this->game->delete_by_winner($player_id);
    $this->player->delete($player_id);
    redirect('playerlist/index/','');
  }
  
  /**
   * Test function
   *
   * @param Player's id
   */
  public function test($player_id)
  {
  echo $this->game->get_number_victory($player_id);
  }
}

/* End of file playerlist.php */
/* Location: ./application/controllers/playerlist.php */