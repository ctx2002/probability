<?php

declare(strict_types=1);

namespace Softwarewisdom\PRO;

/**
 * Class Birth
 * @package Softwarewisdom\PRO
 */
class Birth extends AbstractRandomExperiment implements IExperiment
{
    use RSeed;

    private int $N;
    private float $proportion;
    /** @var array<float> $male*/
    private array $male = [];
    /** @var array<float> $female*/
    private array $female = [];

    /**
     * The  program BIRTH
     * simulates the birth of N children with the true proportion of male
     * births  assumed to be p.
     *
     * The  simulation is repeated 20  times  and
     * the  output prints the proportion of female  and male births in each
     *  of the 20  simulation
     *
     * sample space is {make, female}
     * @param int $N
     * @param float $proportion
     */
    public function __construct(int $N, float $proportion)
    {
        $this->N = $N;
        $this->proportion = $proportion;
        $this->male   = array_fill(0, 20, 0);
        $this->female = array_fill(0, 20, 0);
    }
    /**
     * @return array<mixed>
     */
    public function results(): array
    {
        return [
            'male' => $this->male,
            'female' => $this->female
        ];
    }

    /**
     * @return void
     */
    public function run(): void
    {
        //mt_srand($this->makeSeed());
        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < $this->N; $j++) {
                $z = $this->randomFloat();
                if ($z <= $this->proportion) {
                    ++$this->female[$i];
                } else {
                    ++$this->male[$i];
                }
            }
            $this->male[$i] /= $this->N;
            $this->female[$i] /= $this->N;
        }
    }

    /**
     *
     * *
     * @param int $N
     * @param float $P
     */
    public static function simulation(int $N, float $P): void
    {
        $test = new Birth($N, $P);
        $test->run();
        $r = $test->results();
        echo "Male     Female \n";
        for ($i = 0; $i < 20; $i++) {
            echo $r['male'][$i] . "     " . $r['female'][$i] . "\n";
        }
        //var_dump($test->results());
    }
}
