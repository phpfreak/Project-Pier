<?php 

  // Set page title and set crumbs to index
  set_page_title($contact->getDisplayName());
  dashboard_tabbed_navigation(DASHBOARD_TAB_CONTACTS);
  if (logged_user()->isMemberOfOwnerCompany()) {
    dashboard_crumbs(array(
      array(lang('contacts'), get_url('dashboard', 'contacts')),
      array($contact->getCompany()->getName(), $contact->getCompany()->getCardUrl()),
      array($contact->getDisplayName())));
  } else {
    dashboard_crumbs(array(
      array($contact->getCompany()->getName(), $contact->getCompany()->getCardUrl()),
      array($contact->getDisplayName())));
  } // if
  if ($contact->canUpdateProfile(logged_user())) {
    add_page_action(array(
      lang('edit contact')  => $contact->getEditUrl(),
    ));
  } // if
  if (logged_user()->isAdministrator() && logged_user()->getId() != $contact->getUserId()) {
    if ($contact->hasUserAccount()) {
      add_page_action(array(
        lang('edit user account') => $contact->getEditUserAccountUrl()
      ));
      add_page_action(array(
        lang('delete user account') => $contact->getDeleteUserAccountUrl()
      ));
    } else {
      add_page_action(array(
        lang('add user account') => $contact->getAddUserAccountUrl()
      ));
    }
  } elseif (logged_user()->getContact()->getId() == $contact->getId()) {
    add_page_action(array(
      lang('edit user account') => $contact->getEditUserAccountUrl()
    ));
  } // if
  if (logged_user()->isMemberOfOwnerCompany()) {
    $url = $contact->getReserveParkingSpaceUrl();
    if (trim($url)!='') {
      add_page_action(array(
        lang('reserve parking space') => $url
      ));
    }
    add_page_action(array(
      lang('show map') => $contact->getShowMapUrl()
    ));
    add_page_action(array(
      lang('show route') => logged_user()->getContact()->getShowRouteUrl($contact)
    ));
  }
  add_stylesheet_to_page('admin/contact_list.css');

?>
<?php 
  $this->includeTemplate(get_template_path('contact_card', 'contacts')) 
?>