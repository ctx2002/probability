<?php

require_once __DIR__ . "/vendor/autoload.php";

use Softwarewisdom\PRO as SIM;

$g = new class {
    use SIM\RSeed;
};
mt_srand($g->makeSeed());
//SIM\Birth::simulation(2000, 0.5);
//SIM\Birth::simulation(20000, 0.513);
//SIM\Cars::simulation(1000);
SIM\Battery::simulation(10000, 0.2);
