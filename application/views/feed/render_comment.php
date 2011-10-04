<?php
if ($object->isPrivate()) {
  echo "<em>".lang('private comment')."</em>";
} // if
echo do_textile($object->getText());
?>