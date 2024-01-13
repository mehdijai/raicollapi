<?php

namespace App\Enums;

enum ValidationStatus: string
{
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case VALIDATED = 'validated';
}
