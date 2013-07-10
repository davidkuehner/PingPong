  
  <div id="<?php echo 'player_'.$player_id?>" class="player_table clearfix">
  
  
    <?php echo heading($player_name,2); ?>
    <div class="points">
      <?php echo p('player_'.$player_id.'_points',NULL,$points_score);?>
    </div><!-- .points -->
    <div class="sets">
      <?php echo p('player_'.$player_id.'_sets',NULL,$sets_score);?>
    </div><!-- .points -->
    <div class="points_submit_content">
      
      <input type="button" class="points_submit add_point" onclick="add_point(<?php echo $player_id . ',' . $game_id ?>)" value="+" />
      <input type="button" class="points_submit rem_point" onclick="rem_point(<?php echo $player_id . ',' . $game_id ?>)" value="-" />

    </div><!-- .points_submit_content -->

  </div><!-- .player_table -->