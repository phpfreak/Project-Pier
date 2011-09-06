<?php
$company = $attachment->getObject();
if (!$company) {
?>
<div class="companyAttachment">
  <fieldset>
  <legend><?php echo $attachment->getText();?></legend>
  <div class="companyLogo"><img src="<?php echo get_image_url('logo.gif'); ?>"/></div>
  <div class="companyName">&nbsp;</div>
  <div class="companyInfo">
    <div class="cardBlock">
      <?php echo lang('edit project to select company'); ?>
    </div>
  </div>
  <div class="clear"></div>
  </fieldset>
</div>
<?php
} else {
?>
<div class="companyAttachment">
  <fieldset>
  <legend><?php echo $attachment->getText();?></legend>
  <div class="icon"><img src="<?php echo $company->getLogoUrl(); ?>"/></div>
  <div class="companyName">
<?php if (!$company->isOwner() && logged_user()->isMemberOfOwnerCompany()) { ?>
    <div class="favorite <?php if ($company->isFavorite()) { echo "on"; } else { echo "off"; }?>">
<?php if (logged_user()->isAdministrator()) { ?>
      <a href="<?php echo $company->getToggleFavoriteUrl($company->getViewUrl()); ?>"><img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo lang('toggle favorite'); ?>" alt="<?php echo lang('toggle favorite'); ?>"/></a>
<?php } else { ?>
      <img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo ($company->isFavorite() ? lang('favorite') : lang('not favorite')); ?>" alt="<?php echo ($company->isFavorite() ? lang('favorite') : lang('not favorite')); ?>">
<?php } ?>
    </div>
<?php } ?>
    <a href="<?php echo $company->getCardUrl(); ?>"><?php echo $company->getName(); ?></a>
  </div>
  <div class="companyInfo">
    <div class="cardBlock">
<?php if (trim($company->getEmail()) != '') { ?>
      <div><span><?php echo lang('email address') ?>:</span> <a href="mailto:<?php echo $company->getEmail() ?>"><?php echo $company->getEmail() ?></a></div>
<?php } // if ?>
<?php if (trim($company->getPhoneNumber()) != '') { ?>
      <div><span><?php echo lang('phone number') ?>:</span> <?php echo clean($company->getPhoneNumber()) ?></div>
<?php } // if ?>
<?php if (trim($company->getFaxNumber()) != '') { ?>
      <div><span><?php echo lang('fax number') ?>:</span> <?php echo clean($company->getFaxNumber()) ?></div>
<?php } // if ?>
<?php if ($company->hasHomepage()) { ?>
      <div><span><?php echo lang('homepage') ?>:</span> <a href="<?php echo $company->getHomepage() ?>"><?php echo $company->getHomepage() ?></a></div>
<?php } // if ?>
<?php if ($company->hasAddress()) { ?>
      <div>
        <span><?php echo lang('address') ?>:</span><br/>
        <?php echo $company->getAddress().', '.$company->getAddress2(); ?><br/>
        <?php echo $company->getCity().', '.$company->getState().' '.$company->getZipcode(); ?>
      </div>
<?php } // if ?>
    </div>
  </div>
  <div class="clear"></div>
  </fieldset>
</div>
<?php } // if ?>