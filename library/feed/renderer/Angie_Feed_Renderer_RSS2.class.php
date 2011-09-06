<?php

  /**
  * RSS 2.0 feed renderer
  * 
  * This renderer will use input feed object to render valid RSS 2.0 feed
  *
  * @package Angie.toys
  * @subpackage feed.renderers
  * @http://www.projectpier.org/
  */
  class Angie_Feed_Renderer_RSS2 extends Angie_Feed_Renderer {
  
    /**
    * Render feed
    * 
    * Render RSS 2.0 feed (spec: http://blogs.law.harvard.edu/tech/rss)
    *
    * @param Angie_Feed $feed
    * @return string
    */
    function render(Angie_Feed $feed) {
      $result  = "<rss version=\"2.0\">\n<channel>\n";
      $result .= '<title>' . clean($feed->getTitle()) . "</title>\n";
      $result .= '<link>' . clean($feed->getLink()) . "</link>\n";
      if ($description = trim($feed->getDescription())) {
        $result .= '<description>' . clean($description) . "</description>\n";
      } // if
      if ($language = trim($feed->getLanguage())) {
        $result .= '<language>' . clean($language) . "</language>\n";
      } // if
      
      foreach ($feed->getItems() as $feed_item) {
        $result .= $this->renderItem($feed_item) . "\n";
      } // foreach
      
      $result .= "</channel>\n</rss>";
      return $result;
    } // render
    
    /**
    * Render single feed item
    *
    * @param Angie_Feed_Item $item
    * @return string
    */
    private function renderItem(Angie_Feed_Item $item) {
      $result  = "<item>\n";
      $result .= '<title>' . clean($item->getTitle()) . "</title>\n";
      $result .= '<link>' . clean($item->getLink()) . "</link>\n";
      if ($description = trim($item->getDescription())) {
        $result .= '<description>' . clean($description) . "</description>\n";
      } // if
      
      $author = $item->getAuthor();
      if ($author instanceof Angie_Feed_Author) {
        $result .= '<author>' . clean($author->getEmail()) . ' (' . clean($author->getName()) . ")</author>\n";
      } // if
      
      $pubdate = $item->getPublicationDate();
      if ($pubdate instanceof DateTimeValue) {
        $result .= '<pubdate>' . $pubdate->toRSS() . "</pubdate>\n";
      } // if
      
      $result .= '</item>';
      return $result;
    } // renderItem
  
  } // Angie_Feed_Renderer_RSS2

?>
