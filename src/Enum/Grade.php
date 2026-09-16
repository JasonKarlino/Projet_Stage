<?php

namespace App\Enum;

enum Grade: string
{
    case Licence = 'Licence';
    case Master = 'Master';
    case Doctorat = 'Doctorat';

    public function getLabel(): string
    {
        return match($this) {
            self::Licence => 'Licence',
            self::Master => 'Master',
            self::Doctorat => 'Doctorat',
        };
    }
}