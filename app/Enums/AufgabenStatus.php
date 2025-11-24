<?php

namespace App\Enums;


enum AufgabenStatus: int {

    case OPEN = 1;
    case ACTIVE = 2;
    case CLOSED = 3;
    case DELETED = 4;
}
