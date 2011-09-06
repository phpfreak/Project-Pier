/**
 * UserBoxMenu - widget that will attach popup menu to context object
 *
 * @param {String} context_id
 * @param {String} block_id
 * @constructor
 */
App.widgets.UserBoxMenu = function(context_id, block_id) {
  this.context = $(context_id);
  this.block = $(block_id);
  App.widgets.UserBoxMenu.instances.push(this); // register instance
};

/**
 * Array of all user box menu instances. User to hide all menues before we 
 * show selected one
 */
App.widgets.UserBoxMenu.instances = [];
App.widgets.UserBoxMenu.hideAllInstances = function(except_id) {
  for(var i = 0; i < App.widgets.UserBoxMenu.instances.length; i++) {
    if(except_id) {
      // Check if we have exception
      if(App.widgets.UserBoxMenu.instances[i].getBlockId() != except_id) {
        App.widgets.UserBoxMenu.instances[i].hideBlock();
      } // if
    } else {
      // Just hide, don't check for any exceptions
      App.widgets.UserBoxMenu.instances[i].hideBlock();
    } // if
  } // for
};

App.widgets.UserBoxMenu.prototype = {
  
  /**
   * Reference to object on witch menu is attached
   */
  context : null,
  
  /**
   * Reference to menu DIV
   */
  block : null,
  
  /**
   * This var is set to true by show function and false by the hide function
   * so it always indicates if manu is visible or not
   */
  block_visible : false,
  
  /**
   * This timer is responsible for hiding menu div
   */
  hide_timer : null,
  
  /**
   * Number of milisecons that will pass before menu is hidden
   */
  hide_in : 2000,
  
  /**
   * Array of menu instances that are grouped with this instance
   */
  grouped_with : null,
  
  /**
   * Init menu (hide it and attach event handlers)
   */
  build: function() {
    this.block.style.display = 'none'; // init value
    
    this.context.title = '';
    
    YUE.on(this.context, 'click', this.contextClick, this, true);
    YUE.on(this.context, 'mouseover', this.contextMouseOver, this, true);
    YUE.on(this.context, 'mouseout', this.contextMouseOut, this, true);
    YUE.on(this.block, 'mouseover', this.blockMouseOver, this, true);
    YUE.on(this.block, 'mouseout', this.blockMouseOut, this, true);
  },
  
  /**
   * Return ID of context object
   */
  getContextId: function() {
    return this.context.id;
  },
  
  /**
   * Return ID of menu div based on context ID value
   */
  getBlockId: function() {
    return this.block.id;
  },
  
  /**
   * Show menu div. This function will also hide all menu instances that are visible
   * on the page
   */
  showBlock: function() {
    // Hide all instances except this block
    App.widgets.UserBoxMenu.hideAllInstances(this.getBlockId());
    var context_pos = YUD.getXY(this.context);
    
    // From some reason YUD.setXY() didn't work... Manualy set styles
    this.block.style.left = context_pos[0] + 'px';
    this.block.style.top  = context_pos[1] + this.context.height + 2 + 'px';
    this.block.style.display = 'block';
    this.block_visible = true;
    
    if(this.hide_timer) window.clearTimeout(this.hide_timer); // Clear timeout if it is left over from some reason
  },
  
  /**
   * Hide menu div
   */
  hideBlock: function() {
    this.block.style.display = 'none';
    this.block_visible = false;
    if(this.hide_timer) window.clearTimeout(this.hide_timer);
  },
  
  /**
   * Show/hide block DIV
   */
  contextClick: function(e) {
    if(this.block.style.display == 'none') {
      this.showBlock();
    } else {
      this.hideBlock();
    } // if
  },
  
  /**
   * Hide other menus in group, show this
   */
  contextMouseOver: function(e) {
    if(!this.block_visible) {
      var one_visible = false; // one of the menus in group is visible. If not we will not auto show this one
      
      var len = App.widgets.UserBoxMenu.instances.length;
      for(var i = 0; i < len; i++) {
        if(App.widgets.UserBoxMenu.instances[i].block_visible) one_visible = true;
      } // for
      
      if(one_visible) {
        App.widgets.UserBoxMenu.hideAllInstances(this.getBlockId());
        this.showBlock();
      } // if
    } // if
    if(this.hide_timer) window.clearTimeout(this.hide_timer); // Clear timeout if it is left over
  },
  
  /**
   * Begin timer for hiding, it is terminated if pointer enters menu div
   */
  contextMouseOut: function(e) {
    this.hide_timer = window.setTimeout(this.hideBlock.bind(this), this.hide_in);
  },
  
  /**
   * Terminate icon out hide timer
   */
  blockMouseOver: function(e) {
    if(this.hide_timer) window.clearTimeout(this.hide_timer);
  },
  
  /**
   * Hide (start timer)
   */
  blockMouseOut: function(e) {
    this.hide_timer = window.setTimeout(this.hideBlock.bind(this), this.hide_in);
  }
  
};
