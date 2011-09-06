function ie_menu_fix() {
  var sfEls = document.getElementById("account_more_menu").getElementsByTagName("LI");
  for (var i=0; i<sfEls.length; i++) {
    sfEls[i].onmouseover=function() {
      this.className+=(this.className.length>0? " ": "") + "sfhover";
    }
    // event added to keep menu items from disappearing
    sfEls[i].onMouseDown=function() {
      this.className+=(this.className.length>0? " ": "") + "sfhover";
    }
    // event added to keep menu items from disappearing
    sfEls[i].onMouseUp=function() {
      this.className+=(this.className.length>0? " ": "") + "sfhover";
    }
    sfEls[i].onmouseout=function() {
    this.className=this.className.replace(new RegExp("( ?|^)sfhover\\b"), "");
    }
  }
}
//onload call
if (document.all) { // Load sfHover only in IE; other browsers don't need it
  if (window.attachEvent) window.attachEvent("onload", ie_menu_fix);
  else window.onload = ie_menu_fix; // Mac IE5 needs this
}
