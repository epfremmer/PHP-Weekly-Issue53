<?php
/**
 * File Solver.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue53;

use PHPWeekly\Issue53\Entity\Puzzle;
use PHPWeekly\Issue53\Entity\Solution;

/**
 * Class Solver
 *
 * @package PHPWeekly\Issue53
 */
class Solver
{
    const MAX_ITERATIONS = 100;

    /**
     * @var
     */
    private $iterations;

    /**
     * Solve puzzle
     *
     * @param Puzzle $puzzle
     * @return Solution
     */
    public function solve(Puzzle $puzzle) : Solution
    {
        $grid = $puzzle->getGrid();

        $this->reset();

        while (true) {
            $grid->each(function(int $row, int $col) use ($puzzle) {
                $mask = $puzzle->getCellMask($row, $col);
                $cell = $puzzle->getGrid()->getCell($row, $col);

                if ($cell->getValue()) {
                    return;
                }

                if (isset(Puzzle::$bitMap[$mask])) {
                    $cell->setValue(Puzzle::$bitMap[$mask]);
                }
            });

            if ($puzzle->isComplete()) {
                break;
            }

            $this->iterations++;

            // terminate loop
            if ($this->iterations >= self::MAX_ITERATIONS) {
                break;
            }
        }

        return new Solution($puzzle, $this->iterations);
    }

    /**
     * Reset counter
     *
     * @return void
     */
    private function reset()
    {
        $this->iterations = 0;
    }
}
