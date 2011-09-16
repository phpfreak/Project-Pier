<h4><a href="#" onclick="var s=document.getElementById('ticketsFiltersContent'); s.style.display = (s.style.display=='none'?'block':'none');"><?php echo lang('filters') ?></a></h4>
<div id="ticketsFiltersContent" <?php if (!$filtered) { echo "style='display:none'";} ?>>
  <div id="statusFilters">
    <strong><?php echo lang('status'); ?>:</strong>
    <?php
    $this->assign('properties', get_ticket_statuses());
    $this->assign('property_name', 'status');
    $this->includeTemplate(get_template_path('filter_links', 'tickets'));
    ?>
  </div>
  <div id="priorityFilters">
    <strong><?php echo lang('priority'); ?>:</strong>
    <?php
    $this->assign('properties', get_ticket_priorities());
    $this->assign('property_name', 'priority');
    $this->includeTemplate(get_template_path('filter_links', 'tickets'));
    ?>
  </div>
  <div id="typeFilters">
    <strong><?php echo lang('type'); ?>:</strong>
    <?php
    $this->assign('properties', get_ticket_types());
    $this->assign('property_name', 'type');
    $this->includeTemplate(get_template_path('filter_links', 'tickets'));
    ?>
  </div>
  <div id="categoryFilters">
    <strong><?php echo lang('category'); ?>:</strong>
    <?php
    $property_name = 'category_id';
    $property_in_url = isset($params[$property_name]) ? $params[$property_name] : "";
    
    // TODO make filter_links template more flexible so that it can be used with Categories and not only text.
    echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name=> ''))).'" '.($property_in_url == "" ? 'class="selected"' : '').'>'.lang('all').'</a> ';
    if (is_array($categories)) {
      foreach ($categories as $category) {
        $category_id = $category->getId();
        echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => $category_id))).'" '.(preg_match("/^(.*,)?$category_id(,.*)?$/", $property_in_url) ? 'class="selected"' : '').'>'.$category->getName().'</a> ';
        if (preg_match("/^(.*,)?$category_id(,.*)?$/", $property_in_url)) {
          echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => preg_replace(array("/^$category_id,/", "/,$category_id,/", "/,$category_id$/","/^$category_id$/"), array('', ',', '', ''), $property_in_url)))).'">-</a> ';
        } else {
          echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => ($property_in_url == "" ? $category_id : $property_in_url.','.$category_id)))).'">+</a> ';
        } // if
      } // foreach
    } // foreach
    ?>
  </div>
  <div id="assignedToFilters">
    <strong><?php echo lang('assigned to'); ?>:</strong>
    <?php
    $property_name = 'assigned_to_user_id';
    $property_in_url = isset($params[$property_name]) ? $params[$property_name] : "";
    
    // TODO make filter_links template more flexible so that it can be used with Users and not only text.
    echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name=> ''))).'" '.($property_in_url == "" ? 'class="selected"' : '').'>'.lang('all').'</a> ';

    foreach ($grouped_users as $company_id => $company_users) {
      $company = Companies::findById($company_id);
      echo '<strong>'.$company->getName().'</strong>: ';
      foreach ($company_users as $user) {
        $user_id = $user->getId();
        echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => $user_id))).'" '.(preg_match("/^(.*,)?$user_id(,.*)?$/", $property_in_url) ? 'class="selected"' : '').'>'.$user->getDisplayName().'</a> ';
        if (preg_match("/^(.*,)?$user_id(,.*)?$/", $property_in_url)) {
          echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => preg_replace(array("/^$user_id,/", "/,$user_id,/", "/,$user_id$/","/^$user_id$/"), array('', ',', '', ''), $property_in_url)))).'">-</a> ';
        } else {
          echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => ($property_in_url == "" ? $user_id : $property_in_url.','.$user_id)))).'">+</a> ';
        } // if
      } // foreach
    } // foreach
    ?>
  </div>
  <div id="createdByFilters">
    <strong><?php echo lang('reported by'); ?>:</strong>
    <?php
    $property_name = 'created_by_id';
    $property_in_url = isset($params[$property_name]) ? $params[$property_name] : "";
    
    // TODO make filter_links template more flexible so that it can be used with Users and not only text.
    echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name=> ''))).'" '.($property_in_url == "" ? 'class="selected"' : '').'>'.lang('all').'</a> ';

    foreach ($grouped_users as $company_id => $company_users) {
      $company = Companies::findById($company_id);
      echo '<strong>'.$company->getName().'</strong>: ';
      foreach ($company_users as $user) {
        $user_id = $user->getId();
        echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => $user_id))).'" '.(preg_match("/^(.*,)?$user_id(,.*)?$/", $property_in_url) ? 'class="selected"' : '').'>'.$user->getDisplayName().'</a> ';
        if (preg_match("/^(.*,)?$user_id(,.*)?$/", $property_in_url)) {
          echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => preg_replace(array("/^$user_id,/", "/,$user_id,/", "/,$user_id$/","/^$user_id$/"), array('', ',', '', ''), $property_in_url)))).'">-</a> ';
        } else {
          echo '<a href="'.get_url('tickets', 'index', array_merge($params, array($property_name => ($property_in_url == "" ? $user_id : $property_in_url.','.$user_id)))).'">+</a> ';
        } // if
      } // foreach
    } // foreach
    ?>
  </div>

</div><!-- // ticketsFiltersContent -->