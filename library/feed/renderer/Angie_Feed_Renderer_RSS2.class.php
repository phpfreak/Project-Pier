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
      $result  = "<rss version=\"2.0\">\n";
      //$result  = "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
      $result .= "<channel>\n";
      $feed_url = externalUrl(clean($feed->getLink()));
      //$result .= "<atom:link href=\"$feed_url\" rel=\"self\" type=\"application/rss+xml\" />\n";
      $result .= '<title>' . clean($feed->getTitle()) . "</title>\n";
      $result .= '<link>' . $feed_url . "</link>\n";
      if ($description = trim($feed->getDescription())) {
        $description = "empty";
      } // if
      $result .= '<description>' . clean($description) . "</description>\n";
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
      $link = externalUrl(clean($item->getLink()));
      $result .= '<link>' . $link . "</link>\n";
      //$result .= '<guid>' . $link . "</guid>\n";
      if ($description = trim($item->getDescription())) {
        $description = "empty";
      } // if
      $result .= '<description>' . clean($description) . "</description>\n";
      
      $author = $item->getAuthor();
      if ($author instanceof Angie_Feed_Author) {
        $result .= '<author>' . clean($author->getEmail()) . ' (' . clean($author->getName()) . ")</author>\n";
      } // if
      
      $timestamp = NULL;
      $pubdate = $item->getPublicationDate();
      if ($pubdate instanceof DateTimeValue) {
        $result .= '<pubDate>' . $pubdate->toRSS() . "</pubDate>\n";
        $timestamp = $pubdate->getTimestamp();
      } // if
      $result .= '<guid>' . $this->buildGuid(clean($item->getLink()), $timestamp) . "</guid>\n";
      
      $result .= '</item>';
      return $result;
    } // renderItem

    /**
    * Create a guid
    *
    * @param string $url
    * @param int $timestamp
    * @return string
    */
    private function buildGuid($url, $timestamp) {
      $url = preg_replace('/&amp;\d*&amp;/', '&amp;', $url); // remove non-constant parameter
      if (!is_null($timestamp)) $url .= "&amp;time_id=" . $timestamp;
      return $url;
    }
  
  } // Angie_Feed_Renderer_RSS2

?>