<?php
$user = $attachment->getObject();
if (!$user) {
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
  tpl_assign('user', $user);
  $this->includeTemplate(get_template_path('user_card', 'user'));
} // if ?>