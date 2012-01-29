<?php
  /**
  * HTTPBasicAuthenticator class
  *
  * This class will perform authentication for a user. 
  * The HTTP Basic authentication based on the Users table.
  * 
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class HTTPBasicAuthenticator {
    
    /**
    * Construct the instance
    *
    * @access public
    * @return Localization
    */
    function __construct() {
    } // __construct
    
    /**
    * authenticate
    *
    * @param string $name
    * @param string $password
    * @return User of false
    */
    function authenticate($login_data) {

      //set http auth headers for apache+php-cgi work around
      if (isset($_SERVER['HTTP_AUTHORIZATION']) && preg_match('/Basic\s+(.*)$/i', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
        list($name, $password) = explode(':', base64_decode($matches[1]));
        $_SERVER['PHP_AUTH_USER'] = strip_tags($name);
        $_SERVER['PHP_AUTH_PW'] = strip_tags($password);
      }

      //set http auth headers for apache+php-cgi work around if variable gets renamed by apache
      if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) && preg_match('/Basic\s+(.*)$/i', $_SERVER['REDIRECT_HTTP_AUTHORIZATION'], $matches)) {
        list($name, $password) = explode(':', base64_decode($matches[1]));
        $_SERVER['PHP_AUTH_USER'] = strip_tags($name);
        $_SERVER['PHP_AUTH_PW'] = strip_tags($password);
      }

      if($_SESSION['authenticated'] != 1) { 
        if($_SESSION['login'] != 1) { 
          $_SESSION['login'] = 1;
          $_SESSION['try_count'] = 0;
          $_SESSION['realm'] = time();
          session_regenerate_id(true);
          header('WWW-Authenticate: Basic realm="'.$_SESSION['realm'].'"');
          header('HTTP/1.0 401 Unauthorized');
          echo 'You cancelled the login';
          exit;
        }
      }

      $_SESSION['authenticated'] = 0;
      $_SESSION['try_count']++;
      if ($_SESSION['try_count']==4) {
        unset($_SESSION['login']);
        unset($_SESSION['realm']);
        session_destroy();
        die();
      }

      $login_data['username'] = array_var($_SERVER, 'PHP_AUTH_USER');
      $login_data['password'] = array_var($_SERVER, 'PHP_AUTH_PW');
//var_dump($login_data); die();
      $username = array_var($login_data, 'username');
      $password = array_var($login_data, 'password');
        
      if (trim($username == '')) {
        header('WWW-Authenticate: Basic realm="'.$_SESSION['realm'].'"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
      } // if
        
      if (trim($password) == '') {
        header('WWW-Authenticate: Basic realm="'.$_SESSION['realm'].'"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
      } // if
        
      $user = Users::getByUsername($username, owner_company());
      if (!($user instanceof User)) {
        header('WWW-Authenticate: Basic realm="'.$_SESSION['realm'].'"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
      } // if
        
      if (!$user->isValidPassword($password)) {
        header('WWW-Authenticate: Basic realm="'.$_SESSION['realm'].'"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
      } // if

      $_SESSION['authenticated'] = 1;
      //if (!$user->isDisabled()) {
      //  throw new Error('account disabled');
      //} // if

      return $user;
    } // authenticate
    
  }
?>