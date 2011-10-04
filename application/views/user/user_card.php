<?php if (isset($user) && ($user instanceof User)) { ?>
<div class="card">
  <div class="cardIcon"><img src="<?php echo $user->getAvatarUrl() ?>" alt="<?php echo clean($user->getDisplayName()) ?> avatar" /></div>
  <div class="cardData">
  
    <h2><?php echo clean($user->getDisplayName()) ?></h2>
    
    <div class="cardBlock">
<?php if ($user->getTitle()) { ?>
      <div><span><?php echo lang('user title') ?>:</span> <?php echo clean($user->getTitle()) ?></div>
<?php } ?>
      <div><span><?php echo lang('company') ?>:</span> <a href="<?php echo $user->getCompany()->getCardUrl() ?>"><?php echo clean($user->getCompany()->getName()) ?></a></div>
    </div>
<?php if ( logged_user()->isMemberOfOwnerCompany() || ($user->getCompanyId() == logged_user()->getCompanyId()) ) { ?>
    <h2><?php echo lang('contact online') ?></h2>
    
    <div class="cardBlock">
      <div><span><?php echo lang('email address') ?>:</span> <a href="mailto:<?php echo clean($user->getEmail()) ?>"><?php echo clean($user->getEmail()) ?></a></div>
<?php if ($user->hasHomepage()) { ?>
      <div><span><?php echo lang('homepage') ?>:</span> <a href="<?php echo $user->getHomepage() ?>" target=_BLANK><?php echo $user->getHomepage() ?></a></div>
<?php } ?>
<?php if (is_array($im_values = $user->getImValues()) && count($im_values)) { ?>
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
    
<?php if ($user->getOfficeNumber() || $user->getFaxNumber() || $user->getMobileNumber() || $user->getHomeNumber()) { ?>
    <h2><?php echo lang('contact offline') ?></h2>
    
    <div class="cardBlock">
<?php if ($user->getOfficeNumber()) { ?>
      <div><span><?php echo lang('office phone number') ?>:</span> <?php echo clean($user->getOfficeNumber()) ?></div>
<?php } // if ?>
<?php if ($user->getFaxNumber()) { ?>
      <div><span><?php echo lang('fax number') ?>:</span> <?php echo clean($user->getFaxNumber()) ?></div>
<?php } // if ?>
<?php if ($user->getMobileNumber()) { ?>
      <div><span><?php echo lang('mobile phone number') ?>:</span> <?php echo clean($user->getMobileNumber()) ?></div>
<?php } // if ?>
<?php if ($user->getHomeNumber()) { ?>
      <div><span><?php echo lang('home phone number') ?>:</span> <?php echo clean($user->getHomeNumber()) ?></div>
<?php } // if ?>
    </div>
<?php } // if ?>
<?php } // if ( logged_user()->isMemberOfOwnerCompany() || ($user->getCompanyId() == logged_user->getCompanyId()) ) { ?>
  
  </div>
</div>
<?php } // if ?>