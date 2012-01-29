<?php
  /**
  * @author Alex Mayhew 2008, Reinier van Loon 2010-2012
  * @copyright 2008-2012 projectpier.org
  * @reinier 2012 make the links stuff work
  * @reinier 2012 added content option
  */

  /**
  * Replaces wiki links in format [wiki:{PAGE_ID}] with a textile link to the page
  * 
  * @param mixed $content
  * @return
  */
  function wiki_links($content) {
    return preg_replace_callback('/\[wiki:([0-9]+)(?U:(.*))\]/', 'wiki_replace_link_callback', $content);	
    //return $content;	
  }


  /**
  * Replaces wiki links in format [wiki:{PAGE_ID}] with a textile link to the page
  * 
  * @param mixed $content
  * @return
  */
  function wiki_replace_link_callback($matches) {
    //print_r($matches);
    if(count($matches) >= 2) {
      if(is_numeric($matches[1])) {
        $object_id = $matches[1];
        $object = Wiki::instance()->findById($object_id);
        if ($object instanceof WikiPage) {
          if($matches[2]==',content') {
            $revision = $object->getLatestRevision();
            return do_textile(plugin_manager()->apply_filters('wiki_text', $revision->getContent()));
          }
          return '<a href="'.externalUrl($object->getViewUrl()).'" title="'.lang('wiki page')."($object_id)".'">'.$object->getObjectName().'</a>';
        }
      }
    }
    return '<del>'.lang('invalid reference', $matches[0]).'</del>';
  }


  /**
  * Renders select page box
  *
  * @param string $name Name to use in HTML for the select
  * @param Project $project
  * @param integer $selected Id of selected element
  * @param array $attributes Array of additional attributes
  * @return string
  */
  function wiki_select_page($name, $project, $selected = null, $attributes = null) {
    if (is_array($attributes)) {
      if (!isset($attributes['class'])) {
        $attributes['class'] = 'wiki_select_page';
      }
    } else {
      $attributes = array('class' => 'wiki_select_page');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    if (logged_user()->isAdministrator()) {
      $pages = Wiki::getAllProjectPages($project);
    } else {
      $pages = Wiki::getAllProjectPages($project);
    }

    if (is_array($pages)) {
      foreach ($pages as $page) {
        $option_attributes = $page->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($page->getObjectName(), $page->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // wiki_select_page
?>