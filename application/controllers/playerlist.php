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
        'title' => 'Ranking',
        'signature' => 'Ping pong at DevFactory',
        );
        
    //$this->output->enable_profiler(true);
    
  }
  
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

  public function delete_player($id) {
    $this->game_player->delete_by_player($id);
    $this->game->delete_by_winner($id);
    $this->player->delete($id);
    redirect('playerlist/index/','');
  }
  
  public function test($player_id)
  {
  echo $this->game->get_number_victory($player_id);
  }
}

/* End of file players.php */
/* Location: ./application/controllers/players.php */