<?php

  /**
  * Render simple pagination (links to pages spearated with commas). Example:
  * 
  * simple_pages($pager, 'http://www.google.com?page=#PAGE#', '#PAGE#');
  *
  * @access public
  * @param DataPagination $pagination Pagination object
  * @param string $url_base Base URL where $page_placeholder will be replaced with
  *   current page number
  * @param string $page_placeholder Short string inside of $url_base witch will be
  *   replaced with current page number
  * @param string $separator String that will separate page URLs
  * @return string
  */
  function simple_pagination(DataPagination $pagination, $url_base, $page_placeholder = '#PAGE#', $separator = ', ') {
    
    $page_urls = array();
    
    for ($i = 1; $i <= $pagination->getTotalPages(); $i++) {
      if ($i == $pagination->getCurrentPage()) {
        $page_urls[] = "($i)";
      } else {
        $page_urls[] = '<a href="' . str_replace($page_placeholder, $i, $url_base) . '">' . $i . '</a>';
      } // if
    } // for
    
    return count($page_urls) ? implode($separator, $page_urls) : '';
    
  } // simple_pagination
  
  /**
  * Advanced pagination. Differenced between simple and advanced paginations is that 
  * advanced pagination uses template so its output can be changed in a great number of ways.
  * 
  * All variables are just passed to the template, nothing is done inside the function!
  *
  * @access public
  * @param DataPagination $pagination Pagination object
  * @param string $url_base Base URL in witch we will insert current page number
  * @param string $template Template that will be used. It can be absolute path to existing file
  *   or template name that used with get_template_path will return real template path
  * @param string $page_placeholder Short string inside of $url_base that will be replaced with
  *   current page numer
  * @return null
  */
  function advanced_pagination(DataPagination $pagination, $url_base, $template = 'advanced_pagination', $page_placeholder = '#PAGE#') {
    tpl_assign(array(
      'advanced_pagination_object' => $pagination,
      'advanced_pagination_url_base' => $url_base,
      'advanced_pagination_page_placeholder' => urlencode($page_placeholder)
    )); // tpl_assign
    
    $template_path = is_file($template) ? $template : get_template_path($template);
    return tpl_fetch($template_path);
  } // advanced_pagination

?>