<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MINISTRY()
 * @method static static INDEPENDENT_AGENCY()
 */
final class CabinetOrganizationType extends Enum
{
    const MINISTRY='Ministry';
    const INDEPENDENT_AGENCY='Independent Agency';
}
