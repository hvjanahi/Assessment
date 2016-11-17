<?php

$range1 = new DateTime('20160104173643');
$range2 = $range1->diff(new DateTime('20160521101256'));

echo '<div align="center"><h3>'.$range2->days.' Days '.$range2->h.' Hours '.$range2->i.' Minutes '.$range2->s.' Seconds </h3></div>';

?>