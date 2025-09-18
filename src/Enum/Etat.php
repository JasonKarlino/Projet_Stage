<?php

namespace App\Enum;

enum Etat: string
{
    case Traitement = 'En cours de validation';
    case Valide = 'Validé';
    case Rejet = 'Refusé';

    public function label(): string
    {
        return match($this) {
            self::Traitement => 'En cours de validation',
            self::Valide => 'Validé',
            self::Rejet => 'Refusé',
        };
    }
}