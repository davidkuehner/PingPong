<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Games displays a form and creates a game
 * 
 * @author David Kühner
 */
class Games extends CI_Controller {

  // Constants
  const GAME_TITLE = 'game_title';
  const GAME_SET_NUMBER = 'game_set_number';
  const GAME_SET_POINTS = 'data_set_points';
  const GAME_NB_PLAYERS = 'data_nb_players';
  
  // Private attributes
  private $data;
  
  /*
   * Instantiates a Games
   */
  public function __construct() {
    parent::__construct();

    $this->load->model('game');
    $this->load->library('layout');
    $this->load->library('debug');
    $this->layout->ajouter_css('reset');
    $this->layout->ajouter_css('typography');
    $this->layout->ajouter_css('forms');
    $this->layout->ajouter_css('ie');
    $this->layout->ajouter_css('mainstyle');
    
    $this->data = array(
        'title' => 'New game',
        'signature' => 'Ping pong at DevFactory',
        );
  }
  
  /**
   * Displays the form
   */
	public function index()	{
		$this->layout->view('games/create_form',$this->data);
	}
  
  /**
   * Checks the required fields and if it's valid
   * and add the new game to the database.
   */
  public function create_game() {
    $this->form_validation->set_rules($this::GAME_TITLE, 'Titre', 'required');
    $this->form_validation->set_rules($this::GAME_SET_NUMBER, 'Number of sets', 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules($this::GAME_SET_POINTS, 'Number of points', 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules($this::GAME_NB_PLAYERS, 'Number of players', 'trim|required|is_natural_no_zero');
    
     if($this->form_validation->run() == FALSE) {
        $this->layout->view('games/create_form',$this->data);
     }
     else {
      $data_game = array(
        'title' => $this->input->post($this::GAME_TITLE),
        'set_number' => $this->input->post($this::GAME_SET_NUMBER),
        'set_points' => $this->input->post($this::GAME_SET_POINTS),
        );
      $game_id = $this->game->save($data_game);
      $nb_players = $this->input->post($this::GAME_NB_PLAYERS);
      redirect('players/index/' . $game_id . '/' . $nb_players);
     }
  }
}

/* End of file games.php */
/* Location: ./application/controllers/games.php */