<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static FILE()
 * @method static static TEXT()
 * @method static static URL()
 */
final class RdfSource extends Enum
{
    const FILE =   'file';
    const TEXT =   'text';
    const URL = 'url';
}
