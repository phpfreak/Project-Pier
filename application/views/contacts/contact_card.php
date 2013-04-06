<?php if (isset($contact) && ($contact instanceof Contact)) { ?>
<div class="block">
  <div class="icon"><img src="<?php echo $contact->getAvatarUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> avatar" /></div>
  <div class="header">
<?php if (logged_user()->isMemberOfOwnerCompany() && !$contact->isMemberOfOwnerCompany()) { ?>
      <div class="favorite <?php if ($contact->isFavorite()) { echo "on"; } else { echo "off"; }?>">
<?php if (logged_user()->isAdministrator()) { ?>
        <a href="<?php echo $contact->getToggleFavoriteUrl($contact->getCardUrl()); ?>"><img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo lang('toggle favorite'); ?>" alt="<?php echo lang('toggle favorite'); ?>"/></a>
<?php } else { ?>
        <img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>" alt="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>">
<?php } ?>
      </div>
<?php } ?>
    <h2><?php echo clean($contact->getDisplayName()) ?></h2>
    
    <div class="content">
      <div><?php if ($contact->getTitle()) { ?><span><?php echo lang('contact title') ?>:</span> <?php echo clean($contact->getTitle()); } ?></div>
      <div><span><?php echo lang('company') ?>:</span> <a href="<?php echo $contact->getCompany()->getCardUrl() ?>"><?php echo clean($contact->getCompany()->getName()) ?></a></div>
    </div>
<?php if ( logged_user()->isMemberOfOwnerCompany() || ($contact->getCompanyId() == logged_user()->getCompanyId()) ) { ?>
    <h2><?php echo lang('contact online') ?></h2>
    
    <div class="cardBlock">
      <div><?php if ($contact->getEmail()) { ?><span><?php echo lang('email address'); ?>:</span> <a href="mailto:<?php echo clean($contact->getEmail()); ?>"><?php echo clean($contact->getEmail()); ?></a><?php } ?></div>
      
<?php if (is_array($im_values = $contact->getImValues()) && count($im_values)) { ?>
      <table class="imAddresses">
<?php foreach ($im_values as $im_value) { ?>
<?php if ($im_type = $im_value->getImType()) { ?>
        <tr>
          <td><img src="<?php echo $im_type->getIconUrl() ?>" alt="<?php echo $im_type->getName() ?>" /></td>
          <td><?php echo clean($im_value->getValue()) ?> <?php if ($im_value->getIsDefault()) { ?><span class="desc">(<?php echo lang('primary im service') ?>)</span><?php } ?></td>
        </tr>
<?php } // if ?>
<?php } // foreach ?>
      </table>
<?php } // if ?>
    </div>

<?php if ($contact->getOfficeNumber() . $contact->getFaxNumber() . $contact->getMobileNumber() . $contact->getHomeNumber()) { ?>    
    <h2><?php echo lang('contact offline') ?></h2>
    
    <div class="cardBlock">
      <div><span><?php if ($contact->getOfficeNumber()) { echo lang('office phone number') ?>:</span> <?php echo clean($contact->getOfficeNumber()); } ?></div>
      <div><span><?php if ($contact->getFaxNumber()) { echo lang('fax number') ?>:</span> <?php echo clean($contact->getFaxNumber()); } ?></div>
      <div><span><?php if ($contact->getMobileNumber()) { echo lang('mobile phone number') ?>:</span> <?php echo clean($contact->getMobileNumber()); } ?></div>
      <div><span><?php if ($contact->getHomeNumber()) { echo lang('home phone number') ?>:</span> <?php echo clean($contact->getHomeNumber()); } ?></div>
    </div>
<?php } ?>
<?php $tags = $contact->getTags(); ?>
<?php if (is_array($tags) && count($tags)) { ?>
    <h2><?php echo lang('tags'); ?></h2>
    <div class="contactTags">
<?php foreach ($tags as $tag) { ?>
      <span><a href="<?php echo get_url('dashboard', 'search_by_tag', array('tag' => $tag->getTag())); ?>"><?php echo $tag->getTag();?></a></span>
<?php } // foreach ?>
    </div>
<?php } // if ?>
<?php } // if ?>
  </div>
</div>
<?php } // if ?>