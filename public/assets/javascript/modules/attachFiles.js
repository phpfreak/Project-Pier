App.modules.attachFiles = {
  
  /**
   * Add file lang
   */
  add_lang    : 'Add file',
  
  /**
   * Remove file lang
   */
  remove_lang : 'Remove file',
  
  /**
   * Error message that is alerthed when we reach the max number of controls in a specific set
   */
  max_controls_reached_lang : 'Max number of files reached',
  
  /**
   * Max number of controls per set
   */
  max_controls_per_set : 5,
  
  /**
   * Array of registered attach file sets. Usualy there is only one on the page
   */
  sets: [],
  
  /**
   * Initialize control
   *
   * @param integer max_controls
   * @param string add_lang_value
   * @param string remove_lang_value
   * @param string max_controls_lang_value
   */
  initialize : function(max_controls, add_lang_value, remove_lang_value, max_controls_lang_value) {
    App.modules.attachFiles.max_controls_per_set = max_controls;
    
    App.modules.attachFiles.add_lang = add_lang_value;
    App.modules.attachFiles.remove_lang = remove_lang_value;
    App.modules.attachFiles.max_controls_reached_lang = max_controls_lang_value;
  },
  
  /**
   * Initialize set
   *
   * @param integer set_id
   * @param string set_prefix
   */
  initSet : function(set_id, set_prefix) {
    App.modules.attachFiles.sets[set_id] = {
      id             : set_id,
      prefix         : set_prefix,
      controls       : new Array(1),
      next_conrol_id : 2,
      total_controls : 1
    };
    App.modules.attachFiles.buildSet(set_id);
  },
  
  /**
   * Build set
   *
   * @param integer set_id
   */
  buildSet : function(set_id) {
    var add_button = document.createElement('button');
    add_button.setAttribute('type', 'button');
    add_button.appendChild(document.createTextNode( App.modules.attachFiles.add_lang ));
    add_button.className = 'add_button';
    
    add_button.onclick = function() {
      App.modules.attachFiles.addControl(set_id);
    };
    
    $(App.modules.attachFiles.getSetControlId(set_id)).appendChild(add_button);
  },
  
  addControl : function(set_id) {
    var total_controls = App.modules.attachFiles.sets[set_id]['total_controls'];
    if((App.modules.attachFiles.max_controls_per_set > 0) && (total_controls >= App.modules.attachFiles.max_controls_per_set)) {
      alert(App.modules.attachFiles.max_controls_reached_lang);
      return;
    } // if
    
    var control_id = App.modules.attachFiles.sets[set_id]['next_conrol_id'];
    App.modules.attachFiles.sets[set_id]['next_conrol_id'] = control_id + 1;
    
    // Div
    var control_div = document.createElement('div');
    control_div.id = 'attachFiles_' + set_id + '_' + control_id;
    
    // File input
    var file_input = document.createElement('input');
    file_input.setAttribute('type', 'file');
    file_input.setAttribute('name', App.modules.attachFiles.sets[set_id]['prefix'] + '_' + control_id);
    
    // Remove button
    var remove_button = document.createElement('button');
    remove_button.setAttribute('type', 'button');
    remove_button.className = 'remove_button';
    remove_button.appendChild(document.createTextNode( App.modules.attachFiles.remove_lang ));
    
    /*remove_button.controlId = 1;*/
    remove_button.onclick = function() {
      App.modules.attachFiles.removeControl(set_id, control_id);
    };
    
    control_div.appendChild(file_input);
    control_div.appendChild(remove_button);
    
    $(App.modules.attachFiles.getSetControlsDivId(set_id)).appendChild(control_div);
    
    App.modules.attachFiles.sets[set_id]['total_controls'] += 1;
  },
  
  removeControl : function(set_id, control_id) {
    if(control_id == 1) return;
    $(App.modules.attachFiles.getSetControlsDivId(set_id)).removeChild( 
      $(App.modules.attachFiles.getFileControlId(set_id, control_id)) 
    ); // removeChild
    App.modules.attachFiles.sets[set_id]['total_controls'] -= 1;
  },
  
  /**
   * Return prefix of specific set
   *
   * @param integer set_id
   */
  getSetPrefix : function(set_id) {
    return App.modules.attachFiles.sets[set_id]['prefix'];
  },
  
  /**
   * Return all controls in specific set
   *
   * @param integer set_id
   */
  getSetControls : function(set_id) {
    return App.modules.attachFiles.sets[set_id]['controls'];
  },
  
  /**
   * This function will return ID of set DIV
   *
   * @param integer set_id
   * @return string
   */
  getSetControlId : function(set_id) {
    return 'attachFiles_' + set_id;
  },
  
  /**
   * Retun ID of inner DIV that lists all file controls
   *
   * @param integer set_id
   * @return string
   */
  getSetControlsDivId : function(set_id) {
    return 'attachFilesControls_' + set_id;
  },
  
  /**
   * This function will return ID of control DIV based on set id and control ID
   *
   * @param integer set_id
   * @param integer control_id
   * @return string
   */
  getFileControlId : function(set_id, control_id) {
    return 'attachFiles_' + set_id + '_' + control_id;
  }
}
