<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $titre; ?></title>
          <meta http-equiv="Content-Type" content="text/html" charset="<?php echo $charset; ?>" />
  <?php foreach($css as $url): ?>
          <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $url; ?>" />
  <?php endforeach; ?>
  </head>
  <body>
    <div id="container" >
      <ul id= "menu" >
        <li class = "menu_item">
          <a href="<?php echo base_url().'index.php/playerlist'; ?>">Ranking</a>
        </li>
        <li class = "menu_item">
          <a href="<?php echo base_url().'index.php/gamelist'; ?>">Game list</a>
        </li>
        <li class = "menu_item">
          <a href="<?php echo base_url(); ?>">New Game</a>
        </li>
      </ul>
      <?php echo $output; ?>
      <p class="footer"><?php echo $signature; ?></p>
    </div><!-- #container -->

  </body>
</html>