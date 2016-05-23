<?php
/**
 * File Grid.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue53\Entity;

/**
 * Class Grid
 *
 * @package PHPWeekly\Issue53\Entity
 */
class Grid
{
    const ROW_LENGTH = 9;
    const COL_HEIGHT = 9;

    /**
     * @var array
     */
    private $rows = [];
    private $cols = [];
    private $sections = [];

    /**
     * Grid constructor
     *
     * @param string $input
     */
    public function __construct(string $input)
    {
        if (strlen($input) > self::ROW_LENGTH * self::COL_HEIGHT) {
            throw new \LengthException('Grid input string too long');
        }

        $cells = [];

        foreach (str_split($input) as $index => $value) {
            $row = (int) floor($index / self::ROW_LENGTH);
            $col = $index % self::ROW_LENGTH;
            $section = $this->getSectionKey($row, $col);

            $cell = $value === Cell::EMPTY_VALUE
                ? new Cell($value, $row, $col, $section)
                : new ImmutableCell($value, $row, $col, $section)
            ;

            $this->rows[$row][] = $cell;
            $this->cols[$col][] = $cell;
            $this->sections[$section][] = $cell;
        }
    }

    /**
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return array
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param int $index
     * @return array
     */
    public function getRow(int $index) : array
    {
        if (!array_key_exists($index, $this->rows)) {
            throw new \OutOfBoundsException(sprintf('Grid row %s does not exist', $index));
        }

        return $this->rows[$index];
    }

    /**
     * @param int $index
     * @return array
     */
    public function getCol(int $index) : array
    {
        if (!array_key_exists($index, $this->cols)) {
            throw new \OutOfBoundsException(sprintf('Grid column %s does not exist', $index));
        }

        return $this->cols[$index];
    }

    /**
     * @param int $row
     * @param int $col
     * @return array
     */
    public function getSection(int $row, int $col) : array
    {
        $section = $this->getSectionKey($row, $col);

        if (!array_key_exists($section, $this->sections)) {
            throw new \OutOfBoundsException(sprintf('Grid section %s does not exist', $section));
        }

        return $this->sections[$section];
    }

    /**
     * @param int $row
     * @param int $col
     * @return Cell
     */
    public function getCell(int $row, int $col) : Cell
    {
        if (!isset($this->rows[$row][$col])) {
            throw new \OutOfBoundsException(sprintf('Grid cell row: %s, col: %s does not exist', $row, $col));
        }

        return $this->rows[$row][$col];
    }

    /**
     * @param callable $fn
     * @return bool
     */
    public function each(callable $fn) : bool
    {
        foreach (range(0, self::ROW_LENGTH - 1) as $row) {
            foreach (range(0, self::COL_HEIGHT - 1) as $col) {
                $cell = $this->getCell($row, $col);

                if ($cell instanceof ImmutableCell) {
                    continue;
                }

                if ($fn($row, $col) === false) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param int $row
     * @param int $col
     * @return string
     */
    private function getSectionKey(int $row, int $col) : string
    {
        return sprintf('%s-%s', floor($row / 3), floor($col / 3));
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return array_reduce($this->rows, function($carry, array $row) : string {
            return $carry . implode('', $row);
        });
    }
}
