<?php
require_once '../SVGGraph/autoloader.php';
// require_once 'SVGGraph/SVGGraph.php';
// print_r($_GET); exit();
$target_att=$coarray=$nooccos=$coursecode=null;
if(isset($_GET) and !empty($_GET)){
$target_att=$_GET['targetA'];
$coarray=$_GET['cParm'];
$nooccos=$_GET['noofcos'];
$coursecode=$_GET['coursecode'];
$settings = [
  'auto_fit' => true,
  'back_colour' => '#eee',
  'back_stroke_width' => 0,
  'back_stroke_colour' => '#eee',
  'stroke_colour' => '#000',
  'axis_colour' => '#333',
  'axis_overlap' => 2,
  'grid_colour' => '#666',
  'label_colour' => '#000',
  'axis_font' => 'Arial',
  'axis_font_size' => 10,
  'pad_right' => 20,
  'pad_left' => 20,
  'link_base' => '/',
  'link_target' => '_top',
  'minimum_grid_spacing' => 20,
  'show_subdivisions' => true,
  'show_grid_subdivisions' => true,
  'grid_subdivision_colour' => '#ccc',
];

$width = 300;
$height = 200;
$type = 'GroupedBarGraph';
$values=array();
$values[0]=array();
$values[1]=array();
for($i=1;$i<=$nooccos;$i++){
  $tem=$coursecode.".".($i);
  $values[0][$tem]="";
  $values[1][$tem]="";
}
for($i=1;$i<=$nooccos;$i++){
    $tem="CO".($i);
    $tem1=$coursecode.".".($i);
    // array_push($values[$tem1],$target_att);
    // array_push($values[$tem1],$coarray[$tem]);
    $values[0][$tem1]=$target_att;
    $values[1][$tem1]=$coarray[$tem];
}
// $values = [
//   ['Dough' => 30, 'Ray' => 60, 'Me' => 40, 'So' => 25, 'Far' => 45, 'Lard' => 35,'Tea'=>24],
//   ['Dough' => 20, 'Ray' => 30, 'Me' => 20, 'So' => 15, 'Far' => 25, 'Lard' => 35, 'Tea' => 45],
// ];

$colours = [ ['#dc3912'], ['#3366cc'] ];
$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
$graph->colours($colours);
$graph->values($values);
$graph->render($type);


}






?>