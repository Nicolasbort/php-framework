<?php

function dd(...$args)
{
    echo '<pre>';
    var_dump($args);
    echo '</pre>';

    exit();
}

function reduceByMonth($carry, $item) {
    $d = new \DateTime($item->getDate());
    $month = $d->format("m");
    if( isset($carry[$month]) ) {
        $carry[$month] += 1;
    }else{
        $carry[$month] = 1;
    }
    return $carry;
}

function reduceByYear($carry, $item) {
    $d = new \DateTime($item->getDate());
    $month = $d->format("Y");
    if( isset($carry[$month]) ) {
        $carry[$month] += 1;
    }else{
        $carry[$month] = 1;
    }
    return $carry;
}