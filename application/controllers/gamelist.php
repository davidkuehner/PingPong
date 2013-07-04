<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gamelist extends CI_Controller {

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
        'title' => 'Gamelist',
        'signature' => 'Ping pong at DevFactory',
        );
        
    //$this->output->enable_profiler(true);
    
  }
  
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

  public function delete_game($id) {
    $this->game_player->delete_by_game($id);
    $this->game->delete($id);
    redirect('gamelist/index/','');
  }
}

/* End of file players.php */
/* Location: ./application/controllers/players.php */