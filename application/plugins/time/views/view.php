<?php

  set_page_title($time->getName());
  project_tabbed_navigation(PROJECT_TAB_TIME);
  project_crumbs(array(
    array(lang('time'), get_url('time')),
    array($time->getName())
  ));
  
?>
<div id="times">
<?php $this->includeTemplate(get_template_path('view_time', 'time')) ?>
</div>
