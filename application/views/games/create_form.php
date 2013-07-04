  <?php echo heading($title,1); ?>

  <div id="body">
    <?php 
			echo validation_errors();
	
			echo form_open('games/create_game');
      
			echo '<div class = "form_item">';
        echo '<label for="game_title">Nom de la partie : </label>';
        $data_title = array(
          'name' =>'game_title',
          'id' => 'game_title',
          'type'=>'text',
          'size' => '45',
          'value' => 'Title',
          );
        echo form_input($data_title);
			echo '</div>';
      
      echo '<div class = "form_item">';
        echo '<label for="game_set_number">Nombre de sets : </label>';
        $data_set_number = array(
          'name' =>'game_set_number',
          'id' =>'game_set_number',
          'type'=>'text',
          'size' => '2',
          'value' => '3',
          );
        echo form_input($data_set_number);
      echo '</div>';
			
			echo '<div class = "form_item">';
        echo '<label for="data_set_points">Nombre de points : </label>';
        $data_set_points = array(
          'name' =>'data_set_points',
          'id' =>'data_set_points',
          'type'=>'text',
          'size' => '2',
          'value' => '11',
          );
        echo form_input($data_set_points);
			echo '</div>';
      $class = 'class="game_submit"';
      
      echo '<div class = "form_item">';
			echo form_submit('submit', 'Create !',$class);
			echo '</div>';
      
			echo form_close();		
			?>
  </div><!-- #body -->