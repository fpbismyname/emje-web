<?php

namespace App\Enums\Utils;

enum PaginateSize: int
{
    case SMALL = 10;
    case MEDIUM = 25;
    case LARGE = 50;
    case EXTRA_LARGE = 100;
}
