<?php


namespace App\Enums;

use SplEnum;

class UserType extends SplEnum
{
    const __default = 1;

    const INDIVIDUAL = 1;
    const CORPORATION = 2;
}
