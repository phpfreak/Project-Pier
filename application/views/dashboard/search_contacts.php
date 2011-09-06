<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('search results for', $search_term));
  dashboard_tabbed_navigation(DASHBOARD_TAB_CONTACTS);
  dashboard_crumbs(array(
    array(lang('contacts'), get_url('dashboard', 'contacts')),
    lang('search results')));
  
  if (logged_user()->isAdministrator(owner_company())) {
    add_page_action(lang('add company'), get_url('company', 'add_client'));
    add_page_action(lang('add contact'), get_url('contacts', 'add'));
  }
?>
<?php add_stylesheet_to_page('dashboard/contact_list.css') ?>
<?php if (is_array($contacts) && count($contacts)) { ?>
<div id="contactsList">
  <div id="contactsPaginationTop"><?php echo advanced_pagination($contacts_pagination, get_url('dashboard', 'search_contacts', array('search_for' => $search_term, 'page' => '#PAGE#'))) ?></div>

<?php
$counter = 0;
if (is_array($contacts)) {
  foreach ($contacts as $contact) {
    $counter++;
    $company = $contact->getCompany();
?>
  <div class="listedContact <?php echo $counter%2 ? 'even' : 'odd' ?>">
    <div class="contactAvatar"><img src="<?php echo $contact->getAvatarUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> <?php echo lang('avatar') ?>" /></div>
  <?php if (logged_user()->isMemberOfOwnerCompany() && !$contact->isMemberOfOwnerCompany()) { ?>
    <div class="contactFavorite <?php if ($contact->isFavorite()) { echo "favorite_on"; } else { echo "favorite_off"; }?>">
  <?php if (logged_user()->isAdministrator()) { ?>
      <a href="<?php echo $contact->getToggleFavoriteUrl($contact->getCompany()->getViewUrl()); ?>"><img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo lang('toggle favorite'); ?>" alt="<?php echo lang('toggle favorite'); ?>"/></a>
  <?php } else { ?>
      <img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>" alt="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>">
  <?php } // if ?>
    </div>
  <?php } // if ?>
    <div class="contactName"><a href="<?php echo $contact->getCardUrl() ?>"><?php echo highlight($search_term, clean($contact->getDisplayName())) ?></a><?php if ($contact->getTitle() != '') echo " &mdash; ".highlight($search_term, clean($contact->getTitle())) ?> @ <a href="<?php echo $company->getCardUrl(); ?>"><?php echo $company->getName(); ?></a></div>
    <div class="contactDetails">
      <div class="contactInfo">
  <?php if (trim($contact->getEmail()) != '') { ?>
        <div><span><?php echo lang('email address') ?>:</span> <a href="mailto:<?php echo $contact->getEmail() ?>"><?php echo highlight($search_term, $contact->getEmail()) ?></a></div>
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
  <?php if ($company->hasAddress()) { ?>
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
<?php } // if ?>
  <div id="contactsPaginationBottom"><?php echo advanced_pagination($contacts_pagination, get_url('dashboard', 'search_contacts', array('search_for' => $search_term, 'page' => '#PAGE#'))) ?></div>
</div>
<?php } else { ?>
  <div><?php echo lang('no search result for', $search_term) ?></div>
<?php } // if ?>