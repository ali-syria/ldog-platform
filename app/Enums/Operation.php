<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATE()
 * @method static static UPDATE()
 */
final class Operation extends Enum
{
    const CREATE =   'create';
    const UPDATE =   'update';
}
