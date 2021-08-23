<?php

declare(strict_types=1);

namespace Softwarewisdom\PRO;

/**
 * Class Geom
 * @package Softwarewisdom\PRO
 *
 * sample space is {0, 1, 2, 3,4,5,6,7,8}
 * 0 - immediately failed
 * 1 - last one year
 * 2 - last 2 years
 * etc.
 */
class Geom extends AbstractRandomExperiment implements IExperiment
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
        $this->F = array_fill(1, 51, 0);
    }

    /**
     * @return array<mixed>
     */
    public function results(): array
    {
        $c = 0;
        $r = [];
        $a = 0;
        for ($i = 1; $i <= 50; $i++) {
            $t = (1 - $this->p) * ($this->p ** ($i - 1));
            $c += $t;
            $r[$i - 1] = [
                'REL FREQ' => $this->F[$i] / $this->numberOfExperiment, //relative to total trial
                'Probability' => $t,
                'Cumulative Prob' => $c
            ];

            $a += ($this->F[$i] / $this->numberOfExperiment);
            if ($c > 0.999) {
                break;
            }
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
            $z = $this->randomFloat();
            $c = 0;

            $j = 0;
            while ($j <= 8) {
                $t = (1 - $this->p) * ($this->p ** ($j ));
                $c += $t;
                if ($z > $c) {
                    ++$j;
                    continue;
                }
                break;
            }

            ++$this->F[++$j]; //number of last $j year battery add 1.
        }
    }

    public static function simulation(int $N, float $P): void
    {
        $test = new Geom($N, $P);
        $test->run();
        //var_dump($test);
        $r = $test->results();
        echo "Life Length  Rel Frequency  Probability  Cumulative Prob\n";
        for ($i = 1; $i <= 50; $i++) {
            if (isset($r['table'][$i - 1]) && $r['table'][$i - 1]['Cumulative Prob'] > 0) {
                echo ($i - 1) . "  " . $r['table'][$i - 1]['REL FREQ'] . "  ";
                echo $r['table'][$i - 1]['Probability'] . "  ";
                echo $r['table'][$i - 1]['Cumulative Prob'] . "\n";
            } else {
                break;
            }
        }

        echo "Total Frequency : " . $r['Total Frequency'] . "\n";
        echo "Total Probability: " . $r['Total Probability'] . "\n";

        //var_dump($test->results());
    }
}
