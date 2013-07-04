  
  <div class="player_table clearfix">
    <?php echo heading($player_name,2); ?>
    <div class="points">
      <p><?php echo $points_score; ?></p>
    </div><!-- .points -->
    <div class="sets">
      <p><?php echo $sets_score; ?></p>
    </div><!-- .points -->
    <div class="add_point">
      <?php
      echo form_open('scores/add_point/' . $player_id . '/' . $game_id);
      $class = 'class="points_submit"';
      echo form_submit('submit', '+',$class);
			echo form_close();
      ?>
    </div><!-- .add_point -->
      <?php echo anchor(base_url().'/index.php/scores/clear_session/'.$game_id,'debug : clear session'); ?>

  </div><!-- .player_table -->