$(document).ready(function(){
  // Remove context menu
  $(document).bind("contextmenu",function(e){
         return false;
  });
  
  // add points to first and sec players with the mouse
  function single_click(event) {
    switch (event.which) {
        case 1:
            add_point(player_one_id,game_id);
            break;
        case 3:
            add_point(player_two_id,game_id);
            break;
      }
  }
  
  // rem points to first and sec players with the mouse
  function double_click(event) {
    switch (event.which) {
          case 1:
              rem_point(player_one_id,game_id);
              break;
          case 3:
              rem_point(player_two_id,game_id);
              break;
      }
  }

  // Mouse detection logic
  var alreadyclicked=false;
  $(document).click(function(event){
    var target = $(event.target);
    
    // if it's on link or else, do nothing
    if( target.is('a') || target.is('input') || target.is('button') ) {
      return true;
    }
  
    var el=$(this);
    if (alreadyclicked)
    {
        alreadyclicked=false; // reset
        clearTimeout(alreadyclickedTimeout); // prevent this from happening
        // do what needs to happen on double click. 
        double_click.call(el, event);
    }
    else
    {
        alreadyclicked=true;
        alreadyclickedTimeout=setTimeout(function(){
            alreadyclicked=false; // reset when it happens
            // do what needs to happen on single click. 
            single_click.call(el, event);
        },300); // <-- dblclick tolerance here
    }
    return false;
  });
  
  
  
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
      // Update points and sets
      document.getElementById(p_points_id).innerHTML = result.current_points;
      document.getElementById(p_sets_id).innerHTML = result.current_sets;
      
      // Reset points if needed
      if(result.reset_points) {
        $(".points p").text('0');
        $('.points').removeClass('match_point');
      }
      
      // Change style if it's match point
      pre = '#';
      id = pre.concat(p_points_id);
      if(result.is_match_point) {
        $('.points').removeClass('match_point');
        $(id).parent().addClass('match_point');
      }
      else {
        if(result.winner_couple) {
          $('.points').removeClass('match_point');
        }
        $(id).parent().removeClass('match_point');
      }
            
      // display the winner
      if(result.has_winner) {
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
      // Change style if it's match point
      pre = '#';
      id = pre.concat(p_points_id);
      if(result.is_match_point) {
        $('.points').removeClass('match_point');
        $(id).parent().addClass('match_point');
      }
      else {
        if(result.winner_couple) {
          $('.points').removeClass('match_point');
        }
        $(id).parent().removeClass('match_point');
      }
    }
  });
}