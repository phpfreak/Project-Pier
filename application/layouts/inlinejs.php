<?php ?>
<script type="text/javascript">
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
</script>