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
    $this->layout->ajouter_js('jquery');
    $this->layout->ajouter_js('scores');

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
  
    // Get every players in this game
    $players_id = $this->game_player->get_all_players_id($game_id);
    $this->data['player_one_id'] = $players_id[0];
    $this->data['player_two_id'] = $players_id[1];
    $this->data['game_id'] = $game_id;
      
    // If we have a winner dispay name
    $winner_id = $this->game->get($game_id);
    if($winner_id[0]->id_winner!=NULL)
    {
      $info = $this->player->get($winner_id[0]->id_winner);
      $this->data['winner_name'] = $info[0]->name;
      $this->layout->views('scores/header',$this->data);
    }
    else {
      $this->data['winner_name'] = NULL;
      $this->layout->views('scores/header',$this->data);
      foreach ($players_id as $id)
      {
        $points = $this->game_player->get_points($game_id, $id);
        $sets = $this->game_player->get_sets($game_id, $id);

        // Initialisation of player's informations
        $info = $this->player->get($id);
        $data_player['player_name'] = $info[0]->name;
        $data_player['player_id'] = $info[0]->id;
        $data_player['game_id'] = $game_id;
        $data_player['points_score'] = $points;
        $data_player['sets_score'] = $sets;
        $this->layout->views('scores/player_table',$data_player);
      }
    }
    $this->layout->view('scores/footer');
	}  
  
  /**
   * Add a point to a player. 
   * Respect a two point margin
   *
   * @param $player_id Current player id
   * @param $game_id Current game id
   * @param $current_points players points associative array 'player_id'=>'points' 
   * @param $current_sets players sets associative array 'player_id'=>'sets' 
   */
  public function add_point()
  {    
    // Get JSON arguments
    $game_id = json_decode(stripslashes($_GET['game_id']));
    $current_player_id = json_decode(stripslashes($_GET['player_id']));
    $current_player_points = json_decode(stripslashes($_GET['player_points']));
    $current_player_sets = json_decode(stripslashes($_GET['player_sets']));
  
    $set_is_won = FALSE;
    $opponent_is_close = FALSE;
    $opponent_is_equal = FALSE;

    // Get the opponent points
    $opponent_players_id = $this->get_opponent_player_id($game_id, $current_player_id);
    $opponent_player_points = $this->get_opponent_player_points($game_id, $opponent_players_id);

    // Get point's and set's max
    $game = $this->game->get($game_id);
    $sets_max = $game[0]->set_number;
    $points_max = $game[0]->set_points;

    // Points inc
    ++$current_player_points;
    if($current_player_points >= $points_max) {
        foreach($opponent_player_points as $opponent_points) {
          if(($current_player_points - $opponent_points) < $this::POINTS_GAP) {
            $opponent_is_close = TRUE;
          }
        }
      if( ! $opponent_is_close ) {
        // Set opponents points to zero
        $opponent_player_points = $this->set_opponents_points($opponent_player_points, 0);
        // Set current player points to zero and add a set
        $current_player_points = 0;
        ++$current_player_sets;
        $set_is_won = TRUE;
      }      
    }
     
    // Check if we have a winner
    $check = $this->check_winner($game_id, $current_player_id, $current_player_sets, $sets_max);
    $result['has_winner'] = $check['has_winner'];
    $result['winner_name'] = $check['winner_name'];   

    // If a set is won and the game isn't over, reset opponent 
    // points (keep them if the game is over for statistiques
    if($set_is_won && !$check['has_winner']) {
      $result['reset_points'] = true;
    }
    else {
      $result['reset_points'] = false;
    }

    // check if it's a match point
    $array = $this->get_match_point_status($game_id, $current_player_id, $current_player_points, $points_max);
    $result['is_match_point'] = $array['is_match_point'];
    $result['winner_couple'] = $array['winner_couple'];
    
    // update data current player
    $result['current_points'] = $current_player_points;
    $result['current_sets'] = $current_player_sets;
    
    // save points in database
    if($set_is_won) {
      $this->game_player->update_all_points($game_id, 0);
    }
    $this->game_player->save_points($game_id, $current_player_id, $current_player_points);
    $this->game_player->save_sets($game_id, $current_player_id, $current_player_sets);
    
    // Return informations to ajax
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
  }
  
  /**
   * Add a point to a player. 
   * Respect a two point margin
   *
   * @param $player_id Current player id
   * @param $game_id Current game id
   * @param $current_points players points associative array 'player_id'=>'points' 
   * @param $current_sets players sets associative array 'player_id'=>'sets' 
   */
  public function rem_point() {
    // Get JSON arguments
    $game_id = json_decode(stripslashes($_GET['game_id']));
    $current_player_id = json_decode(stripslashes($_GET['player_id']));
    $current_player_points = json_decode(stripslashes($_GET['player_points']));
  
    // Points dec
    --$current_player_points;
    if($current_player_points >= 0) {
      $result['current_points'] = $current_player_points;
      $this->game_player->save_points($game_id, $current_player_id, $current_player_points);
    }
    else {
      // already zero
      $result['current_points'] = 0; 
    }
    
    // Get point's max
    $game = $this->game->get($game_id);
    $points_max = $game[0]->set_points;
    
    // check if it's a match point
    $array = $this->get_match_point_status($game_id, $current_player_id, $current_player_points, $points_max);
    $result['is_match_point'] = $array['is_match_point'];
    $result['winner_couple'] = $array['winner_couple'];
    
    
    // Return informations to ajax
    $this->output->set_content_type('application/json')->set_output(json_encode($result));
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
   * Returns the winner status
   *
   * @param $game_id Current game id
   * @param $player_id Current player id
   * @return $array List with status has_winner and name winner_name
   */
  private function check_winner($game_id, $player_id, $current_player_sets, $sets_max) {
    $array['has_winner'] = false;
    $array['winner_name'] = false;
    if($current_player_sets == $sets_max) {
      $this->game->set_winner($game_id, $player_id);
      $info = $this->player->get($player_id);
      $array['winner_name'] = $info[0]->name;
      $array['has_winner'] = true;
    }
    return $array;
  }
  
  /*
   * Returns the opponent id list
   *
   * @param $game_id Current game id
   * @param $player_id Current player id
   */
  private function get_opponent_player_id($game_id, $player_id) {
    $opponent_players_id = $this->game_player->get_all_players_id($game_id);
    // Remove current player
    foreach ($opponent_players_id as $key => $id)
    {
      if($id == $player_id) {
      unset($opponent_players_id[$key]);
      }
    }
    return $opponent_players_id;
  }
  
  /*
   * Returns the opponent points list
   *
   * @param $game_id Current game id
   * @param $opponent_players_id Opponent id list
   */
  private function get_opponent_player_points($game_id, $opponent_players_id) {
    $opponent_player_points;
    foreach ($opponent_players_id as $id)
      {
          $opp_points = $this->game_player->get_points($game_id,$id);
          $opponent_player_points[$id] = $opp_points;
      }
    return $opponent_player_points;
  }
  
  /*
   * Returns the match status
   *
   * @param $game_id Current game id
   * @param $current_player_id Current player id
   * @param $current_player_points Current player points
   * @param $points_max Max of points per set
   * @return $array An array with two boolean values : is_match_point and winner_couple
   */
  private function get_match_point_status($game_id, $current_player_id, $current_player_points, $points_max) {
    // Get the opponent points
    $opponent_players_id = $this->get_opponent_player_id($game_id, $current_player_id);
    $opponent_player_points = $this->get_opponent_player_points($game_id, $opponent_players_id);
    // check if it's a match point
    $opponent_is_equal = FALSE;
    $current_is_biggest = TRUE;
    foreach($opponent_player_points as $opponent_points) {
      if($current_player_points == $opponent_points) {
        $opponent_is_equal = TRUE;
      }
      if($current_player_points < $opponent_points) {
        $current_is_biggest = FALSE;
      }
    }
    $array['is_match_point'] = ($current_player_points >= ($points_max-1) && $current_is_biggest && !$opponent_is_equal); // if it's a sets point
    $array['winner_couple'] = ($current_is_biggest && $opponent_is_equal); // if it's not a set point but we are in the winner couple, so we have to dismiss match_point 
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
    $old_points = json_decode(stripslashes($_GET['player_points']));
    $old_sets = json_decode(stripslashes($_GET['player_sets']));

    $result['current_points'] = $old_points+1;
    $result['current_sets'] = $old_sets+1;
   
    //$this->output->set_output(json_encode($result));
   $this->output->set_content_type('application/json')->set_output(json_encode($result));
  }
}

/* End of file players.php */
/* Location: ./application/controllers/players.php */