<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Players extends CI_Controller {

  private $data;
  
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
        'title' => 'Add players',
        'signature' => 'Ping pong at DevFactory',
        );
        
    //$this->output->enable_profiler(true);
    
  }
  
	public function index($game_id, $nb_players)	{
    $this->data['nb_players'] = $nb_players;
    $this->data['game_id'] = $game_id;
		$this->layout->view('players/add_form',$this->data);
	}
  
  public function add_players($game_id, $nb_players) {
    
    for( $i = 1 ; $i <= $nb_players ; ++$i) { 
      $this->form_validation->set_rules('player_' . $i . '_name', 'Player ' . $i . 'name\'s', 'required');
    }
    if($this->form_validation->run() == FALSE) {
      $this->data['nb_players'] = $nb_players;
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
  
}

/* End of file players.php */
/* Location: ./application/controllers/players.php */