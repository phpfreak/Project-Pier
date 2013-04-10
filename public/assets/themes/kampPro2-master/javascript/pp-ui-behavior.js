var dragover = false;

function expand_or_collapse(obj,match_class,speedshow,speedhide){
  var children = $(obj).children();
  for(var i = 0; i < children.length; i++){
    if($(children[i]).hasClass(match_class)){
      if ($(children[i]).css("display") == 'none'){
        $(children[i]).slideDown(speedshow);
      } else {
        $(children[i]).slideUp(speedhide);
      }
      //break;
    } 
  }
}

$(function(){

  $('.selectall').click(function() {
    var checked_status = this.checked;
    var prefix = this.id;
    $('input[id^="'+(prefix)+'-"]').each(function() {
      this.checked = checked_status;
    });
  });

  $('input.datepicker').datepicker({
    dateFormat: i18n.dateFormat,
    showOn: 'button',
    buttonImageOnly: true,
    constrainInput: false
  });

  $('a.add-to-task-list').click(function() {
    $(this).next().slideToggle();
    return false;
  });

  $(".block .header").click(function(e) {
    expand_or_collapse($(this).parent(),'content','fast','fast');
    e.stopPropagation();
  });

  $(".block .complete").click(function() {
    expand_or_collapse(this,'content','fast','slow');
  });

  $(".taskTextarea").autogrow();

  setTimeout(function(){
    var s = $("#success");
    if (s.css("display") != 'none') {
      $("#success").fadeTo("slow", 0.25, function () {
        $("#success").hide(1000);
      });
    }
  }, 5000);

  $("#success, #error, #formErrors").click(function () {
    $(this).hide(1000);
  });


  $(".block a, .block .checkbox").click(function(e) {
    e.stopPropagation();
  });

  // Colorbox
  $("a[rel='gallery'][href*='mime=image']").colorbox({photo:true});
  $("a[rel='gallery']").not(["href*='mime=image'"]).colorbox({width:"80%", height:"80%", iframe:true});

  $("textarea .autosize").each(function(index){
      $(this).css({'resize':'vertical','overflow-y':'hidden'});
      var p = $(this).parent('div');
      if (p) {
        $(this).css({'width':p.css('width')});
      }
    });

  // Deleting tasks without refreshing the page
  $('.task-delete-link').click(function() {
    var really_delete, task_id;
    really_delete = confirm( 'Are you sure you want to delete this task? This can not be undone.' );
    task_id = $( this ).data( 'taskId' );
    if ( really_delete ) {
      $.ajax( 'index.php', {
        type: 'POST',
        data: {
          id: task_id,
          c: 'task',
          a: 'delete_task'
        },
        complete: function( jqXHR, textStatus ) {
          if ( 200 === jqXHR.status ) {
            $('#task-id-'+task_id).fadeOut('slow', function() { $(this).remove(); });
          } else {
            alert( jqXHR.responseText );
          }
        }
      });
    }
    return false;
  });
});

function post (url, d){
  var postdata = 'data=' + d;
  //ajax call html for action
  $.ajaxSetup({url:url,global:false,async:false,type:"POST"});
  $.ajax({data: postdata});
}
