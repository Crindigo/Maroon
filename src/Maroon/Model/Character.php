<?php

namespace Maroon\Model;

class Character
{
    private $baseStats;
    private $stats;

    public function getStat($stat)
    {
        return $this->stats[$stat];
    }

    public function getBaseStat($stat)
    {
        return $this->baseStats[$stat];
    }

    public function adjustStat($stat, $value)
    {
        $this->stats[$stat] += $value;
    }

    /**
     *
     */
    public function getSPCostMultiplier()
    {
        return 1.0;
    }

    public function getItemTypeProficiency(ItemType $itemType)
    {
        return 1.0;
    }

    /**
     * Maybe!
     *
     * Collects all modifiers for this character, organizes them by event, and merges duplicates.
     * Result can be cached somewhere.
     */
    public function collectModifiers()
    {

    }
}