<?php
  /**
  * DatabaseAuthenticator class
  *
  * This class will perform authentication for a user. 
  * The builtin authentication based on the Users table.
  * 
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class DatabaseAuthenticator {

    /**
    * Link to database
    *
    * @var boolean or resource
    */
    private $link = false;    

    /**
    * Construct the instance
    *
    * @access public
    * @return DatabaseAuthenticator
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
      $username = array_var($login_data, 'username', '');
      $password = array_var($login_data, 'password', '');
        
      if (trim($username == '')) {
        throw new Error('username value missing');
      } // if
        
      if (trim($password) == '') {
        throw new Error('password value missing');
      } // if
      
      $this->connect();

      $user = $this->getUser($username, $password);

      // now check against ProjectPier (can be skipped)        
      if (!$user->isValidPassword($password)) {
        throw new Error('invalid login data');
      } // if

      //if (!$user->isDisabled()) {
      //  throw new Error('account disabled');
      //} // if

      mysql_close($this->link);

      return $user;
    } // authenticate

    /**
    * connect
    *
    * @param config_option authdb*
    * @return User of false
    */
    function connect() {
      $server = config_option('authdb server', '');
      $username = config_option('authdb username', '');
      $password = config_option('authdb password', '');
      $database = config_option('authdb database', '');

      $this->link = mysql_connect($server, $username, $password, true);
      if (!$this->link) {
        throw new Error(mysql_error());
      }
      $selected = mysql_select_db($database, $this->link);
      if (!$selected) {
        throw new Error(mysql_error());
      }
    }

    /**
    * getUser
    *
    */
    function getUser($username, $password) {
      // the sql should be like this:
      // select somefield as email from sometable where anotherfield = $username limit 1 
      // the expression 'as email' is important because the field is referenced as 'email'
      $sql = config_option('authdb sql', '');
      $sql = str_replace('$username', $username, $sql);
      $sql = str_replace('$password', $password, $sql);
      $result = mysql_query($sql, $this->link);
      if ($result) {
        $limit = mysql_num_rows($result);
        if ($limit == 1) {
          $row = mysql_fetch_assoc($result);
          $pass = array_var($row, 'password', $password);
          $email = array_var($row, 'email', 'noemail@databaseauthenticator.com');

          $user = Users::getByUsername($username, owner_company());
          if (!($user instanceof User)) {
            // option 1
            // create a new user when authenticated
            $user = new User();
            // option 2
            // allow only login for existing PP user
            // throw new Error('invalid login data');
          } // if
          $user->setPassword($pass);
          $user->setEmail($email);
          if ($user->isNew()) {
            $user->setUsername($username);
            $user->setIsAdmin(0);
            $user->setAutoAssign(0);
            $user->setUseLDAP(0);
          }
          $user->save();
          return $user;
        }
      }
      throw new Error('invalid login data');
    }
    
  }
?>