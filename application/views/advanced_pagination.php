<?php 
if (isset($advanced_pagination_object) && ($advanced_pagination_object instanceof DataPagination ) && isset($advanced_pagination_url_base) && isset($advanced_pagination_page_placeholder)) {

  $advanced_pagination_urls = array(lang('pagination page')); 
  if (!$advanced_pagination_object->isFirst()) {
    $advanced_pagination_urls[] = '<a href="' . str_replace($advanced_pagination_page_placeholder, 1, $advanced_pagination_url_base) . '" title="' . lang('pagination first') . '">&lt;&lt;</a>';
    $advanced_pagination_urls[] = '<a href="' . str_replace($advanced_pagination_page_placeholder, $advanced_pagination_object->getPrevious(), $advanced_pagination_url_base) . '" title="' . lang('pagination previous') . '">&lt;</a>';
  } // if
  
  if ($advanced_pagination_object->getCurrentPage() - 3 > 0) {
    $advanced_pagination_urls[] = '...';
  } // if
  
  for ($i = 1; $i <= $advanced_pagination_object->getTotalPages(); $i++) {
    
    // We have more than 7 pages. Do some tricks
    if ($advanced_pagination_object->getTotalPages() > 7) {
      
      // In range of (current - 3 .. current + 3)
      if (($i > $advanced_pagination_object->getCurrentPage() - 3) && ($i < $advanced_pagination_object->getCurrentPage() + 3)) {
      
        // Current...
        if ($i == $advanced_pagination_object->getCurrentPage()) {
          
          $advanced_pagination_urls[] = "\n" . '<select onchange="location = this.value">';
          for ($j = 1; $j <= $advanced_pagination_object->getTotalPages(); $j++) {
            
            if ($j == $advanced_pagination_object->getCurrentPage()) {
              $advanced_pagination_urls[count($advanced_pagination_urls) - 1] .= "\n" . '<option value="' . str_replace($advanced_pagination_page_placeholder, $j, $advanced_pagination_url_base) . '" selected="selected">' . "$j</option>";
            } else {
              $advanced_pagination_urls[count($advanced_pagination_urls) - 1] .= "\n" . '<option value="' . str_replace($advanced_pagination_page_placeholder, $j, $advanced_pagination_url_base) . '">' . "$j</option>";
            } // if
          } // for
          $advanced_pagination_urls[count($advanced_pagination_urls) - 1] .= "\n" . '</select>';
          
        // Not current...
        } else {
          $advanced_pagination_urls[] = '<a href="' . str_replace($advanced_pagination_page_placeholder, $i, $advanced_pagination_url_base) . '">' . $i . '</a>';
        } // if
      
      } // if
      
    // We have less than 7 pages, list them all
    } else {
      if ($i == $advanced_pagination_object->getCurrentPage()) {
        $advanced_pagination_urls[] = "($i)";
      } else {
        $advanced_pagination_urls[] = '<a href="' . str_replace($advanced_pagination_page_placeholder, $i, $advanced_pagination_url_base) . '">' . $i . '</a>';
      } // if
    } // if
    
  } // for
  
  if ($advanced_pagination_object->getCurrentPage() + 3 < $advanced_pagination_object->getTotalPages()) {
    $advanced_pagination_urls[] = '...';
  }
  
  if (!$advanced_pagination_object->isLast()) {
    $advanced_pagination_urls[] = '<a href="' . str_replace($advanced_pagination_page_placeholder, $advanced_pagination_object->getNext(), $advanced_pagination_url_base) . '" title="' . lang('pagination next') . '">&gt;</a>';
    $advanced_pagination_urls[] = '<a href="' . str_replace($advanced_pagination_page_placeholder, $advanced_pagination_object->getTotalPages(), $advanced_pagination_url_base) . '" title="' . lang('pagination last') . '">&gt;&gt;</a>';
  } // if
  
  echo '<div class="advancedPagination">';
  foreach ($advanced_pagination_urls as $advanced_pagination_url) {
    echo "<span>$advanced_pagination_url</span>&nbsp;";
  } // foreach 
  echo '</div>';
} // if 
?>