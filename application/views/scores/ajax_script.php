  <?php /*
  <div class = "ajaxTestDiv">
    <!--<div id="div1"><h2>Let jQuery AJAX Change This Text</h2></div>-->
    <div id="div2"><h2>Let jQuery AJAX Change This Text</h2></div>
    <!--<button>Get External Content</button>-->
    <a id = "link" href="#" onclick="work()">Link test</a>
  </div>
  <?php 
  $ids = array("id1","id2");
  $classes = array("c1","c2");
  echo div('mymy', 'jlasfa', p('idp','classp','hello')); ?>
  */ ?>
  <script>
    function work() {
      $.ajax({    
              type:'GET',
              url:"<?php echo site_url('scores/test'); ?>",
              dataType:'json',
              success:function(data){
                $("#div2 h2").html(data.ret1 + " " +data.ret2);
              }
          });
    }
  </script>