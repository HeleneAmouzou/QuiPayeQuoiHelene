<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_currency', array($this, 'formatCurrency')),
        ];
    }

    public function formatCurrency($amount): string
    {
        $amountFormatted = substr_replace($amount, ',', -2, 0);
        $amountFormatted = $amountFormatted . '€';

        return $amountFormatted ;
    }
}
