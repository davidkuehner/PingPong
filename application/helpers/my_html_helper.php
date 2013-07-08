<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Div tags
 *
 * Creates a div with given id and class.
 *
 * The format is <div id = "id1 idn" class = "class1 classn"> content </div>
 *
 * @access	public
 * @param	array	ids The ids of the div, in dec importance order
 * @param	array	calsses The classes of the div, in dec importance order
 * @param	string	content The inner content of the div
 * @return	string
 */
if ( ! function_exists('div'))
{
	function div($ids = NULL, $classes = NULL, $content = NULL)
	{
  
    // Opening tag
		$div = '<div ';

    if($ids != NULL)
    {
      if($ids != is_array($ids))
      {
        $ids = array($ids);
      }
      
      $div .= 'id = " ';
      $div .= implode(" ", $ids);
      $div .= ' " ';
    }
    if($classes != NULL)
    {
      if($classes != is_array($classes))
      {
        $classes = array($classes);
      }
    
      $div .= 'class = " ';
      $div .= implode(" ", $classes);
      $div .= ' " ';
    }
    
    $div .= '>';
    
    // Content
    if($content != NULL)
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
 * The format is <p id = "id1 idn" class = "class1 classn"> content </p>
 *
 * @access	public
 * @param	array	ids The ids of the p, in dec importance order
 * @param	array	calsses The classes of the p, in dec importance order
 * @param	string	content The inner content of the p
 * @return	string
 */
if ( ! function_exists('p'))
{
	function p($ids = NULL, $classes = NULL, $content = NULL)
	{
  
    // Opening tag
		$p = '<p ';

    if($ids != NULL)
    {
      if($ids != is_array($ids))
      {
        $ids = array($ids);
      }
      
      $p .= 'id = " ';
      $p .= implode(" ", $ids);
      $p .= ' " ';
    }
    if($classes != NULL)
    {
      if($classes != is_array($classes))
      {
        $classes = array($classes);
      }
    
      $p .= 'class = " ';
      $p .= implode(" ", $classes);
      $p .= ' " ';
    }
    
    $p .= '>';
    
    // Content
    if($content != NULL)
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