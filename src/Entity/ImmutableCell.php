<?php
/**
 * File ImmutableCell.php
 *
 * @author Edward Pfremmer <epfremme@nerdery.com>
 */
namespace PHPWeekly\Issue53\Entity;

/**
 * Class ImmutableCell
 *
 * @package PHPWeekly\Issue53\Entity
 */
class ImmutableCell extends Cell
{
    /**
     * {@inheritdoc}
     */
    public function setValue($value, $guess = false)
    {
        throw new \RuntimeException('Cannot set value on immutable cell');
    }
}
