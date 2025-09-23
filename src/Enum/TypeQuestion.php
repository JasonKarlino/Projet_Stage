<?php

namespace App\Enum;

enum TypeQuestion: string
{
    case QCM = 'QCM';
    case QCU = 'QCU';
    case QB = 'QB';

    public function getLabel(): string
    {
        return match($this) {
            self::QCM => 'Question à Choix Multiples',
            self::QCU => 'Question à Choix Unique',
            self::QB => 'Question Booléenne',
        };
    }
}