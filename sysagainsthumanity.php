<?php
header('Content-type: text/plain; charset=utf-8');

function munge(&$value,$key) {
$value=trim($value," ,\"\n\r\t.");
}

function remove_inst($q) {
$q=(preg_replace('/\(.*\)/','',$q));
return(trim($q));
}

$questions=file('sah-q.txt');
array_walk($questions,'munge');

//var_dump($questions);

$answers=file('sah-a.txt');
array_walk($answers,'munge');

//var_dump($answers);

//randomise both
shuffle($questions);
shuffle($answers);

$q=array_shift($questions);

$q=remove_inst($q);
$result=array();
$result['question']=$q;


while (strpos($q,'_____')!==FALSE) {
$a=array_shift($answers);
$q=preg_replace('/_____/','['.$a.']',$q,1);
}
$result['answer']=$q;

if (isset($_GET['json'])) {
echo json_encode($result);
} else {
echo $result['answer'];
}

