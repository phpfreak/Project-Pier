App.modules.addProjectForm = {
  formActionClick: function() {
    $('projectFormActionSelectMessage').disabled = !$('projectFormActionAddComment').checked;
    $('projectFormActionSelectTaskList').disabled = !$('projectFormActionAddTask').checked;
  }
};
