<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Gamelist Displays a list of the whole games
 * 
 * @author David Kühner
 */
class Gamelist extends CI_Controller {

  // Private attributes
  private $data;
  
  /*
   * Instantiates a Games
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
        'title' => 'Game list',
        'signature' => 'Ping pong at DevFactory',
        );    
  }
  
  /**
   * Displays the list of games
   */
	public function index()	{
    
    $this->layout->views('gamelist/header',$this->data);

    $games = $this->game->get_all();
    
    foreach($games as $game) {
      
      $this->data['game_id'] = $game->id;
      $this->data['game_title'] = $game->title;
      if($game->id_winner == NULL) {
        $this->data['is_finish'] = FALSE;
        $this->data['winner_name'] = 'No winner... yet !';
      }
      else {
        $this->data['is_finish'] = TRUE;
        $this->data['winner_name'] = $this->player->get_name($game->id_winner);
      }
      $this->layout->views('gamelist/winner',$this->data);
    }
    $this->layout->view('gamelist/footer');
	}

  /*
   * Deletes a game and his relations in the database
   * 
   * @param $game_id Game's id
   */
  public function delete_game($game_id) {
    $this->game_player->delete_by_game($game_id);
    $this->game->delete($game_id);
    redirect('gamelist/index/','');
  }
}

/* End of file gamelist.php */
/* Location: ./application/controllers/gamelist.php */