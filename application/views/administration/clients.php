<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('clients'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
  administration_crumbs(lang('clients'));
  
  if (owner_company()->canAddClient(logged_user())) {
    add_page_action(lang('add client'), get_url('company', 'add_client'));
    add_page_action(lang('add contact'), get_url('contacts', 'add'));
  } // if

?>
<?php if (isset($clients) && is_array($clients) && count($clients)) { ?>
<table>
  <tr>
    <th><?php echo lang('name') ?></th>
    <th class="medium"><?php echo lang('contacts') ?></th>
    <th><?php echo lang('options') ?></th>
  </tr>
<?php foreach ($clients as $client) { ?>
  <tr>
    <td><a href="<?php echo $client->getViewUrl() ?>"><?php echo clean($client->getName()) ?></a></td>
    <td style="text-align: center"><?php echo $client->countContacts() ?></td>
<?php 
  $options = array(); 
  if ($client->canAddContact(logged_user())) {
    $options[] = '<a href="' . $client->getAddContactUrl() . '">' . lang('add contact') . '</a>';
  } // if
  if ($client->canUpdatePermissions(logged_user())) {
    $options[] = '<a href="' . $client->getUpdatePermissionsUrl() . '">' . lang('permissions') . '</a>';
  } // if
  if ($client->canEdit(logged_user())) {
    $options[] = '<a href="' . $client->getEditUrl() . '">' . lang('edit') . '</a>';
  } // if
  if ($client->canDelete(logged_user())) {
    $options[] = '<a href="' . $client->getDeleteClientUrl() . '">' . lang('delete') . '</a>';
  } // if
?>
    <td><?php echo implode(' | ', $options) ?></td>
  </tr>
<?php } // foreach ?>
</table>
<?php } else { ?>
<?php echo lang('no clients in company') ?>
<?php } // if ?>