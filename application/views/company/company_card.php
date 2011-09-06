<?php if (isset($company) && ($company instanceof Company)) { ?>
<div class="card">
  <div class="cardIcon"><img src="<?php echo $company->getLogoUrl() ?>" alt="<?php echo clean($company->getName()) ?> logo" /></div>
  <div class="cardData">
  
    <h2><?php echo clean($company->getName()) ?></h2>
    
    <div class="cardBlock">
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
      <br /><?php echo clean($company->getCity()) ?>, <?php echo clean($company->getState()) ?> <?php echo clean($company->getZipcode()) ?>
 <?php if (trim($company->getCountry())) { ?>
      <br /><?php echo clean($company->getCountryName()) ?>
 <?php } // if ?>
 <?php $q = '';  ?>
 <?php $q .= clean($company->getAddress()) . ' ' . clean($company->getAddress2()); ?>
 <?php $q .= clean($company->getZipcode()) . ' ' . clean($company->getCity()); ?>
 <?php $q = urlencode($q);  ?>
      <br /><a href="http://maps.google.com/maps?q=<?php echo $q; ?>" target=_blank><?php echo lang('show map') ?></a>
   </div>
<?php } // if ?>
 
  </div>
  <div class='clear'></div>
</div>
<?php } // if ?>
