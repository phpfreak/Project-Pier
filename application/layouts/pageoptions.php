<?php if (is_array(page_actions())) { ?>
<?php if (count(page_actions())>2) { ?>
              <ul id="page_menu">
                <li><a href="#" onclick="return null;">...</a>
                  <ul>
<?php foreach (page_actions() as $page_action) { ?>
                <li><a href="<?php echo $page_action->getURL() ?>"><?php echo clean($page_action->getTitle()) ?></a></li>
<?php } // foreach ?>
                  </ul>
                </li>
              </ul>
<?php } else { // if ?>
              <ul id="page_menu">
<?php foreach (page_actions() as $page_action) { ?>
                <li><a href="<?php echo $page_action->getURL() ?>"><?php echo clean($page_action->getTitle()) ?></a></li>
<?php } // foreach ?>
              </ul>
<?php } // if ?>
<?php } // if ?>
<?php if (is_array(view_options())) { ?>
<div id="viewToggle">
<?php foreach (view_options() as $view_option) { ?>
  <a href="<?php echo $view_option->getURL() ?>"><img src="<?php echo $view_option->getImageURL() ?>" alt="<?php echo clean($view_option->getTitle()) ?>"/></a>
<?php } // foreach ?>
</div>
<?php } // if ?>