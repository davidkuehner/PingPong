$(document).ready(function(){
  $(function(){
    $(".player_name").autocomplete({
      source:'../../suggestions', // path to the suggestions method
      minLength: 2 
    });
  });
});