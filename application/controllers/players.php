<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Players displays a form to select the players
 * If the player isn't in the database, he's add to it.
 * 
 * @author David Kühner
 */
class Players extends CI_Controller {
  
  // Private attributes
  private $data;
  
  /*
   * Instantiates a Players
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
    $this->layout->ajouter_css('jquery.ui');
    $this->layout->ajouter_css('mainstyle');
    $this->layout->ajouter_js('jquery');
    $this->layout->ajouter_js('jquery.ui');
    $this->layout->ajouter_js('scripts');
    
    $this->data = array(
        'title' => 'Add players',
        'signature' => 'Ping pong at DevFactory',
        );
  }
  
  /**
   * Displays the form
   *
   * @param $game_id Current game id
   * @param $nb_players Number of players in the game
   */
	public function index($game_id, $nb_players)	{
    $this->data['nb_players'] = $nb_players;
    $this->data['game_id'] = $game_id;
		$this->layout->view('players/add_form',$this->data);
	}
  
  /**
   * Checks the required fields and if it's valid
   * and add the new player to the database.
   *
   * @param $game_id Current game id
   * @param $nb_players Number of players in the game
   */
  public function add_players($game_id, $nb_players) {
    
    for( $i = 1 ; $i <= $nb_players ; ++$i) { 
      $this->form_validation->set_rules('player_' . $i . '_name', 'Player ' . $i . 'name\'s', 'required');
    }
    if($this->form_validation->run() == FALSE) {
      $this->data['nb_players'] = $nb_players;
      $this->data['game_id'] = $game_id;
      $this->layout->view('players/add_form',$this->data);
    }
    else {
      for( $i = 1 ; $i <= $nb_players ; ++$i) { 
        $data_player = array(
          'name' => $this->input->post('player_' . $i . '_name'),
        );
        $player_id = $this->player->check_if_exsists($data_player);
        
        $data_game_player = array(
          'games_id' => $game_id,
          'players_id' => $player_id,
        );
                
        $this->game_player->save($data_game_player);
      }
      redirect('scores/index/' . $game_id);
     }
  }
  
  /**
   * Checks for suggestions in the database
   */
  function suggestions(){
    if (isset($_GET['term'])){
      $q = $_GET['term'];
      $suggestions = $this->player->suggestions($q);   //!\\ secure it
      echo '["';
      echo implode('","',$suggestions);
      echo '"]';
    }
  }
}

/* End of file players.php */
/* Location: ./application/controllers/players.php */