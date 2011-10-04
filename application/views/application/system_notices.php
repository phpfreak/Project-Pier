<?php if (isset($_system_notices) && is_array($_system_notices) && count($_system_notices)) { ?>
<div id="systemNoticesWrapper">
  <div id="systemNotices">
    <ul>
<?php foreach ($_system_notices as $_system_notice) { ?>
      <li><?php echo $_system_notice ?></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>