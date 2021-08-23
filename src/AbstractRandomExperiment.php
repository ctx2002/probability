<?php


namespace Softwarewisdom\PRO;

/**
 * Class AbstractRandomExperiment
 * @package Softwarewisdom\PRO
 */
abstract class AbstractRandomExperiment
{
    /**
     * @return array<mixed>
     */
    abstract public function results(): array;
}