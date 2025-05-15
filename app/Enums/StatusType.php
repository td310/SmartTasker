<?php

namespace App\Enums;

enum StatusType: string
{
    case STARTED = 'started';
    case IN_PROGRESS = 'in progress';
    case DONE = 'done';

    public function color(): string
    {
        return match ($this) {
            self::STARTED => 'bg-blue-500 text-white',
            self::IN_PROGRESS => 'bg-yello-500 text-gray-700',
            self::DONE => 'bg-green-500 text-gray-700',
        };
    }
}
