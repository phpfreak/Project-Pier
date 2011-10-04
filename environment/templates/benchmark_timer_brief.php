<?php 
  if (!isset($this) || !instance_of($this, 'BenchmarkTimer')) {
    return false; 
  } // if
?>
<span class="benchmark_timer_brief"><?php echo round($this->TimeElapsed(), 3) ?>s</span>