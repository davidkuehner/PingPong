  <?php echo heading($title,1); ?>

  <div id="body" class="clearfix">
  
  <?php 
  
  echo '<script>';
    echo "var player_one_id=$player_one_id;";
    echo "var player_two_id=$player_two_id;";
    echo "var game_id=$game_id;";
  echo '</script>';
  
  if($winner_name === NULL) {
    $css_class = 'hide';
  }
  else {
    $css_class = NULL;
  }
  echo div('winner',$css_class,'The winner is : ' . heading($winner_name,2)); ?><!-- #winner -->

   