App.modules.attachToObjectForm = {
  
  /**
   * Switch attach file forms based on selected option (attach existing or
   * attach new file)
   */
  toggleAttachForms: function toggleAttachForms() {
    if($('attachFormExistingFile').checked) {
      $('attachFormExistingFileControls').style.display = 'block';
      $('attachFormNewFileControls').style.display = 'none';
      $('documentFormFile').value = '';
    } else {
      $('attachFormExistingFileControls').style.display = 'none';
      $('attachFormNewFileControls').style.display = 'block';
    } // if
  } // toggleAttachForms
  
};
