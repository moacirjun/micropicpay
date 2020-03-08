<?php


namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self INDIVIDUAL()
 * @method static self CORPORATION()
 */
class UserType extends Enum
{
    private const INDIVIDUAL = 1;
    private const CORPORATION = 2;
}
