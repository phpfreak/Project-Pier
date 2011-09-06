App.modules.addFileForm = {
  
  /**
  * Change state on the upload file click
  *
  * @param void
  * @return null
  */
  updateFileClick: function() {
    if($('fileFormUpdateFile').checked) {
      $('updateFileDescription').style.display = 'none';
      $('updateFileForm').style.display = 'block';
    } else {
      $('updateFileDescription').style.display = 'block';
      $('updateFileForm').style.display = 'none';
    } // if
  }, 
  
  /**
  * Change state on file change checkbox click
  *
  * @param void
  * @return null
  */
  versionFileChangeClick: function() {
    if($('fileFormVersionChange').checked) {
      var display_value = 'block';
    } else {
      var display_value = 'none';
    } // if
    $('fileFormRevisionCommentBlock').style.display = display_value;
  }
  
};
