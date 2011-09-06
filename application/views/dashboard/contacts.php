<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('contacts'));
  dashboard_tabbed_navigation(DASHBOARD_TAB_CONTACTS);
  dashboard_crumbs(lang('contacts'));
  
  if (logged_user()->isAdministrator(owner_company())) {
    add_page_action(lang('add company'), get_url('company', 'add_client'));
    add_page_action(lang('add contact'), get_url('contacts', 'add'));
  }
?>
<?php add_stylesheet_to_page('admin/contact_list.css') ?>
  <div id="viewToggle">
    <a href="<?php echo get_url('dashboard', 'contacts', array('view'=>'list', 'page' => $contacts_pagination->getCurrentPage())); ?>"><img src="<?php if ($view_type=="list") { echo get_image_url("icons/list_on.png"); } else { echo get_image_url("icons/list_off.png"); } ?>" title="<?php echo lang('list view'); ?>" alt="<?php echo lang('list view'); ?>"/></a>
    <a href="<?php echo get_url('dashboard', 'contacts', array('view'=>'detail', 'page' => $contacts_pagination->getCurrentPage())); ?>"><img src="<?php if ($view_type=="detail") { echo get_image_url("icons/excerpt_on.png"); } else { echo get_image_url("icons/excerpt_off.png"); } ?>" title="<?php echo lang('detail view'); ?>" alt="<?php echo lang('detail view'); ?>"/></a>
  </div>
<div id="contactsList">
  <div id="alphabet">
    <span class="letter">
<?php if ($initial == "") { ?>
      <strong><?php echo lang('all'); ?></strong>
<?php } else { ?>
      <a href="<?php echo get_url('dashboard', 'contacts'); ?>"><?php echo lang('all'); ?></a>
<?php } // if ?>
    </span>
    <span class="letter">
<?php if ($initial == "_") { ?>
      <strong>#</strong>
<?php } elseif (in_array("_", $initials)) { ?>
      <a href="<?php echo get_url('dashboard', 'contacts', array('initial' => '_')); ?>">#</a>
<?php } else { ?>
      <span class="disabled">#</span>
<?php } // if ?>
    </span>
<?php foreach (range('A', 'Z') as $letter) { ?>
      <span class="letter">
<?php if ($initial == $letter) { ?>
        <strong><?php echo $letter; ?></strong>
<?php } elseif (in_array($letter, $initials)) { ?>
        <a href="<?php echo get_url('dashboard', 'contacts', array('initial' => $letter)); ?>"><?php echo $letter; ?></a>
<?php } else { ?>
        <span class="disabled"><?php echo $letter; ?></span>
<?php } // if ?>
      </span>
    <?php } // foreach ?>
  </div>
  <div id="top"><?php echo advanced_pagination($contacts_pagination, get_url('dashboard', 'contacts', (trim($initial) == '' ? array('page'=> '#PAGE#') : array('page' => '#PAGE#', 'initial' => $initial)))) ?></div>

<?php
$counter = 0;
if (is_array($contacts)) {
  if ($view_type == 'detail') {
    foreach ($contacts as $contact) {
      $counter++;
      $company = $contact->getCompany();
?>
  <div class="listedContact <?php echo $counter%2 ? 'even' : 'odd' ?>">
    <div class="icon"><img src="<?php echo $contact->getAvatarUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> <?php echo lang('avatar') ?>" /></div>
  <?php if (logged_user()->isMemberOfOwnerCompany() && !$contact->isMemberOfOwnerCompany()) { ?>
    <div class="favorite <?php if ($contact->isFavorite()) { echo "on"; } else { echo "off"; }?>">
  <?php if (logged_user()->isAdministrator()) { ?>
    <?php if ($contact->getCompany()) { ?>
      <a href="<?php echo $contact->getToggleFavoriteUrl($contact->getCompany()->getViewUrl()); ?>"><img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo lang('toggle favorite'); ?>" alt="<?php echo lang('toggle favorite'); ?>"/></a>
  <?php } // if ?>
  <?php } else { ?>
      <img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>" alt="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>">
  <?php } // if ?>
    </div>
  <?php } // if ?>
    <div class="name"><a href="<?php echo $contact->getCardUrl() ?>"><?php echo clean($contact->getDisplayName()) ?></a><?php if ($contact->getTitle() != '') echo " &mdash; ".clean($contact->getTitle()) ?> <?php if ($contact->getCompany()) { ?> @ <a href="<?php echo $company->getCardUrl(); ?>"><?php echo $company->getName(); ?></a>   <?php } // if ?> </div>
    <div class="contactDetails">
      <div class="contactInfo">
  <?php if (trim($contact->getEmail()) != '') { ?>
        <div><span><?php echo lang('email address') ?>:</span> <a href="mailto:<?php echo $contact->getEmail() ?>"><?php echo $contact->getEmail() ?></a></div>
  <?php } // if ?>
  <?php if (trim($contact->getOfficeNumber()) != '') { ?>
        <div><span><?php echo lang('office phone number') ?>:</span> <?php echo clean($contact->getOfficeNumber()) ?></div>
  <?php } // if ?>
  <?php if (trim($contact->getFaxNumber()) != '') { ?>
        <div><span><?php echo lang('fax number') ?>:</span> <?php echo clean($contact->getFaxNumber()) ?></div>
  <?php } // if ?>
  <?php if (trim($contact->getMobileNumber()) != '') { ?>
        <div><span><?php echo lang('mobile phone number') ?>:</span> <?php echo clean($contact->getMobileNumber()) ?></div>
  <?php } // if ?>
  <?php if (trim($contact->getHomeNumber()) != '') { ?>
        <div><span><?php echo lang('home phone number') ?>:</span> <?php echo clean($contact->getHomeNumber()) ?></div>
  <?php } // if ?>
      </div>
  <?php if ($company && $company->hasAddress()) { ?>
      <div class="companyInfo">
        <span><?php echo lang('address') ?>:</span><br/>
        <?php echo $company->getAddress().', '.$company->getAddress2(); ?><br/>
        <?php echo $company->getCity().', '.$company->getState().' '.$company->getZipcode(); ?>
      </div>
  <?php } // if ?>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
<?php } // foreach ?>
<?php } else { ?>
  <table id="contactsTable">
    <tr>
      <th><?php echo lang('name'); ?></th>
      <th><?php echo lang('email address'); ?></th>
      <th><?php echo lang('office phone number'); ?></th>
      <th><?php echo lang('fax number'); ?></th>
      <th><?php echo lang('mobile phone number'); ?></th>
      <th><?php echo lang('home phone number'); ?></th>
    </tr>
      
<?php
  foreach ($contacts as $contact) {
    $counter++;
    $company = $contact->getCompany();
  ?>
  <tr class="<?php echo $counter%2 ? 'even':'odd'?>">
    <td width="30%"><strong><a href="<?php echo $contact->getCardUrl() ?>"><?php echo clean($contact->getDisplayName()) ?></a></strong> <?php if ($contact->getCompany()) { ?> @ <a href="<?php echo $company->getCardUrl(); ?>"><?php echo $company->getName(); ?></a> <?php } // if ?> </td>
    <td width="30%"><?php if (trim($contact->getEmail()) != '') { ?>
      <a href="mailto:<?php echo $contact->getEmail()?>"><?php echo $contact->getEmail() ?></a>
      <?php } // if ?>
    </td>
    <td width="10%">
      <?php if (trim($contact->getOfficeNumber()) != '') { ?>
        <?php echo clean($contact->getOfficeNumber()) ?>
      <?php } // if ?>
    </td>
    <td width="10%">
      <?php if (trim($contact->getFaxNumber()) != '') { ?>
        <?php echo clean($contact->getFaxNumber()) ?>
      <?php } // if ?>
    </td>
    <td width="10%">
      <?php if (trim($contact->getMobileNumber()) != '') { ?>
        <?php echo clean($contact->getMobileNumber()) ?>
      <?php } // if ?>
    </td>
    <td width="10%">
      <?php if (trim($contact->getHomeNumber()) != '') { ?>
        <?php echo clean($contact->getHomeNumber()) ?>
      <?php } // if ?>
    </td>
  </tr>
<?php } // foreach ?>
  </table>
<?php } // if ?>
<?php } // if ?>
  <div id="bottom"><?php echo advanced_pagination($contacts_pagination, get_url('dashboard', 'contacts', (trim($initial) == '' ? array('page'=> '#PAGE#') : array('page' => '#PAGE#', 'initial' => $initial)))) ?></div>
</div>