<?php
/**
 * File Cell.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue53\Entity;

/**
 * Class Cell
 *
 * @package PHPWeekly\Issue53\Entity
 */
class Cell
{
    const EMPTY_VALUE = '.';

    /**
     * @var int
     */
    private $value;

    /**
     * @var int
     */
    private $row;

    /**
     * @var int
     */
    private $col;

    /**
     * @var string
     */
    private $section;

    /**
     * Cell constructor
     *
     * @param string|int $value
     * @param int $row
     * @param int $col
     * @param string $section
     */
    public function __construct($value, int $row, int $col, string $section)
    {
        if ($value === self::EMPTY_VALUE) {
            $value = 0;
        }

        $this->value = (int) $value;
        $this->row = $row;
        $this->col = $col;
        $this->section = $section;
    }

    /**
     * @return int
     */
    public function getValue() : int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @return int
     */
    public function getCol()
    {
        return $this->col;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() : string
    {
        if (!$this->value) {
            return self::EMPTY_VALUE;
        }

        return (string) $this->value;
    }
}
