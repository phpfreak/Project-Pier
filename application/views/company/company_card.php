<?php if (isset($company) && ($company instanceof Company)) { ?>
<div class="card">
  <div class="icon"><img src="<?php echo $company->getLogoUrl() ?>" alt="<?php echo clean($company->getName()) ?> logo" /></div>
  <div class="cardData">
<?php if (logged_user()->isMemberOfOwnerCompany() && !$company->isOwner()) { ?>
    <div class="favorite <?php if ($company->isFavorite()) { echo "on"; } else { echo "off"; }?>">
<?php if (logged_user()->isAdministrator()) { ?>
      <a href="<?php echo $company->getToggleFavoriteUrl($company->getViewUrl()); ?>"><img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo lang('toggle favorite'); ?>" alt="<?php echo lang('toggle favorite'); ?>"/></a>
<?php } else { ?>
      <img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo ($company->isFavorite() ? lang('favorite') : lang('not favorite')); ?>" alt="<?php echo ($company->isFavorite() ? lang('favorite') : lang('not favorite')); ?>">
<?php } ?>
    </div>
<?php } ?>  
    <h2><?php echo clean($company->getName()) ?></h2>
    
    <div class="cardBlock">
<?php if ($company->getDescription()) { ?>
      <div><?php echo $company->getDescription() ?></div>
<?php } // if ?>
<?php if ($company->getEmail()) { ?>
      <div><span><?php echo lang('email address') ?>:</span> <a href="mailto:<?php echo $company->getEmail() ?>"><?php echo $company->getEmail() ?></a></div>
<?php } // if ?>
<?php if ($company->getPhoneNumber()) { ?>
      <div><span><?php echo lang('phone number') ?>:</span> <?php echo clean($company->getPhoneNumber()) ?></div>
<?php } // if ?>
<?php if ($company->getFaxNumber()) { ?>
      <div><span><?php echo lang('fax number') ?>:</span> <?php echo clean($company->getFaxNumber()) ?></div>
<?php } // if ?>
<?php if ($company->hasHomepage()) { ?>
      <div><span><?php echo lang('homepage') ?>:</span> <a href="<?php echo $company->getHomepage() ?>"><?php echo $company->getHomepage() ?></a></div>
<?php } // if ?>
    </div>
    
<?php if ($company->hasAddress()) { ?>
    <h2><?php echo lang('address') ?></h2>
    
    <div class="cardBlock">
      <?php echo clean($company->getAddress()) ?>
 <?php if (trim($company->getAddress2())) { ?>
      <br /><?php echo clean($company->getAddress2()) ?>
 <?php } // if ?>
 <?php 
  if ($cc=trim($company->getCountry())) { 
    if (strpos('br mx it ec il at be bg hr cz dk ee fi fr gf pf tf de gr is lv li lu mc nl an no pl pt ro rs es se ch tr',$cc)) { ?>
      <br /><?php echo clean($company->getZipcode()) . '  ' . clean($company->getCity()) ?>, <?php echo clean($company->getState()) ?>
 <?php } else { ?>
      <br /><?php echo clean($company->getCity()) ?>, <?php echo clean($company->getState()) ?> <?php echo clean($company->getZipcode()) ?>
 <?php } ?>
 <?php } ?>

 <?php if (trim($company->getCountry())) { ?>
      <br /><?php echo clean($company->getCountryName()) ?>
 <?php } // if ?>
      <br /><a href="<?php echo $company->getShowMapUrl() ?>" target=_blank><?php echo lang('show map') ?></a> | 
      <a href="<?php echo $company->getShowRouteUrl(logged_user()->getContact()) ?>" target=_blank><?php echo lang('show route') ?></a>
   </div>
<?php } // if ?>
 
  </div>
  <div class='clear'></div>
</div>
<?php } // if ?>