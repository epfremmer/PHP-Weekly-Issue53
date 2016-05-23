<?php
/**
 * File Puzzle.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue53\Entity;

/**
 * Class Puzzle
 *
 * @package PHPWeekly\Issue53\Entity
 */
class Puzzle
{
    const BIT_0 = 1;
    const BIT_1 = 2;
    const BIT_2 = 4;
    const BIT_3 = 8;
    const BIT_4 = 16;
    const BIT_5 = 32;
    const BIT_6 = 64;
    const BIT_7 = 128;
    const BIT_8 = 256;

    const FULL_MASK = 511;

    /**
     * @var array<int,int>
     */
    public static $bitMap = [
        self::BIT_0 => 1,
        self::BIT_1 => 2,
        self::BIT_2 => 3,
        self::BIT_3 => 4,
        self::BIT_4 => 5,
        self::BIT_5 => 6,
        self::BIT_6 => 7,
        self::BIT_7 => 8,
        self::BIT_8 => 9,
    ];

    /**
     * @var string
     */
    private $input;

    /**
     * @var Grid
     */
    private $grid;

    /**
     * Puzzle constructor
     *
     * @param string $input
     */
    public function __construct(string $input)
    {
        $this->input = $input;
        $this->grid = new Grid($input);
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @param int $index
     * @return int
     */
    public function getRowMask(int $index) : int
    {
        $row = $this->grid->getRow($index);

        return $this->getMask($row);
    }

    /**
     * @param int $index
     * @return int
     */
    public function getColMask(int $index) : int
    {
        $col = $this->grid->getCol($index);

        return $this->getMask($col);
    }

    /**
     * @param int $row
     * @param int $col
     * @return int
     */
    public function getSectionMask(int $row, int $col) : int
    {
        $section = $this->grid->getSection($row, $col);

        return $this->getMask($section);
    }

    /**
     * @param int $row
     * @param int $col
     * @return int
     */
    public function getCellMask(int $row, int $col) : int
    {
        $rowMask = $this->getRowMask($row);
        $colMask = $this->getColMask($col);
        $sectionMask = $this->getSectionMask($row, $col);

        return ~($rowMask | $colMask | $sectionMask) & self::FULL_MASK;
    }

    /**
     * @param array $cells
     * @return int
     */
    private function getMask(array $cells) : int
    {
        return (int) array_reduce($cells, function($carry, Cell $cell) {
            $value = $cell->getValue();

            return $value ? $carry ^ (1 << ($value - 1)) : $carry;
        });
    }

    /**
     * @return bool
     */
    public function isComplete()
    {
        $isValid = function(array $cells) : bool {
            return $this->getMask($cells) === self::FULL_MASK;
        };

        foreach ($this->grid->getRows() as $row) {
            if (!$isValid($row)) return false;
        }

        foreach ($this->grid->getCols() as $col) {
            if (!$isValid($col)) return false;
        }

        foreach ($this->grid->getSections() as $section) {
            if (!$isValid($section)) return false;
        }

        return true;
    }
}
