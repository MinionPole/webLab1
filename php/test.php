<?php

  function validationNum($num, $left, $right){
    return isset($num) && is_numeric($num) && ($num>=$left) && ($num<=$right);
  }


  function checkLeft($x, $y, $r){
    return ($x<=0 && $y>=0 && $y<=$r/2);
  }

  function checkRDown($x, $y, $r){
    return ($x<=0 && $y<=0 && $y<=0.5*$x+$r/2);
  }
  function checkRUp($x, $y, $r){
    return ($x>=0 && $y>=0 && sqrt($x^2+$y^2) * 2<= $r);
  }

  $counterL = 1;
  $counterR = 1;
  $connectionMemory = array();

  session_start();
  if (!isset($_SESSION['data'])){
      $_SESSION['data'] = array();
      $connectionMemory[$counterR] = 'data';
      $counterR = $counterR + 1;
  }

  $x = (int)$_POST["X"];
  $y = (int)$_POST["Y"];
  $r = (int)$_POST["R"];
  $startTime = @$_POST["startTime"];

  if(validationNum($x, -3, 5) && validationNum($y, -3, 3) && validationNum($r, 1, 5)){
    $ans = checkLeft($x, $y, $r) || checkRDown($x, $y, $r) || checkRUp($x, $y, $r);
    $ans_string = "";
    if($ans)
      $ans_string = "попали";
    else
      $ans_string = "мазила";
    $current_time = date("j M o G:i:s", time()-$startTime*60);
    $execution_time = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4);
    $sessionResult = array("X"=>$x, "Y"=>$y, "R"=>$r, "ans"=>$ans_string, "current_time"=>$current_time, "execution_time"=>$execution_time);
    array_push($_SESSION['data'], $sessionResult);
  }

  echo "<div class=answerBlock>X</div>
  <div class=answerBlock>Y</div>
  <div class=answerBlock>R</div>
  <div class=answerBlock>Result</div>
  <div class=answerBlock>CurrentTime</div>
  <div class=answerBlock>ExecutionTime</div>
  <div class=deltaBlock></div>";

  foreach($_SESSION['data'] as $elem){
    echo "<div class=answerBlock>" . $elem["X"] . "</div>";
    echo "<div class=answerBlock>" . $elem["Y"] . "</div>";
    echo "<div class=answerBlock>" . $elem["R"] . "</div>";
    echo "<div class=answerBlock>" . $elem["ans"] . "</div>";
    echo "<div class=answerBlock>" . $elem['current_time'] . "</div>";
    echo "<div class=answerBlock>" . $elem['execution_time'] . "</div>";
    echo "<div class=deltaBlock></div>";
  };
?>