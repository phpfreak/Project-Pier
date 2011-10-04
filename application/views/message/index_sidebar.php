<?php if (isset($important_messages) && is_array($important_messages) && count($important_messages)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('important messages') ?></h2>
  <div class="content">
    <ul class="listWithDetails">
<?php foreach ($important_messages as $important_message) { ?>
      <li class="<?php echo odd_even_class($ln) ?>"><a href="<?php echo $important_message->getViewUrl() ?>"><?php echo clean($important_message->getTitle()) ?></a><br />
      <span class="desc"><?php echo lang('comments on message', $important_message->countComments()) ?></span></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>