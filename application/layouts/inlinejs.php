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
  $('input.datepicker').datepicker({
    dateFormat: '<?php echo lang('input date format') ?>',
    showOn: 'button',
    buttonImage: '<?php echo get_image_url('icons/calendar.png'); ?>',
    buttonImageOnly: true,
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
      //break;
    }	
  }
}

$(function() { $(".block").click(
  function(e){
    expand_or_collapse(this,'content','fast','fast');
    e.stopPropagation();
  });
});

$(function() { $(".block .complete").click(
  function(){
    expand_or_collapse(this,'content','fast','slow');
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

$(function(){
  $("#filter").keyup(function () {
    var filter = $(this).val(), count = 0, s = "", i = 0;
    // speed trick: hide all filtered objects first, do manipulations, show them again
    $(".filtered").each(function () { $(this).hide() });
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
    $(".filtered").each(function () { $(this).show() });
    $("#filter-count").text(count + ' <?php echo lang('shown/lc'); ?>' );
  }).keydown(function(event) {
    if (event.which == 13) {  // disable enter key on search filter to prevent leaving page
      event.preventDefault();
    }  
  })
});

$(function(){
  $("#i18n_values .edit").editable('<?php echo get_url('i18n', 'edit_value', null, null, false, '&'); ?>', { 
    indicator : '<?php echo lang('saving'); ?>',
    tooltip   : '<?php echo lang('click to edit'); ?>',
    style     : 'inherit' 
  });
});

function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
//]]>
</script>