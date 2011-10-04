<?php

  /**
  * UserImValues, generated on Wed, 22 Mar 2006 15:37:58 +0100 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class UserImValues extends BaseUserImValues {
  
    /**
    * Return default user IM type
    *
    * @access public
    * @param User $user
    * @return ImType
    */
    function getDefaultUserImType(User $user) {
      
      $user_im_values_table = UserImValues::instance()->getTableName(true);
      $im_types_table = ImTypes::instance()->getTableName(true);
      
      $sql = "SELECT $im_types_table.* FROM $im_types_table, $user_im_values_table WHERE $im_types_table.`id` = $user_im_values_table.`im_type_id` AND $user_im_values_table.`is_default` = '1' AND $user_im_values_table.`user_id` = ?";
      $row = DB::executeOne($sql, $user->getId());
      if (is_array($row)) {
        return ImTypes::instance()->loadFromRow($row);
      } // if
      
      return null;
      
    } // getDefaultUserImType
    
    /**
    * Return all values by user
    *
    * @access public
    * @param User $user
    * @return array
    */
    function getByUser(User $user) {
      return self::findAll(array(
        'conditions' => '`user_id` = ' . DB::escape($user->getId())
      )); // findAll
    } // getByUser
    
    /**
    * Clear IM values by user
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function clearByUser(User $user) {
      return DB::execute('DELETE FROM ' . self::instance()->getTableName(true) . ' WHERE `user_id` = ?', $user->getId());
    } // clearByUser
    
  } // UserImValues 

?>