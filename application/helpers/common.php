<?php

  /**
  * Return image URL
  *
  * @access public
  * @param string $filename Filename or path relative to images dir
  * @return string
  */
  function image_url($filename) {
    return get_image_url($filename);
  } // image_url
  
  /**
  * Return URL of specific icon
  *
  * @access public
  * @param string $filename Icon filename or file path relative to icons dir
  * @return string
  */
  function icon_url($filename) {
    return image_url("icons/$filename");
  } // icon_url
  
  /**
  * Render icon IMG tag
  *
  * @access public
  * @param string $filename Icon filename
  * @param string $alt Value of alt attrbute for IMG
  * @param array $attributes Array of additional attributes
  * @return string
  */
  function render_icon($filename, $alt = '', $attributes = null) {
    if (is_array($attributes)) {
      $attributes['src'] = icon_url($filename);
      $attributes['alt'] = $alt;
    } else {
      $attributes = array(
        'src' => icon_url($filename),
        'alt' => $alt
      ); // array
    } // if
    return open_html_tag('img', $attributes, true);
  } // render_icon

  /**
  * Highlight pattern in a word
  *
  * @access public
  * @param string $pattern to match
  * @param string $subject in which to change the pattern
  * @return string modified string
  */
  function highlight($pattern, $subject) {
    return preg_replace('/('.$pattern.')/i', '<span class="highlight">\1</span>', $subject);
  } // highlight
  
  /**
  * Use widget
  *
  * @access public
  * @param string $widget_name
  * @return void
  */
  function use_widget($widget_name) {
    if (function_exists('add_javascript_to_page') && function_exists('add_stylesheet_to_page')) {
      add_javascript_to_page("widgets/$widget_name/widget.js");
      add_stylesheet_to_page(get_javascript_url("widgets/$widget_name/widget.css"));
    } // if
  } // use_widget
  
  /**
  * Return checkbox link
  *
  * @access public
  * @param string $link
  * @param boolean $checked
  * @param string $hint
  * @return string
  */
  function checkbox_link($link, $checked = false, $hint = null) {
    $title_attribute = is_null($hint) ? '' : 'title="' . clean($hint) . '"';
    $icon_url = $checked ? icon_url('checked.jpg') : icon_url('not-checked.jpg');
    return "<a href=\"$link\" class=\"checkboxLink\" $title_attribute><img src=\"$icon_url\" alt=\"\" /></a>";
  } // checkbox_link

?>