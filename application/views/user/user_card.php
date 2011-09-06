<?php if (isset($user) && ($user instanceof User)) { ?>
<div class="card">
  <div class="cardIcon"><img src="<?php echo $user->getAvatarUrl() ?>" alt="<?php echo clean($user->getDisplayName()) ?> avatar" /></div>
  <div class="cardData">
  
    <h2><?php echo clean($user->getDisplayName()) ?></h2>
    
    <div class="cardBlock">
      <div><span><?php echo lang('title') ?>:</span> <?php echo $user->getTitle() ? clean($user->getTitle()) : lang('n/a') ?></div>
      <div><span><?php echo lang('company') ?>:</span> <a href="<?php echo $user->getCompany()->getCardUrl() ?>"><?php echo clean($user->getCompany()->getName()) ?></a></div>
    </div>
    
    <h2><?php echo lang('contact online') ?></h2>
    
    <div class="cardBlock">
      <div><span><?php echo lang('email address') ?>:</span> <a href="mailto:<?php echo clean($user->getEmail()) ?>"><?php echo clean($user->getEmail()) ?></a></div>
      
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
    
    <h2><?php echo lang('contact offline') ?></h2>
    
    <div class="cardBlock" style="margin-bottom: 0">
      <div><span><?php echo lang('office phone number') ?>:</span> <?php echo $user->getOfficeNumber() ? clean($user->getOfficeNumber()) : lang('n/a') ?></div>
      <div><span><?php echo lang('fax number') ?>:</span> <?php echo $user->getFaxNumber() ? clean($user->getFaxNumber()) : lang('n/a') ?></div>
      <div><span><?php echo lang('mobile phone number') ?>:</span> <?php echo $user->getMobileNumber() ? clean($user->getMobileNumber()) : lang('n/a') ?></div>
      <div><span><?php echo lang('home phone number') ?>:</span> <?php echo $user->getHomeNumber() ? clean($user->getHomeNumber()) : lang('n/a') ?></div>
    </div>
  
  </div>
</div>
<?php } // if ?>
