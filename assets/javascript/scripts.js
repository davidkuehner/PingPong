$(document).ready(function(){


  $(function(){
    $(".player_name").autocomplete({
      source:'../../suggestions', // path to the suggestions method
      minLength: 2 
    });
  });

  // Remove context menu
  $(document).bind("contextmenu",function(e){
         return false;
  });

  // do action on right and left clic
  $(document).mousedown(function(event) {
  switch (event.which) {
          case 1:
              alert('Left mouse button pressed');
              break;
          case 3:
              alert('Right mouse button pressed');
              break;
      }
  }); 
  

});

