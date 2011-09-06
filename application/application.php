<?php

  /**
  * Main application file. Use this file to register new classes to auto loader 
  * service, define application level constants, init specific application 
  * resources etc
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  
  define('FILE_STORAGE_FILE_SYSTEM', 'fs');
  define('FILE_STORAGE_MYSQL', 'mysql');
  
  // Init flash!
  Flash::instance();
  Localization::instance()->loadSettings(DEFAULT_LOCALIZATION, ROOT . '/language');
  include_once APPLICATION_PATH . '/functions.php';
  
  try {
    CompanyWebsite::init();
    
    if (config_option('upgrade_check_enabled', false)) {
      VersionChecker::check(false);
    } // if
    
    if (config_option('file_storage_adapter', 'mysql') == FILE_STORAGE_FILE_SYSTEM) {
      FileRepository::setBackend(new FileRepository_Backend_FileSystem(FILES_DIR));
    } else {
      FileRepository::setBackend(new FileRepository_Backend_MySQL(DB::connection()->getLink(), TABLE_PREFIX));
    } // if
    
    PublicFiles::setRepositoryPath(ROOT . '/public/files');
    if (trim(PUBLIC_FOLDER) == '') {
      PublicFiles::setRepositoryUrl(with_slash(ROOT_URL) . 'files');
    } else {
      PublicFiles::setRepositoryUrl(with_slash(ROOT_URL) . 'public/files');
    } // if
    
  // Owner company or administrator doen't exist? Let the user create them
  } catch(OwnerCompanyDnxError $e) {
    Env::executeAction('access', 'complete_installation');
  } catch(AdministratorDnxError $e) {
    Env::executeAction('access', 'complete_installation');
    
  // Other type of error? We need to break here
  }  catch(Exception $e) {
    if (Env::isDebugging()) {
      Env::dumpError($e);
    } else {
      Logger::log($e, Logger::FATAL);
      Env::executeAction('error', 'system');
    } // if
  } // if

?>
