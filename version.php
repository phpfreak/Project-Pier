<?php

  /**
  * Return version of codebase
  * 
  * This file contains the version of source code distribution. It does not reflect the 
  * version installed in the database, just the version of the code. For instance, when 
  * you update the code files to a new version but you don't run the upgrade script, 
  * you are still using the old version database with new code files.  And that means 
  * that you are not actually using the new version. You'll most probably end up with 
  * a lot of problems and errors in that situation; they will be gone as soon as your run the 
  * upgrade script.
  *
  * TODO: ProjectPier should check for version mismatches on startup and go to the 
  *       Admin/Upgrade script page if needed.
  */

  return '0.8.0.3';
  
?>
