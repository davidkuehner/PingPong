<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Scores displays a for each player a score tables
 * with the number of points and sets.
 * It check if there is a two point margin.
 * 
 * @author David Kühner
 */
class Scores extends CI_Controller {

  // Constants
  const POINTS_GAP = 2;
  
  // Private attributes
  private $data;
  
  /*
   * Instantiates a Scores
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
    $this->layout->add_google_jquery();

    $this->data = array(
        'title' => 'Scores',
        'signature' => 'Ping pong at DevFactory',
        );
        
    //$this->output->enable_profiler(true);
  }
  
  /**
   * Displays the scores tables
   *
   * @param $game_id Current game id
   */
	public function index($game_id)	{
  
    $this->layout->views('scores/header',$this->data);
    
    // If we have a winner dispay name
    $winner_id = $this->game->get($game_id);
    if($winner_id[0]->id_winner!=NULL)
    {
      $info = $this->player->get($winner_id[0]->id_winner);
      $data_winner['player_name'] = $info[0]->name;
      $this->layout->views('scores/winner',$data_winner);
    }
    // Else display scores tables
    else {
    
      // Get every players in this game
      $players_id = $this->game_player->get_all_players_id($game_id);
      foreach ($players_id as $player)
      {
        $player_points = 'player_' . $player->players_id . '_' . $game_id . '_points';
        $player_sets = 'player_' . $player->players_id . '_' . $game_id . '_sets';
      
        $points = $this->session->userdata($player_points);
        $sets = $this->session->userdata($player_sets);
        
        // Replace NULL by 0
        if(! $points) {
          $points = 0;
        }
        if(! $sets) {
          $sets = 0;
        }
        
        $newdata[$player_points] = $points;
        $newdata[$player_sets] = $sets;
        $this->session->set_userdata($newdata);

        // Initialisation of player's informations
        $info = $this->player->get($player->players_id);
        $data_player['player_name'] = $info[0]->name;
        $data_player['player_id'] = $info[0]->id;
        $data_player['game_id'] = $game_id;
        $data_player['points_score'] = $points;
        $data_player['sets_score'] = $sets;
        $this->layout->views('scores/player_table',$data_player);
      }
    }
    $this->layout->views('scores/footer');
    $this->layout->view('scores/ajax_script'); //TODO put in the header theme
	}  
  
  /**
   * Add a point to a player.
   * Respect a two point margin
   *
   * @param $player_id Current player id
   * @param $game_id Current game id
   */
  public function add_point($player_id, $game_id)
  {    
    $player_points = 'player_' . $player_id . '_' . $game_id . '_points';
    $player_sets = 'player_' . $player_id . '_' . $game_id . '_sets'; 
    $set_is_won = FALSE;

    // Get the opponent points
    // TODO put in a function
    $opponent_players_id = $this->game_player->get_all_players_id($game_id);
    $opponent_player_points;
    foreach ($opponent_players_id as $player)
    {
      if($player->players_id != $player_id) {
        $opp_player_key = 'player_' . $player->players_id . '_' . $game_id . '_points';
        $opp_points = $this->session->userdata($opp_player_key);
        $opponent_player_points[$player->players_id] = $opp_points;
      }
    }
    
    // Get actual number of points and sets
    $points =  $this->session->userdata($player_points);
    $sets =  $this->session->userdata($player_sets);
    
    // Get point's and set's max
    $game = $this->game->get($game_id);
    $sets_max = $game[0]->set_number;
    $points_max = $game[0]->set_points;

    // Points inc
    ++$points;
    if($points >= $points_max) {
      $opponent_is_close = FALSE;
      foreach($opponent_player_points as $opponent_points) {
        if(($points - $opponent_points) < $this::POINTS_GAP) {
          $opponent_is_close = TRUE;
        }
      }
      if( ! $opponent_is_close ) {
        // Set opponents points to zero
        $opponent_player_points = $this->set_opponents_points($opponent_player_points, 0);
        // Set current player points to zero and add a set
        $points = 0;
        ++$sets;
        $set_is_won = TRUE;
      }      
    }
     
    // Check we have a winner
    if($sets == $sets_max) {
      $this->game->set_winner($game_id, $player_id);
      redirect('scores/index/' . $game_id);
    }
    
    if($set_is_won) {
      // update data opponents players
      foreach ($opponent_players_id as $player)
      {
        // if it isn't the current player
        if($player->players_id != $player_id) {
          $opponent_points_key = 'player_' . $player->players_id . '_' . $game_id . '_points';
          $newdata[$opponent_points_key] = $opponent_player_points[$player->players_id];
        }
      }
    }
    
    // update data current player
    $newdata[$player_points] = $points;
    $newdata[$player_sets] = $sets;
    
    // update
    $this->session->set_userdata($newdata);
    
    redirect('scores/index/' . $game_id);
  }
  
  /*
   * set the points to each player to the given value
   *
   * @param $array List of players
   * @param $val Value to set
   * @return $array LIst of players with the given value
   */
  private function set_opponents_points($array, $val) {
    $keys = array_keys($array);
    foreach($keys as $key) {
        $array[$key] = $val;
    }
    return $array;
  }
  
  /*
   * Debug function, clear the session
   *
   * @param $game_id Current game id
   */
  public function clear_session($game_id) {
    $this->session->sess_destroy();
    redirect('scores/index/' . $game_id);
  }
  
  public function test() {
     $test['ret1'] = 'test';
     $test['ret2'] = time();
     $this->output->set_output(json_encode($test));
  }
}

/* End of file players.php */
/* Location: ./application/controllers/players.php */