<?php
if ($object->isPrivate()) {
  echo "<em>".lang('private message')."</em>";
} // if
echo do_textile($object->getText());
?>