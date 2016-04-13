<?php

    class CurrencyConverter
    {
        private $rate_datafile;
        private $current_rates;

        public function __construct()
        {
            $this->rate_datafile = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
            $this->rate_xml = simplexml_load_file($this->rate_datafile);
        }

        public function euroTo($currency, $amount)
        {
            foreach ($this->rate_xml->Cube->Cube->Cube as $rate) {
                if ($rate['currency'] == $currency) {
                    return round($amount * (float) $rate['rate'], 2);
                }
            }
        }

        public function toEuro($currency, $amount)
        {
            foreach ($this->rate_xml->Cube->Cube->Cube as $rate) {
                if ($rate['currency'] == $currency) {
                    return round($amount / (float) $rate['rate'], 2);
                }
            }
        }
    }
