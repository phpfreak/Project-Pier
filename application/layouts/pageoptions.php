<?php $page_actions = page_actions() ?>
<?php if (is_array($page_actions)) { ?>
<?php // latest logic: 1 element -> show, 2 elements -> show, 3 elements or more -> show first, rest in dropdown ?>
<?php // end effect: max. 2 buttons on page, dropdown has min. 2 elements ?>
<?php $page_actions_count = count($page_actions); ?>
              <ul id="page_menu">
                <li><a href="<?php echo $page_actions[0]->getURL() ?>"><?php echo clean($page_actions[0]->getTitle()) ?></a></li>
<?php if ($page_actions_count==2) { ?>
                <li><a href="<?php echo $page_actions[1]->getURL() ?>"><?php echo clean($page_actions[1]->getTitle()) ?></a></li>
<?php } // if ?>
<?php if ($page_actions_count>2) { ?>
                <li class="align-right"><a href="#" onclick="return null;"><?php echo count($page_actions)-1 ?></a>
                  <ul>
<?php for($i=1; $i<$page_actions_count; $i++) { ?>
                <li><a href="<?php echo $page_actions[$i]->getURL() ?>"><?php echo clean($page_actions[$i]->getTitle()) ?></a></li>
<?php } // for ?>
                  </ul>
                </li>
<?php } // if ?>
              </ul>
<?php } // if ?>
<?php if (is_array(view_options())) { ?>
<div id="viewToggle">
<?php foreach (view_options() as $view_option) { ?>
  <a href="<?php echo $view_option->getURL() ?>"><img src="<?php echo $view_option->getImageURL() ?>" alt="<?php echo clean($view_option->getTitle()) ?>"/></a>
<?php } // foreach ?>
</div>
<?php } // if ?>