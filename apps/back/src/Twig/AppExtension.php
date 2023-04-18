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

    public function formatCurrency($number, $decimals = 2, $decPoint = '.', $thousandsSep = ','): string
    {
        $number = $number / 100;
        $amount = number_format($number, $decimals, $decPoint, $thousandsSep);
        $amount = $amount.'€';

        return $amount;
    }
}
