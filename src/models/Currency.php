<?php

namespace app\models;

use yii\helpers\VarDumper;

/**
 * Get BTC rates and convert BTC to currency and back
 */
class Currency
{

    const ratesServiceURL = 'https://blockchain.info/ticker';

    const ourCommission = 0.02;

    /**
     * Apply our commission. With rounding
     * @param float $value
     * @param float $accuracy - rounding accuracy
     * @return float 
     */
    private static function applyCommission($value)
    {
        return $value * (1.0 + self::ourCommission);
    }

    /**
     * @param float $value
     * @param float $accuracy - rounding accuracy
     * @return float 
     */
    private static function currencyRound($value, $accuracy = 2)
    {
        return number_format($value, $accuracy, '.', '');
    }

    /**
     * Get rates from online services
     * @return array
     */
    private static function getRatesFromService()
    {
        // with caching
        static $rates = null;
        if (!isset($rates)) {

            $ch = curl_init(self::ratesServiceURL);

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);

            $rates = json_decode($result);
        }

        return $rates;
    }

    /**
     * Return only selected currencies
     * @param array $rates
     * @param string $currency
     * @return array
     */
    private static function filterCurrency($rates, $currency)
    {
        // get one or more currency
        $currencies = strpos($currency, ",") !== false ?
            explode(",", $currency) :
            [$currency];

        // trim spaces
        $currencies = array_map(function($val) {
            return trim($val);
        }, $currencies);

        return array_filter($rates, function ($ID) use ($currencies) {
            return in_array($ID, $currencies);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get all or selected rates
     * @param string|null $currency
     */
    public static function getRates($currency = null)
    {
        $rates = self::getRatesFromService();

        $outputRates = [];

        foreach ($rates as $ID => $rate) {
            $outputRates[$ID] =
                self::currencyRound(
                    self::applyCommission((float)$rate->last)
                );
        }

        if (isset($currency)) {
            $outputRates = self::filterCurrency($outputRates, $currency);
        }

        asort($outputRates, SORT_NUMERIC);

        return (object)$outputRates;
    }

    /**
     * @param string $currencyFrom 
     * @param string $currencyTo
     * @param float $value
     * @return object|boolean
     */
    public static function convertValue($currencyFrom, $currencyTo, $value)
    {
        if($value < 0.01) return false;

        if($currencyFrom=='BTC' && $currencyTo!='BTC'){

            $rates = self::getRates($currencyTo);
            $rateValue = (float)$rates->{$currencyTo};
            $resultValue = self::currencyRound($value * $rateValue);

        } else if($currencyTo=='BTC' && $currencyFrom!='BTC') {

            $rates = self::getRates($currencyFrom);
            $rateValue = (float)$rates->{$currencyFrom};

            $resultValue = self::currencyRound($value / $rateValue, 10);

        } else {
            return false;
        }

        return [
            'currency_from' => $currencyFrom,
            'currency_to' => $currencyTo,
            'value' => $value,
            'converted_value' => $resultValue,
            'rate' => $rateValue,
        ];
    }
}
