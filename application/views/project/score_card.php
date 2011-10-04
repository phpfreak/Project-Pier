<?php
  set_page_title(lang('score card'));
  project_tabbed_navigation();
  project_crumbs(lang('score card'));

function imagepolarline($image,$x1,$y1,$length,$angle,$color)
{
    $x2 = $x1 + sin( deg2rad($angle) ) * $length;
    $y2 = $y1 + cos( deg2rad($angle+180) ) * $length;

    imageline($image,$x1,$y1,$x2,$y2,$color);
    return array( $x2, $y2 );
}

//add_stylesheet_to_page('project/progressbar.css');
$open = 0;
$done = 0;
$total = 0; 
$milestones = $project->getMilestones();
if (is_array($milestones)) {
  $count = count($milestones);
  $angle = 360 / $count;
  $size=440;
  $center=$size/2;
  $font_size = 2;
  $im = @imagecreate($size, $size) or die("Cannot Initialize new GD image stream");
  $background_color = imagecolorallocate($im, 240, 240, 240);
  $text_color = imagecolorallocate($im, 200, 50, 100);
  $red = imagecolorallocate($im, 200, 0, 0);
  $green = imagecolorallocate($im, 0, 100, 0);
  $gray = imagecolorallocate($im, 100, 100, 200);
  imagestring($im, 1, 5, 5,  "Score Card", $text_color);
  $filename = 'project_' . $project->getId() . '_score_card.png';

  $xylist = array();
  $a = 45;
  $i = 0;
  foreach($milestones as $milestone) {
    $goal = rand(70,95);
    $goal = $milestone->getGoal();
    $endxy = imagepolarline($im, $center, $center, $size/3, $a, $text_color );
    $endxylist[$i] = $endxy;
    $goalxy = array( (($endxy[0]-$center)*($goal/100))+$center, (($endxy[1]-$center)*($goal/100))+$center );
    $goalxylist[$i] = $goalxy;
    imagefilledarc($im, $goalxy[0], $goalxy[1], 5, 5, 0, 0, $green, IMG_ARC_PIE);
    $task_lists = $milestone->getTaskLists();
    if (is_array($task_lists)) {
      $score = 0;
      $nscore = 0;
      foreach($task_lists as $task_list) {
        $score += $task_list->getScore();
        $nscore++;
        $open += count($task_list->getOpenTasks());
        $done += count($task_list->getCompletedTasks());
        $total += $task_list->countAllTasks();
      }
      if ($nscore>0) {
        $score = $score / $nscore;
      }
      $done = 10; $total = 20;
      $scorexy = array( (($endxy[0]-$center)*($score/100))+$center, (($endxy[1]-$center)*($score/100))+$center );
      $scorexylist[$i] = $scorexy;
      imagefilledarc($im, $scorexy[0], $scorexy[1], 5, 5, 0, 0, $red, IMG_ARC_PIE);
    }
    $text = $milestone->getName() . ' (' . $score . ')';
    $shiftx = 10;
    if (($endxy[0]+10)<$center) {
      $text_width = imagefontwidth($font_size)*strlen($text); 
      $shiftx = 0 - $text_width;
    }
    imagestring($im, $font_size, max($endxy[0]+$shiftx,0), $endxy[1]-10, $text, $text_color);

    $a += $angle;
    $i++;
  }
  for($z = 0; $z < $count; $z++) {
    imagesetthickness($im, 1);
    $p1 = $endxylist[$z];
    if ($z == $count - 1) { 
      $p2 = $endxylist[0];
    } else {
      $p2 = $endxylist[$z+1];
    } 
    imageline($im, $p1[0], $p1[1], $p2[0], $p2[1], $gray );
    imageline($im, $center+($p1[0] - $center)*0.8, $center+($p1[1] - $center)*0.8, $center+($p2[0] - $center)*0.8, $center+($p2[1] - $center)*0.8, $gray );
    imageline($im, $center+($p1[0] - $center)*0.6, $center+($p1[1] - $center)*0.6, $center+($p2[0] - $center)*0.6, $center+($p2[1] - $center)*0.6, $gray );
    imageline($im, $center+($p1[0] - $center)*0.4, $center+($p1[1] - $center)*0.4, $center+($p2[0] - $center)*0.4, $center+($p2[1] - $center)*0.4, $gray );
    imageline($im, $center+($p1[0] - $center)*0.2, $center+($p1[1] - $center)*0.2, $center+($p2[0] - $center)*0.2, $center+($p2[1] - $center)*0.2, $gray );

    imagesetthickness($im, 2);
    $p1 = $goalxylist[$z];
    if ($z == $count - 1) { 
      $p2 = $goalxylist[0];
    } else {
      $p2 = $goalxylist[$z+1];
    } 
    imageline($im, $p1[0], $p1[1], $p2[0], $p2[1], $green );

    $p1 = $scorexylist[$z];
    if ($z == $count - 1) { 
      $p2 = $scorexylist[0];
    } else {
      $p2 = $scorexylist[$z+1];
    } 
    imageline($im, $p1[0], $p1[1], $p2[0], $p2[1], $red );

  }
  imagepng($im, CACHE_DIR .'/' . $filename);
  imagedestroy($im);
} // if
if ($total>0) {
  $percent = round($done * 100 / $total);
} else { 
  $percent = 0;
} // if
$completed = $project->getCompletedOn();

?>
<?php $this->includeTemplate(get_template_path('project/pageactions')); ?>

<form action="<?php echo $project->getEditLogoUrl() ?>" method="post" enctype="multipart/form-data">

<?php tpl_display(get_template_path('form_errors')) ?>
  
  <img src="cache/<?php $rnd = time(); echo "$filename?$rnd"; ?>">  
  
</form>