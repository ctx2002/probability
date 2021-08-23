<?php

declare(strict_types=1);

namespace Softwarewisdom\PRO;

/**
 * Class Battery
 * @package Softwarewisdom\PRO
 *
 * sample space is {0, 1, 2, 3,4,5,6,7,8}
 * 0 - immediately failed
 * 1 - last one year
 * 2 - last 2 years
 * etc.
 */
class Battery extends AbstractRandomExperiment implements IExperiment
{
    use RSeed;

    /**
     * @var int
     */
    private int $numberOfExperiment;
    /** @var float */
    private float $p;
    /** @var array<float>*/
    private array $F;

    /**
     * Battery constructor.
     * @param int $numberOfExperiment
     * @param float $p
     */
    public function __construct(int $numberOfExperiment, float $p)
    {
        $this->numberOfExperiment = $numberOfExperiment;
        $this->p = $p;
        $this->F = array_fill(1, 9, 0);
    }

    /**
     * @return array<mixed>
     */
    public function results(): array
    {
        $c = 0;
        $r = [];
        $a = 0;
        for ($i = 1; $i <= 9; $i++) {
            $t = ((1 - $this->p) * ($this->p ** ($i - 1))) / (1 - ($this->p ** 9));
            $c += $t;
            $r[$i - 1] = [
                'REL FREQ' => $this->F[$i] / $this->numberOfExperiment, //relative to total trial
                'Probability' => $t,
                'Cumulative Prob' => $c
            ];
            $a += $this->F[$i] / $this->numberOfExperiment;
        }
        return [
            'table' => $r,
            'Total Frequency' => $a,
            'Total Probability' => $c
        ];
    }

    /**
     *
     */
    public function run(): void
    {
        for ($i = 1; $i <= $this->numberOfExperiment; $i++) {
            $z = $this->randomFloat();// in real world, the $z should be a list of conditions, if the list of conditions satisfied, test fail.
            //on the first trial, we decided, we have $z chance to fail our test
            //so $z is just random threshold, if bigger then the $z(threshold) then fail.
            $c = 0;
            //$j means last $j years
            for ($j = 0; $j <= 8; $j++) {
                //t is probability a battery in good status.
                //for last $j year, what is probability , sample space's total element is 9
                //for last 1 year under sample space 9 elements
                // (1-$p)($p**1)/(1 - ($p**9))
                $t = ((1 - $this->p) * ($this->p ** $j)) / (1 - ($this->p ** 9));
                $c += $t;
                if ($z > $c) {
                    //if battery was not failed
                    continue;
                }
                //$c >= $z, which means, our value is bigger then $z(threshold), so it is failed.
                //test failed.
                break;
            }
            //++$j;
            //map last 0 year to integer 1, last 1 year to integer 2, which is why use ++$j here
            ++$this->F[++$j]; //number of last $j year battery add 1.
        }
    }

    public static function simulation(int $N, float $P): void
    {
        $test = new Battery($N, $P);
        $test->run();
        $r = $test->results();
        echo "Life Length  Rel Frequency  Probability  Cumulative Prob\n";
        for ($i = 1; $i <= 9; $i++) {
            echo ($i - 1) . "  " . $r['table'][$i - 1]['REL FREQ'] . "  ";
            echo $r['table'][$i - 1]['Probability'] . "  ";
            echo $r['table'][$i - 1]['Cumulative Prob'] . "\n";
        }

        echo "Total Frequency : " . $r['Total Frequency'] . "\n";
        echo "Total Probability: " . $r['Total Probability'] . "\n";
        //var_dump($test->results());
    }
}