  <?php 
    echo '<div class="gamelist_item">';
    echo heading($game_title,3);
    if($is_finish) {
      echo heading('Winner : '.$winner_name,4);
    }
    else {
      echo heading(anchor(base_url().'/index.php/scores/index/'.$game_id,$winner_name),4);
    }
    echo anchor(base_url().'/index.php/gamelist/delete_game/'.$game_id,'x', 'class="delete_game"');
    echo '</div><!-- .player_table -->';
  ?>