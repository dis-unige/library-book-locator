<?php
function pad($cote) {
    $el = explode('.', $cote);
    while (count($el) < 3) {
        array_push($el, '');
    }
    $x = $el[0];
    $y = $el[1] . str_repeat('0', 5 - strlen($el[1]));
    $z = $el[2] . str_repeat('0', 5 - strlen($el[2]));
    return intval($x . $y . $z);
}
