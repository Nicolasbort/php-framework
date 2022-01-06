<?php

function dd(...$args)
{
    echo '<pre>';
    var_dump($args);
    echo '</pre>';

    exit();
}

function reduceByMonth($carry, $item) {
    $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    
    $d = new \DateTime($item->getDate());
    $month = $meses[$d->format("m")-1];
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