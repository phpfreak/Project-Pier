<?php
  /**
  * @author Alex Mayhew
  * @copyright 2008
  * 2012 make the links stuff work
  */

  /**
  * Replaces wiki links in format [wiki:{PAGE_ID}] with a textile link to the page
  * 
  * @param mixed $content
  * @return
  */
  function wiki_links($content) {
    return preg_replace_callback('/\[wiki:([0-9]*)\]/', 'wiki_replace_link_callback', $content);	
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
    if(count($matches) == 2) {
      if(is_numeric($matches[1])) {
        $object_id = $matches[1];
        $object = Wiki::instance()->findById($object_id);
        if ($object instanceof WikiPage) {
          return '<a href="'.externalUrl($object->getViewUrl()).'" title="'.lang('wiki page')."($object_id)".'">'.$object->getObjectName().'</a>';
        }
      }
    }
    return '<del>'.lang('invalid reference', $matches[0]).'</del>';
  }
?>