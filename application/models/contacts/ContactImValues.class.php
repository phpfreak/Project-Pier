<?php

  /**
  * ContactImValues
  *
  * @http://www.projectpier.org/
  */
  class ContactImValues extends BaseContactImValues {
  
    /**
    * Return default contact IM type
    *
    * @access public
    * @param Contact $contact
    * @return ImType
    */
    function getDefaultContactImType(Contact $contact) {
      
      $contact_im_values_table = ContactImValues::instance()->getTableName(true);
      $im_types_table = ImTypes::instance()->getTableName(true);
      
      $sql = "SELECT $im_types_table.* FROM $im_types_table, $contact_im_values_table WHERE $im_types_table.`id` = $contact_im_values_table.`im_type_id` AND $contact_im_values_table.`is_default` = '1' AND $contact_im_values_table.`contact_id` = ?";
      $row = DB::executeOne($sql, $contact->getId());
      if (is_array($row)) {
        return ImTypes::instance()->loadFromRow($row);
      } // if
      
      return null;
      
    } // getDefaultContactImType
    
    /**
    * Return all values by contact
    *
    * @access public
    * @param Contact $contact
    * @return array
    */
    function getByContact(Contact $contact) {
      return self::findAll(array(
        'conditions' => '`contact_id` = ' . DB::escape($contact->getId())
      )); // findAll
    } // getByContact
    
    /**
    * Clear IM values by contact
    *
    * @access public
    * @param Contact $contact
    * @return boolean
    */
    function clearByContact(Contact $contact) {
      return DB::execute('DELETE FROM ' . self::instance()->getTableName(true) . ' WHERE `contact_id` = ?', $contact->getId());
    } // clearByContact
    
  } // ContactImValues 

?>