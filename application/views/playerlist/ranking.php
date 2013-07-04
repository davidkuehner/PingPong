  <?php 
    echo '<div class="playerlist_item">';
    echo heading($player_position . ' : ' . $player_name,3);
    echo heading('Victory : '.$player_victory,4);
    echo anchor(base_url().'/index.php/playerlist/delete_player/'.$player_id,'x', 'class="delete_player"');
    echo '</div><!-- .playerlist_item -->';
  ?>