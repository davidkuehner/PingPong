<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Div tags
 *
 * Creates a div with given id and class.
 *
 * The format is <div id = "id" class = "class1 classn"> content </div>
 *
 * @access	public
 * @param	string id The id of the div
 * @param	array	calsses The classes of the div, in dec importance order
 * @param	string	content The inner content of the div
 * @return	string
 */
if ( ! function_exists('div'))
{
	function div($id = NULL, $classes = NULL, $content = NULL)
	{
  
    // Opening tag
		$div = '<div ';

    if($id !== NULL)
    {    
      $div .= 'id = "';
      $div .= $id;
      $div .= '" ';
    }
    if($classes !== NULL)
    {
      if($classes != is_array($classes))
      {
        $classes = array($classes);
      }
    
      $div .= 'class = "';
      $div .= implode(" ", $classes);
      $div .= '" ';
    }
    
    $div .= '>';
    
    // Content
    if($content !== NULL)
    {
      $div .= $content;
    }
   
    // Closing tag
    $div .= '</div>';
        
    return $div;
	}
}



/**
 * Div tags
 *
 * Creates a p with given id and class.
 *
 * The format is <p id = "id" class = "class1 classn"> content </p>
 *
 * @access	public
 * @param	string	id The id of the p
 * @param	array	calsses The classes of the p, in dec importance order
 * @param	string	content The inner content of the p
 * @return	string
 */
if ( ! function_exists('p'))
{
	function p($id = NULL, $classes = NULL, $content = NULL)
	{
  
    // Opening tag
		$p = '<p ';

    if($id !== NULL)
    {

      $p .= 'id = "';
      $p .= $id;
      $p .= '" ';
    }
    if($classes !== NULL)
    {
      if($classes != is_array($classes))
      {
        $classes = array($classes);
      }
    
      $p .= 'class = "';
      $p .= implode(" ", $classes);
      $p .= '" ';
    }
    
    $p .= '>';
    
    // Content
    if($content !== NULL)
    {
      $p .= $content;
    }
   
    // Closing tag
    $p .= '</p>';
        
    return $p;
	}
}

/* End of file my_html_helper.php */
/* Location: ./application/helpers/my_html_helper.php */