<?php

namespace App\Enums;

enum QueueStatus: string
{
    case WAITING = 'waiting';
    case IN_PROCESS = 'in_process';
    case SERVED = 'served';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';
}
