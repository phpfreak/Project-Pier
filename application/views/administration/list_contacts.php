<?php add_stylesheet_to_page('admin/contact_list.css') ?>
<?php if (isset($contacts) && is_array($contacts) && count($contacts)) { ?>
<div id="contactsList">
<?php $counter = 0; ?>
<?php foreach ($contacts as $contact) { ?>
<?php
$counter++;
$user = $contact->getUserAccount();
?>
  <div class="listedContact <?php echo $counter % 2 ? 'even' : 'odd' ?>">
    <div class="icon"><img src="<?php echo $contact->getAvatarUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> <?php echo lang('avatar') ?>" /></div>
    <div class="details">
<?php if (logged_user()->isMemberOfOwnerCompany() && !$contact->isMemberOfOwnerCompany()) { ?>
      <div class="favorite <?php if ($contact->isFavorite()) { echo "on"; } else { echo "off"; }?>">
<?php if (logged_user()->isAdministrator()) { ?>
        <a href="<?php echo $contact->getToggleFavoriteUrl($contact->getCompany()->getViewUrl()); ?>"><img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo lang('toggle favorite'); ?>" alt="<?php echo lang('toggle favorite'); ?>"/></a>
<?php } else { ?>
        <img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>" alt="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>">
<?php } // if ?>
      </div>
<?php } // if ?>
      <span class="name"><a href="<?php echo $contact->getCardUrl() ?>"><?php echo clean($contact->getDisplayName()) ?></a><?php if ($contact->getTitle() != '') echo " &dash; ".clean($contact->getTitle()) ?></span><?php ?>
<?php if ($contact->hasUserAccount()) { ?><?php ?>
<span class="userLink">, <?php echo lang('user') ?> <a href="<?php echo $user->getCardUrl() ?>"><?php echo clean($user->getDisplayName()) ?></a></span><?php ?>
<?php } // if  ?>
<?php
  $options = array();
  if (logged_user()->isMemberOfOwnerCompany()) {
    $options[] = '<a href="' . $contact->getReserveParkingSpaceUrl() . '">' . lang('reserve parking space') . '</a>';
    $options[] = '<a href="' . $contact->getShowMapUrl() . '">' . lang('show map') . '</a>';
    $options[] = '<a href="' . logged_user()->getContact()->getShowRouteUrl($contact) . '">' . lang('show route') . '</a>';
  }
  if ($contact->canEdit(logged_user())) {
    $options[] = '<a href="' . $contact->getEditUrl() . '">' . lang('edit') . '</a>';
  }
  if ($contact->canDelete(logged_user())) {
    $options[] = '<a href="' . $contact->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
  if (!$contact->hasUserAccount()) {
    if ($contact->canAddUserAccount(logged_user())) {
      $options[] = '<a href="' . $contact->getAddUserAccountUrl() . '">' . lang('add user account') . '</a>';
    }
  }
?>
      <div class="options"><?php echo implode(' | ', $options) ?></div>
      <div class="clear"></div>
    </div>
  </div>  
<?php } // foreach ?>
</div>

<?php } else { ?>
<p><?php echo lang('no contacts in company') ?></p>
<?php } // if ?>