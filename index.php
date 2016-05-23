<?php
/**
 * File index.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */

declare(strict_types=1);

use PHPWeekly\Issue53\Entity\Puzzle;
use PHPWeekly\Issue53\Solver;

require_once 'vendor/autoload.php';

$input    = '4.3..5.2..529.1...68.2.3..539.....74...3.4...26.....835..7.2.98...8.623..2.4..5.1';
$expected = '413675829752981346689243715395128674178364952264597183536712498941856237827439561';

$solver = new Solver();
$puzzle = new Puzzle($input);

$solution = $solver->solve($puzzle);

echo sprintf('Input:    %s', $input), PHP_EOL;
echo sprintf('Output:   %s', (string) $solution->getPuzzle()->getGrid()), PHP_EOL;
echo sprintf('Expected: %s', $expected), PHP_EOL;
echo sprintf('Iterations: %s', $solution->getIterations()), PHP_EOL;
