<?php

declare(strict_types=1);

namespace Softwarewisdom\PRO;

/**
 *  we  simulate  N visits to the drive-in bank. the bank has only 10 parking places.
 *  A maximum  of 10  cars may  be  in line at the drive-in bank. so (1 - 10) is sample space.
 *  In this  case we  make  the rather unrealistic assumption
 *  that the number  of cars  in line has  an  equal chance  of being any integer  from  1  to 10.
 *
 *  The  program simulates
 *  N =  1000 visits and the frequencies  of 1, 2,  ••. ,  10  cars in line
 *  are printed,  along with the  sum  of these relative frequencies  and
 *  the  average  number  of cars in line in the 1000 visits
 * **/
class Cars extends AbstractRandomExperiment implements IExperiment
{
    use RSeed;

    /** @var array<float> $F this is frequency**/
    private array $F;

    /** @var int $N number of visit*/
    private int $N;

    /**
     * Cars constructor.
     * sample space is {1, 2, 3,4,5,6,7,8,9, 10}
     * @param int $N
     */
    public function __construct(int $N)
    {
        $this->F = array_fill(1, 10, 0.0);
        $this->N = $N;
    }

    /**
     * @return array<mixed>
     */
    public function results(): array
    {
        $avgFreq = 0;
        $totalFreq = 0;
        for ($i = 1; $i <= 10; $i++) {
            $this->F[$i] /= $this->N;
            $avgFreq = $avgFreq + $i * $this->F[$i];
            $totalFreq += $this->F[$i];
        }
        return ['frequency' => $this->F, 'avg' => $avgFreq, 'total' => $totalFreq];
    }

    /**
     *
     */
    public function run(): void
    {
        //$this->makeSeed();
        for ($i = 1; $i <= $this->N; $i++) {
            $t = 1 + (int)($this->randomFloat() * 10);
            ++$this->F[$t];
        }
    }

    public static function simulation(int $numberOfVisit): void
    {
        $test = new Cars($numberOfVisit);
        $test->run();
        $r = $test->results();
        echo "Cars     Relative Frequency \n";
        foreach ($r['frequency'] as $key => $item) {
            echo $key . "     " . $item . "\n";
        }
        echo "Average: " . $r['avg'] . "\n";
        echo "Total Frequency: " . $r['total'] . "\n";
    }
}
