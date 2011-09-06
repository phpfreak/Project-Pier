<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('company card of', $company->getName()));
  dashboard_tabbed_navigation();
  dashboard_crumbs($company->getName());

?>
<?php $this->includeTemplate(get_template_path('company_card', 'company')) ?>
