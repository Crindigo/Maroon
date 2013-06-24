<?php

namespace Maroon\Model;

use Maroon\Modifier\ModifierTrait;

class Race
{
    use ModifierTrait;

    public function getModifierType()
    {
        return 'race';
    }

}