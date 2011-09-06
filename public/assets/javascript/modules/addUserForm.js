App.modules.addUserForm = {
  
  /**
  * Change state on generate random password checkbox
  *
  * @param void
  * @return null
  */
  generateRandomPasswordClick: function() {
    if($('userFormRandomPassword').checked) {
      $('userFormPasswordInputs').style.display = 'none';
    } else {
      $('userFormPasswordInputs').style.display = 'block';
    } // if
  },
  
  generateSpecifyPasswordClick: function() {
    if($('userFormSpecifyPassword').checked) {
      $('userFormPasswordInputs').style.display = 'block';
    } else {
      $('userFormPasswordInputs').style.display = 'none';
    } // if
  }
  
}
