<?php 

/**
 * Debug offer a few tools to debug the application
 * 
 * @author David Kühner
 */
class Debug {

    /*
     * print_r the given variable in <pre> tags
     */
    public function debug_echo($var) {
      echo '<pre>' ;
      print_r($var) ;
      echo '</pre>'; 
    }
    
    /*
     * print_r the given variable in <pre> tags and die
     */
    public function debug_die($var) {
      echo '<pre>' ;
      print_r($var) ;
      echo '</pre>';
      die();
    }
}
/* End of file debug.php */
/* Location: ./application/libraries/debug.php */