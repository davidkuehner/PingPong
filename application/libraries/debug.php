<?php 
class Debug {

    public function debug_echo($var) {
      echo '<pre>' ;
      print_r($var) ;
      echo '</pre>'; 
    }
    
    public function debug_die($var) {
      echo '<pre>' ;
      print_r($var) ;
      echo '</pre>';
      die();
    }
 
}
/* End of file debug.php */
/* Location: ./application/libraries/debug.php */