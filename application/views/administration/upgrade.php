<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('upgrade'));
  administration_tabbed_navigation();
  administration_crumbs(lang('upgrade'));

?>
<?php if (is_array($versions = $versions_feed->getNewVersions(product_version())) && count($versions)) { ?>
<div id="availableVersions">
<?php foreach ($versions as $version) { ?>
  <div class="availableVerion">
    <h2><a href="<?php echo $version->getDetailsUrl() ?>"><?php echo clean($version->getSignature()) ?></a></h2>
    <div class="releaseNotes"><?php echo do_textile($version->getReleaseNotes()) ?></div>
<?php
  $download_links = array();
  foreach ($version->getDownloadLinks() as $download_link) {
    $download_links[] = '<a href="' . $download_link->getUrl() . '">' . clean($download_link->getFormat()) .' (' . format_filesize($download_link->getSize()) . ')</a>';
  } // foreach
?>
    <div class="downloadLinks"><strong><?php echo lang('download') ?>:</strong> <?php echo implode(' | ', $download_links) ?></div>
  </div>
<?php } // foreach ?>
  </table>
</div>
<?php } else { ?>
<p><?php echo lang('upgrade is not available') ?></p>
<?php } // if ?>