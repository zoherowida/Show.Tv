<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StateEpisodes extends Enum
{
    const DisLike =  0;
    const Like =   1;
}
