<?php ?>
<script type="text/javascript">
//<![CDATA[
$(function() {
  $('.selectall').click(function() {
    var checked_status = this.checked;
    var prefix = this.id;
    $('input[id^="'+(prefix)+'-"]').each(function() {
      this.checked = checked_status;
    });
  });
});

$(function() {
  $('input.datetimepicker').datetimepicker({
    dateFormat: '<?php echo str_replace("'","\'",lang('input date format')) ?>',
    constrainInput: false
  });
});
var dragover = false;
expand_or_collapse = function(obj,match_class,speedshow,speedhide){
  var children = $(obj).children();
  for(var i = 0; i < children.length; i++){
    if($(children[i]).hasClass(match_class)){
      if ($(children[i]).css("display") == 'none'){
        $(children[i]).show(speedshow);
      } else {
        $(children[i]).hide(speedhide);
      }
      break;
    }	
  }
}

$(function() { $(".header").click(
  function(e){
    expand_or_collapse(this.parentNode,'content','fast','fast');
    e.stopPropagation();
  });
});

$(function() { $(".header .complete").click(
  function(){
    expand_or_collapse(this.parentNode,'content','fast','slow');
    e.stopPropagation();
  });
});

$(function(){
  setTimeout(function(){
    s = $("#success");
    if (s.css("display") != 'none'){
      $("#success").fadeTo("slow", 0.25, function () {
          $("#success").hide(1000);
        });
    }
  }, 5000);
});

$(function(){
  $("#success").click(function () {
    $("#success").hide(1000);
  });
});

$(function(){
  $("#error").click(function () {
    $("#error").hide(1000);
  });
});

$(function(){
  $("#formErrors").click(function () {
    $("#formErrors").hide(1000);
  });
});

$(function(){
  $(".block a").click(function(e) {
    e.stopPropagation();
  });
});

$(function(){
  $(".block .checkbox").click(function(e) {
    e.stopPropagation();
  });
});

$(function(){
  $("a[rel='gallery'][href*='mime=image']").colorbox({photo:true});
});

$(function(){
  $("a[rel='gallery']").not(["href*='mime=image'"]).colorbox({width:"80%", height:"80%", iframe:true});
});


$(function(){
  $("textarea .autosize").each(function(index){
    $(this).css({'resize':'vertical','overflow-y':'hidden'});
    var p = $(this).parent('div');
    if (p) {
      $(this).css({'width':p.css('width')});
    }
  });
});

post = function(url, d){
  postdata = 'data=' + d;
  //ajax call html for action
  $.ajaxSetup({url:url,global:false,async:false,type:"POST"});
  $.ajax({data: postdata});
}

function asyncParForEach(array, fn, callback) {
  var completed = 0;
  if(array.length === 0) {
    callback(); // done immediately
  }
  var len = array.length;
  for(var i = 0; i < len; i++) {
    fn(array[i], function() {
        completed++;
        if(completed === array.length) {
          callback();
        }
      });
  }
};

$(function(){
  $("#filter").keyup(function () {
    var filter = $(this).val(), count = 0, s = "", i = 0;
    // speed trick: hide all filtered objects first, do manipulations, show them again
    gg = $(".filtered:visible");  
    gg.each(function () { $(this).hide() });
    $(".filtered:first li,.filtered:first tr").each(function () {
        s = $(this).text();
        i = s.lastIndexOf("-");
        if (i>=0) s = s.substring(0,i);
        if (s.search(new RegExp(filter, "i")) < 0) {
            $(this).hide();
        } else {
            $(this).show();
            count++;
        }
    });
    gg.each(function () { $(this).show() });
    $("#filter-count").text(count + ' <?php echo str_replace("'","\'",lang('shown/lc')); ?>' );
  }).keydown(function(event) {
    if (event.which == 13) {  // disable enter key on search filter to prevent leaving page
      event.preventDefault();
    }  
  })
});

$(function(){
  $("#i18n_values .edit").editable('<?php echo get_url('i18n', 'edit_value', null, null, false, '&'); ?>', { 
    indicator : '<?php echo str_replace("'","\'",lang('saving')); ?>',
    tooltip   : '<?php echo str_replace("'","\'",lang('click to edit')); ?>',
    style     : 'inherit' 
  });
});

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
}

function audioPlayer(url) { 
  window.open(url, 'audio_player', 'width=200,height=240,scrollbars=no,toolbar=no,location=no,menubar=no');
}

$(function() {
  $( "#memo>.content" ).resizable({ 
     handles: 'se',
     alsoResize: '#memotext',
     stop: function(event, ui) { 
       $( "#memo>.header" ).width(ui.size.width);
       viewdata = '' + ui.size.width + ',' + ui.size.height;
       post('<?php echo externalUrl(get_url('user','saveprojectnoteview', null, null, true, '&')); ?>', viewdata );
     }
  });
});

function autosaveFormInputs(prefix) {
  $(':input').each(function(index){
      // event handler to catch onblur events
      // it sets the cookie values each time you move out of an input field
      this.onblur = function() {
        var name = this.name;
        var value = this.value;
        $.cookie( prefix + name, value);
        //alert('setCookie: '+name + ' = '+value);
      };
  });
}

function recoverFormInputs(prefix) {
  $(':input').each(function(index){
      // this inserts all the remembered cookie values into the input fields
      if (!prefix) prefix = 'input-';
      var old_value = $.cookie(prefix + this.name);
      if (old_value && old_value != '') {
        //alert('old value remembered: '+old_value);
        this.value = old_value;
      };
  });
}

$(function() {
  autosaveFormInputs('input-'); 
});
//]]>
</script>