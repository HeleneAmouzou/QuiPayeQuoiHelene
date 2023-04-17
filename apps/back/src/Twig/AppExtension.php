<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return array(
            new TwigFilter('divide_by_100', array($this, 'divideBy100')),
        );
    }

    public function divideBy100($amount): float
    {
        $amount = $amount/100;
        return $amount;
    }
}
