<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layout {
    private $CI;
    private $var = array();
    private $theme = 'default';
/*
|===============================================================================
| Constructeur
|===============================================================================
*/
    public function __construct() {
        $this->CI = get_instance();

        $this->var['output'] = '';
        
        $this->var['titre'] = 'Ping pong';//ucfirst($this->CI->router->fetch_method()) . ' - ' . ucfirst($this->Ci->router->fetch_method());
        $this->var['charset'] = $this->CI->config->item('charset');
        $this->var['css'] = array();
        $this->var['js'] = array();
    }
/*
|===============================================================================
| Méthodes pour charger les vues
|   . view
|   . views
|===============================================================================
*/
    public function view($name, $data = array()) {
         $this->var['output'] .= $this->CI->load->view($name, $data, TRUE);
         $this->CI->load->view('../themes/' . $this->theme, $this->var);
    }
    
    public function views($name, $data = array()) {
        $this->var['output'] .= $this->CI->load->view($name, $data, TRUE);
        return $this;
    }
/*
|===============================================================================
| Méthodes pour modifier les variables envoyées au layout
|   . set_titre
|   . set_charset
|   . set_theme
|===============================================================================
*/
    public function set_titre($titre) {
      if(is_string($titre) && !empty($titre)) {
        $this->var['titre'] = $titre;
        return TRUE;
      }
      return FALSE;
    }
    
    public function set_charset($charset) {
      if(is_string($charset) && !empty($charset)) {
        $this->var['charset'] = $charset;
        return TRUE;
      }
      return FALSE;
    }
    
    public function set_theme($theme) {
      if(is_string($theme) && !empty($theme) && file_exists('./application/theme/' . $theme . '.php')) {
        $this->theme = $theme;
        return TRUE;
      }
      return FALSE;
    }
/*
|===============================================================================
| Méthodes pour ajouter des feuilles de CSS et de JavaScript
|   . ajouter_css
|   . ajouter_js
|===============================================================================
*/
    public function ajouter_css($nom) {
      if(is_string($nom) && !empty($nom) && file_exists('./assets/css/' . $nom . '.css')) {
        $this->var['css'][] = $this->css_url($nom);
        return TRUE;
      }
      return FALSE;
    }
    
    public function ajouter_js($nom) {
      if(is_string($nom) && !empty($nom) && file_exists('./assets/javascript/' . $nom . '.js')) {
        $this->var['js'][] = $this->js_url($nom);
        return TRUE;
      }
      return FALSE;
    }
    
    private function css_url($nom) {
      return base_url() . 'assets/css/' . $nom . '.css';
    }
    
    private function js_url($nom) {
      return base_url() . 'assets/javascript/' . $nom . '.js';
    }
    
    private function debug($var) {
      echo '<pre>' ;
      print_r($var) ;
      echo '</pre>'; 
      die();
    }
}
/* End of file layout.php */
/* Location: ./application/libraries/layout.php */