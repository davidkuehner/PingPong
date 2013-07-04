<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Playerlist extends CI_Controller {

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
        'title' => 'Player list',
        'signature' => 'Ping pong at DevFactory',
        );
        
    //$this->output->enable_profiler(true);
    
  }
  
	public function index()	{
    
    $this->layout->views('playerlist/header',$this->data);

    $players = $this->player->get_all();
    
    foreach($players as $player) {
      
      $this->data['player_id'] = $player->id;
      $this->data['player_name'] = $player->name;
      $this->data['player_victory'] = 0;
      $this->data['player_position'] = 1;
      $this->layout->views('playerlist/ranking',$this->data);
    }
    $this->layout->view('playerlist/footer');
	}

  public function delete_player($id) {
    $this->game_player->delete_by_player($id);
    $this->game->delete_by_winner($id);
    $this->player->delete($id);
    redirect('playerlist/index/','');
  }
}

/* End of file players.php */
/* Location: ./application/controllers/players.php */