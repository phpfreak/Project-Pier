<?php if (isset($favorite_companies) && is_array($favorite_companies) && count($favorite_companies)) { ?>
<h2><?php echo lang('favorite companies'); ?></h2>
<ul>
<?php foreach ($favorite_companies as $company) { ?>
  <li><a href="<?php echo $company->getCardUrl(); ?>"><?php echo $company->getName()?></a></li>
<?php } // foreach ?>
</ul>
<?php } // if ?>
<?php if (is_array($tags) && count($tags)) { ?>
<h2><?php echo lang('tags'); ?></h2>
<div class="contactTags">
<?php foreach ($tags as $tag) { ?>
  <span><a href="<?php echo get_url('dashboard', 'search_by_tag', array('tag' => $tag)); ?>"><?php echo $tag;?></a></span>
<?php } // foreach ?>
</div>
<?php } // if ?>