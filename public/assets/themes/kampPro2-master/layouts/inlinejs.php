<?php echo javascript_tag(null, "
    var i18n = {
      dateFormat: '" . lang('input date format') . "'
    }

    $.datepicker.setDefaults({
      buttonImage: '" . get_image_url('icons/calendar.png'). "'
    });
");