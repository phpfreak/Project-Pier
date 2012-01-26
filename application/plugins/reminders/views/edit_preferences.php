<?php
  if ($user->getId() == logged_user()->getId()) {
    set_page_title(lang("reminders"));
    account_tabbed_navigation();
    account_crumbs(lang("reminders"));
  } else {
    set_page_title(lang('update profile'));
    if ($company->isOwner()) {
      administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
      administration_crumbs(array(
        array(lang('company'), $company->getViewUrl()),
        array(lang('update profile'))
      ));
    } else {
      administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
      administration_crumbs(array(
        array(lang('clients'), get_url('administration', 'clients')),
        array($company->getName(), $company->getViewUrl()),
        array($user->getDisplayName(), $user->getCardUrl()),
        array(lang('update profile'))
      ));
    } // if
  } // if
  if ($user->canUpdateProfile(logged_user())) {
    add_page_action(array(
      lang('update profile')  => $user->getEditProfileUrl(),
      lang('change password') => $user->getEditPasswordUrl(),
    ));
  } // if
  if ($user->canUpdatePermissions(logged_user())) {
    add_page_action(array(
      lang('permissions')  => $user->getUpdatePermissionsUrl()
    ));
  } // if
?>  
  <form action="<?php echo get_url('reminders', 'update_prefs') ?>" method="post">
    <fieldset>
      <legend><?php echo lang('reminder options');?></legend>
      <div>
        <?php echo label_tag(lang('reminder enable', null, true)) ?>
        <?php echo yes_no_widget('prefs_form[reminders_enabled]', 'reminderFormEnableDaily', $reminder_prefs->isEnabled(), lang('yes'), lang('no')) ?>
        <?php echo label_tag(lang('summarize by', null, false)) ?>
        <?php
          $options = array('project', 'task list', 'task', 'all'); #need to add milestone
          foreach ($options as $option) {
            $option_attributes = $reminder_prefs->getSummarizedBy() == $option ? array('selected' => 'selected') : null;
            $formOptions[] = option_tag(lang($option), $option, $option_attributes);
          }
          print select_box('prefs_form[summarized_by]', $formOptions);
        ?>    		
        <?php echo label_tag(lang('show tasks in future'), null, false) ?>
        <?php echo input_field("prefs_form[future]", $reminder_prefs->getRemindersFuture(), array('size' => '2')); ?>
        <?php echo label_tag(lang('include whom question'), null, false) ?>
        <?php echo yes_no_widget('prefs_form[ivsteam]', 'reminderFormDailySummarized', $reminder_prefs->getIncludeEveryone(), lang('for all'), lang('for me')) ?>
        <?php echo label_tag(lang('days to send'), null, true) ?>
        <table>
          <tr>
          <?php for ($i = $dayOfWeek; $i < $dayOfWeek+7; $i++) {
              echo "<th><center>".lang($weekArray[$i%7])."</center></th>";
            }
          ?>
          </tr>
          <tr>
          <?php for ($i = $dayOfWeek; $i < $dayOfWeek+7; $i++) {
              echo "<td><center>".checkbox_field("prefs_form[".$weekArray[$i%7]."]", $reminder_prefs->sendReminderOn($weekArray[$i%7]))."</center></td>";
            }
          ?>
          </tr>
        </table>
      </div>
   </fieldset>
   <br>
   <fieldset>
      <legend><?php echo lang('report options');?></legend>
      <div>
        <?php echo label_tag(lang('report enable', null, true)) ?>
        <?php echo yes_no_widget('prefs_form[reports_enabled]', 'reportFormEnableDaily', $reminder_prefs->getReportsEnabled(), lang('yes'), lang('no')) ?>
        <?php echo label_tag(lang('summarize by', null, false)) ?>
        <?php echo yes_no_widget('prefs_form[reports_summarized]', 'reportFormSummarizedBy', $reminder_prefs->getReportsSummarizedBy(), lang('project'), lang('all'));?>
        <?php echo label_tag(lang('include whom question'), null, false) ?>
        <?php echo yes_no_widget('prefs_form[ivsteam2]', 'reportFormDailySummarized', $reminder_prefs->getReportsIncludeEveryone(), lang('for all'), lang('for me')) ?>
        <?php echo label_tag(lang('include activity log'), null, false) ?>
        <?php echo yes_no_widget('prefs_form[report_activity]', 'reportFormIncludeActivity', $reminder_prefs->getReportsIncludeActivity(), lang('yes'), lang('no'));?>
        <?php echo label_tag(lang('day to send', null, false)) ?>
        <?php 
          $formOptions = array();
          for ($i = $dayOfWeek; $i < $dayOfWeek+7; $i++) {
            $option_attributes = $reminder_prefs->getReportDay() == $weekArray[$i%7] ? array('selected' => 'selected') : null;
            $formOptions[] = option_tag(lang($weekArray[$i%7]), $weekArray[$i%7], $option_attributes);
          }
          print select_box('prefs_form[reportDay]', $formOptions);
        ?>
      </div>	
    </fieldset>
    <?php echo submit_button(lang('update prefs')); ?>
  </form>