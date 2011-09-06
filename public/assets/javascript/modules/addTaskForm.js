App.modules.addTaskForm = {
  task_lists: {},
  
  /**
   * Show add task form for specific lists
   *
   * @params integer task_list_id
   */
  showAddTaskForm: function(task_list_id) {
    list_details = App.modules.addTaskForm.task_lists[task_list_id];
    if(!list_details) return;
    if(!list_details.can_add_task) return;
    
    // Show this one
    $(list_details.add_task_link_id).style.display = 'none';
    $(list_details.task_form_id).style.display = 'block';
    $(list_details.text_id).focus();
    $(list_details.submit_id).accesskey = 's';
    
    // Hide all forms
    App.modules.addTaskForm.hideAllAddTaskForms(task_list_id);
  }, // showAddTaskForm
  
  /**
   * Hide specific add task form
   *
   * @param integer task_list_id
   */
  hideAddTaskForm: function(task_list_id) {
    list_details = App.modules.addTaskForm.task_lists[task_list_id];
    if(!list_details) return;
    if(!list_details.can_add_task) return;
    
    $(list_details.text_id).value = '';
    $(list_details.assign_to_id).value = '0:0';
    $(list_details.add_task_link_id).style.display = 'block';
    $(list_details.task_form_id).style.display = 'none';
    $(list_details.submit_id).accesskey = '';
  }, // hideAddTaskForm
  
  /**
   * Hide all (except one if ID is provided) add task forms
   *
   * @param integer except_task_list_id Skip this form (if value is provided)
   */
  hideAllAddTaskForms: function(except_task_list_id) {
    var key;
    for(key in App.modules.addTaskForm.task_lists) {
      if(except_task_list_id) {
        if(key != except_task_list_id) App.modules.addTaskForm.hideAddTaskForm(key);
      } else {
        App.modules.addTaskForm.hideAddTaskForm(key);
      } // if
    } // for
  } // hideAllAddTaskForms
  
};
