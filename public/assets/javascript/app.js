// ---------------------------------------------------
//  Namespace
// ---------------------------------------------------

var App = window.App || {};
App.engine  = {}; // engine namspace
App.modules = {}; // modules (such as AddTaskForm, AddMessageForm etc)
App.widgets = {}; // widgets (such as GroupedBlock, UserBoxMenu, PageAction)

// ---------------------------------------------------
//  Handy functions and shortcuts
// ---------------------------------------------------

if(YAHOO.util.Dom.get) {
  var YUD = YAHOO.util.Dom;
  var $   = YUD.get;
} // if

if(YAHOO.util.Event) YUE = YAHOO.util.Event;

var $A = function(iterable) {
  if(!iterable) return [];
  var results = [];
  for (var i = 0; i < iterable.length; i++) {
    results.push(iterable[i]);
  } // for
  return results;
};

Function.prototype.bind = function() {
  var __method = this, args = $A(arguments), object = args.shift();
  return function() {
    return __method.apply(object, args.concat($A(arguments)));
  }
};

// ---------------------------------------------------
//  Engine
// ---------------------------------------------------

App.engine = {
  showStatus: function(message) {
    
  },
  hideStatus: function() {
    
  }
}
