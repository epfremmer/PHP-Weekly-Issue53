<?php
/**
 * File Solution.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue53\Entity;

/**
 * Class Solution
 *
 * @package PHPWeekly\Issue53\Entity
 */
class Solution
{
    /**
     * @var Puzzle
     */
    private $puzzle;

    /**
     * @var int
     */
    private $iterations;

    /**
     * Solution constructor
     * @param Puzzle $puzzle
     * @param int $iterations
     */
    public function __construct(Puzzle $puzzle, int $iterations)
    {
        $this->puzzle = $puzzle;
        $this->iterations = $iterations;
    }

    /**
     * @return Puzzle
     */
    public function getPuzzle()
    {
        return $this->puzzle;
    }

    /**
     * @return int
     */
    public function getIterations()
    {
        return $this->iterations;
    }
}
