<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StateSeriesTv extends Enum
{
    const UnFollow =   0;
    const Follow =   1;
}
