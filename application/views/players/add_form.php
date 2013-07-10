  <?php echo heading($title,1); ?>

  <div id="body">
    <?php 
			echo validation_errors();
	
			echo form_open('players/add_players/' . $game_id . '/' . $nb_players);
			
      for( $i = 1 ; $i <= $nb_players ; ++$i) {
        $data_title = array(
          'name' =>'player_' . $i . '_name',
          'id' =>'player_' . $i . '_name',
          'class' => 'player_name',
          'type'=>'text',
          'size' => '45',
          'value' => 'Player ' . $i,
          );
        echo '<div class = "form_item">';
          echo '<label for="player_' . $i . '_name">Player ' . $i . ' : </label>';
          echo form_input($data_title);
        echo '</div>';
      }
			echo '<div class = "form_item">';
        $class = 'class="player_submit"';
        echo form_submit('submit', "Let's play !", $class);
			echo '</div>';
      
			echo form_close();		
			?>
  </div><!-- #body -->