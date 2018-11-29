<?php
/**
 * Created by PhpStorm.
 * User: jan.plank
 * Date: 29/11/18
 * Time: 11:30 AM
 */

namespace AppBundle\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    public function getFilters()
    {
        return array(
            new TwigFilter('customCurrencyFilter', array($this, 'formatCustomCurrencyFilter'))
        );
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('customCurrencyFunction', array($this, 'formatCustomCurrencyFunction',))
        );
    }

    public function formatCustomCurrencyFilter($number, $decimals = 0, $decPoint = '.', $thousandSep = ',')
    {
        $formattedCurrency = number_format($number, $decimals, $decPoint, $thousandSep);
        $formattedCurrency = '$' . $formattedCurrency;

        return $formattedCurrency;
    }

    public function formatCustomCurrencyFunction($currencyValue)
    {
        $formattedCurrency = number_format($currencyValue, 0, '.', ',');
        $formattedCurrency = $formattedCurrency . ' Eur';

        return $formattedCurrency;
    }

}