  
  <div id="<?php echo 'player_'.$player_id?>" class="player_table clearfix">
  
  
    <?php echo heading($player_name,2); ?>
    <div class="points">
      <?php echo p('player_'.$player_id.'_points',NULL,$points_score);?>
    </div><!-- .points -->
    <div class="sets">
      <?php echo p('player_'.$player_id.'_sets',NULL,$sets_score);?>
    </div><!-- .points -->
    <div class="add_point">
      <?php
      /*echo form_open('scores/add_point/' . $player_id . '/' . $game_id);
      $class = 'class="points_submit"';
      echo form_submit('submit', '+',$class);
			echo form_close();*/
      ?>
      
      <input type="button" class="points_submit" onclick="add_point(<?php echo $player_id . ',' . $game_id ?>)" value="+" />

      
    </div><!-- .add_point -->
    <?php //echo anchor(base_url().'/index.php/scores/clear_session/'.$game_id,'debug : clear session'); ?>

  </div><!-- .player_table -->