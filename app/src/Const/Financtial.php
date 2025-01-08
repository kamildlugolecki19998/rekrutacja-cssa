<?php

namespace App\Const;

class Financtial
{
    public const ANNUAL_INTREST_RATE = 0.1659;
    public const YEARLY_NUMBER_OF_INSTALLMENT = 12;
    public const MONTHLY_INTREST_RATE = self::ANNUAL_INTREST_RATE / self::YEARLY_NUMBER_OF_INSTALLMENT;
}
