<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PostStatusType extends Enum
{
    const Draft = 0;
    const Scheduled = 1;
    const Published = 2;
    const Archived = 3;
}
