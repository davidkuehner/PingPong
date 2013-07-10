  <?php echo heading($title,1); ?>

  <div id="body" class="clearfix">
  
  <?php 
  if($winner_name === NULL) {
    $css_class = 'hide';
  }
  else {
    $css_class = NULL;
  }
  echo div('winner',$css_class,'The winner is : ' . heading($winner_name,2)); ?><!-- #winner -->

   