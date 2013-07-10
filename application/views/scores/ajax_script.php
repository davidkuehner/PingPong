<script>
  function add_point(p_id,g_id) {
  
    // Ids construction
    plr = 'player_';
    pts = '_points';
    set = '_sets';
    p_points_id = plr.concat(p_id,pts);
    p_sets_id = plr.concat(p_id,set);
        
    // Business
    var p_points = document.getElementById(p_points_id).innerHTML;
    var p_sets = document.getElementById(p_sets_id).innerHTML;
    $.ajax({    
      type:'GET',
      url:"<?php echo site_url('scores/add_point'); ?>",
      dataType:'json',
      cache:false,
      data: {
            game_id : g_id,
            player_id : p_id,
            player_points : p_points,
            player_sets : p_sets,
            },
      success:function(result){
        document.getElementById(p_points_id).innerHTML = result.current_points;
        document.getElementById(p_sets_id).innerHTML = result.current_sets;
        
        if(result.reset_points == true) {
          $(".points p").text('0');
        }
        
        if(result.has_winner == true) {
          $(".player_table").addClass('hide');
          $("#winner").removeClass('hide');
          
          des = 'The winner is :<h2>';
          end = '</h2>';
          content = des.concat(result.winner_name,end);
          
          document.getElementById('winner').innerHTML = content;
        }
        
      }
    });
  }
  
  function rem_point(p_id,g_id) {
    // Ids construction
    plr = 'player_';
    pts = '_points';
    p_points_id = plr.concat(p_id,pts);
        
    // Business
    var p_points = document.getElementById(p_points_id).innerHTML;
    $.ajax({    
      type:'GET',
      url:"<?php echo site_url('scores/rem_point'); ?>",
      dataType:'json',
      cache:false,
      data: {
            game_id : g_id,
            player_id : p_id,
            player_points : p_points,
            },
      success:function(result){
        document.getElementById(p_points_id).innerHTML = result.current_points;
      }
    });
  }
</script>