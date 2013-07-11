$(document).ready(function(){

    // Remove context menu
  /*$(document).bind("contextmenu",function(e){
         return false;
  });

  // do action on right and left clic
  $(document).click(function(event) {
  switch (event.which) {
          case 1:
              alert('Left mouse button clicked');
              break;
          case 3:
              alert('Right mouse button clicked');
              break;
      }
  });//*/
}); 

// Add point for scores page
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
    url: base_url + "/scores/add_point",
    dataType:'json',
    cache:false,
    data: {game_id : g_id,
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

// Remove point for scores page
function rem_point(p_id,g_id) {
  // Ids construction
  plr = 'player_';
  pts = '_points';
  p_points_id = plr.concat(p_id,pts);
      
  // Business
  var p_points = document.getElementById(p_points_id).innerHTML;
  $.ajax({    
    type:'GET',
    url: base_url + "/scores/rem_point",
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