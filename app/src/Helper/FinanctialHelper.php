<?php

namespace App\Helper;

use App\Const\Financtial;

class FinanctialHelper
{
    public static function calculateCompoundAccumulationFactor(int $totalNumberOfInstallments): float
    {
        return pow((1 + Financtial::MONTHLY_INTREST_RATE),$totalNumberOfInstallments);
    }
    
    public static function calculateIntrestGrowthNumerator(float $compoundAccumulationFactor): float
    {
        return  Financtial::MONTHLY_INTREST_RATE * $compoundAccumulationFactor;
    }

    public static function calculateCumulativeGrowthDifference(float $compoundAccumulationFactor): float
    {
        return $compoundAccumulationFactor - 1;
    }
}
