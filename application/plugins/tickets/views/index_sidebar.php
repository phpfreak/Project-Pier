<?php $this->includeTemplate(get_template_path('tickets_sidebar', 'tickets')) ?>
<div class="sidebarBlock" id="tickets_legend">
  <h2><?php echo lang('legend'); ?></h2>
  <div class="blockContent">
  <ul>
  <?php
        $priors = array('critical', 'major', 'minor', 'trivial');
        foreach($priors as $priority) {
          print "<li class='legend $priority'><A href='".ProjectTickets::getIndexUrl()."&priority=".lang($priority)."'>".lang($priority)."</a></li>";
        }
        $types = array('defect', 'enhancement', 'feature request');
        foreach($types as $type) {
          print "<li class='legend $type'><A href='".ProjectTickets::getIndexUrl()."&type=".urlencode($type)."'>".lang($type)."</a></li>";
        }
        $project = active_project();
        if ($project) {
          $categories = ProjectCategories::getProjectCategories($project);
          if ($project) {
            foreach($categories as $category) {
              print "<li class='legend category'><A href='".ProjectTickets::getIndexUrl()."&category=".($category->getId())."'>".($category->getName())."</a></li>";
            }
          }
        }
    ?>
  </ul>
  </div>
</div>
