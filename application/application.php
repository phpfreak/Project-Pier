<?php

  /**
  * Main application file. Use this file to register new classes to auto loader 
  * service, define application level constants, init specific application 
  * resources etc
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  trace(__FILE__, 'begin');
  define('FILE_STORAGE_FILE_SYSTEM', 'fs');
  define('FILE_STORAGE_MYSQL', 'mysql');
  define('TOKEN_COOKIE_NAME', 'pp088' . TABLE_PREFIX);
  //$installation_root = config_option('installation_root', dirname($_SERVER['PHP_SELF']) );
  $path=$_SERVER['PHP_SELF'];
  $path=substr($path, 0, strpos($path, 'index.php'));
  $installation_root = $path;
  define('ROOT_URL', $installation_root);

  // Init flash!
  Flash::instance();
  $language = config_option('installation_base_language', 'en_us');
  if (isset($_GET['language'])) {
    $_SESSION['language'] = $_GET['language'];
    $_GET['language'] = '';
  }
  if (isset($_SESSION['language'])) {
    $language = $_SESSION['language'];
  }
  if (!plugin_active('i18n')) {
    Localization::instance()->loadSettings($language, ROOT . '/language');
  }
 
  try {
    trace(__FILE__, 'CompanyWebsite::init()');
    CompanyWebsite::init();
    
    if (config_option('upgrade_check_enabled', false)) {
      VersionChecker::check(false);
    } // if
    if (config_option('file_storage_adapter', 'mysql') == FILE_STORAGE_FILE_SYSTEM) {
      trace(__FILE__, 'FileRepository::setBackend() - use file storage');
      FileRepository::setBackend(new FileRepository_Backend_FileSystem(FILES_DIR));
    } else {
      trace(__FILE__, 'FileRepository::setBackend() - use mysql storage');
      FileRepository::setBackend(new FileRepository_Backend_MySQL(DB::connection()->getLink(), TABLE_PREFIX));
    } // if
    
    PublicFiles::setRepositoryPath(ROOT . '/public/files');
    if (trim(PUBLIC_FOLDER) == '') {
      PublicFiles::setRepositoryUrl(with_slash(ROOT_URL) . 'files');
    } else {
      PublicFiles::setRepositoryUrl(with_slash(ROOT_URL) . PUBLIC_FOLDER . '/files');
    } // if
    
  // Owner company or administrator doen't exist? Let the user create them
  } catch(OwnerCompanyDnxError $e) {
    Env::executeAction('access', 'complete_installation');
  } catch(AdministratorDnxError $e) {
    Env::executeAction('access', 'complete_installation');    
  // Other type of error? We need to break here
  }  catch(Exception $e) {
    trace(__FILE__, '- catch '.$e);
    if (Env::isDebugging()) {
      Env::dumpError($e);
    } else {
      Logger::log($e, Logger::FATAL);
      Env::executeAction('error', 'system');
    } // if
  } // if
?>