<?php

namespace Maroon\RPGBundle\Model;

use Maroon\RPGBundle\Modifier\ModifierTrait;

class Race
{
    use ModifierTrait;

    public function getModifierType()
    {
        return 'race';
    }

}