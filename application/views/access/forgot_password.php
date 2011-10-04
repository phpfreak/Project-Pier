<?php set_page_title(lang('forgot password')) ?>
<form action="<?php echo get_url('access', 'forgot_password') ?>" method="post">
<?php tpl_display(get_template_path('form_errors')) ?>
  <div>
    <?php echo label_tag(lang('email address'), 'forgotPasswordEmail')  ?>
    <?php echo text_field('your_email', $your_email, array('class' => 'long', 'id' => 'forgotPasswordEmail')) ?>
  </div>
  <input type="hidden" name="submitted" value="submitted" />
  <div id="forgotPasswordSubmit"><?php echo submit_button(lang('email me my password')) ?></div>
  <div><a href="<?php echo get_url('access', 'login') ?>"><?php echo lang('login') ?></a></div>
</form>
<script type="text/javascript">document.forms[0].forgotPasswordEmail.focus()</script>