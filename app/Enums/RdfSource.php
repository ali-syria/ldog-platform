<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RdfSource extends Enum
{
    const FILE =   'file';
    const TEXT =   'text';
    const URL = 'url';
}
