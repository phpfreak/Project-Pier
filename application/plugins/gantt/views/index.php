<?php
/**
 * @author ALBATROS INFORMATIQUE SARL CARQUEFOU - FRANCE (Damien HENRY)
 * @copyright 2011
 */

  set_page_title('Gantt');
  project_tabbed_navigation(PROJECT_TAB_GANTT);
  project_crumbs(array(
    array(lang('gantt')) 
    ));

?>

<div id="gantt-page-content" style="height:auto;width:auto;">
  <img src="<?php echo externalUrl(html_entity_decode(get_url('gantt','file')));?>">
</div>
