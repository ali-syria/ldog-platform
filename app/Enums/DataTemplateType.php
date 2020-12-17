<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DATA_COLLECTION()
 * @method static static DATA_REPORT()
 */
final class DataTemplateType extends Enum
{
    const DATA_COLLECTION='data collection';
    const DATA_REPORT='data report';
}
