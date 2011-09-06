/**
 * MoreOptions - this widget will transform given fieldset into a block that
 * can be collapsed and show brief info about extended content
 *
 * @param {String} context_id
 * @param {String} block_id
 * @constructor
 */
App.widgets.MoreOptions = function(fieldset_id, onExpandHandler, onCollapseHandler, auto_transform) {
  this.fieldset_id = fieldset_id;
  this.on_expand_handler = onExpandHandler;
  this.on_collapse_handler = onCollapseHandler;
  if(auto_transform) this.transform();
};

App.widgets.UserBoxMenu.prototype = {
  
  fieldset_id         : null,
  on_expand_handler   : null,
  on_collapse_handler : null,
  fieldset            : null,
  title               : '',
  short_info          : '',
  
  transform: function() {
    
  },
  
  /**
   * This function will actualy build the DIV and all of its subelements. We
   * can chose if we want to set it as expended or as collapsed from the start
   *
   * @param <String> title
   * @param <String> info
   * @param <String/HTMLElement/Array> content Element(s) that are found after 
   *   legend element in the fieldset
   * @param <Boolean> expended
   * @return
   */
  build: function(title, info, content, expanded) {
    
  },
  
  expand: function() {
    
  },
  
  collapse: function() {
    
  },
  
  getTitle: function() {
    return this.title;
  }
  
  setTitle: function(new_value) {
    
  },
  
  getShortInfo: function() {
    return this.short_info;
  },
  
  setShortInfo: function(new_short_info) {
    
  }
  
};
