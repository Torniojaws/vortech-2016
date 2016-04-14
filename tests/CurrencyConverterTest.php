<?php

    class CurrencyConverterTest extends PHPUnit_Framework_TestCase
    {
        private $rate_datafile;

        public function __construct()
        {
            $this->rate_datafile = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
        }

        public function testCanAccessRateData()
        {
            $file_headers = @get_headers($this->rate_datafile);
            $code = $file_headers[0];

            if ($code == 'HTTP/1.0 200 OK' or $code == 'HTTP/1.1 200 OK') {
                $canAccess = true;
            } else {
                $canAccess = false;
            }

            $this->assertEquals(true, $canAccess);
        }

        public function testRateDatafileContainsExpectedData()
        {
            $xml = simplexml_load_file($this->rate_datafile);
            $hasRateData = false;

            foreach ($xml->Cube->Cube->Cube as $rate) {
                if ($rate['currency'] == 'USD') {
                    $hasRateData = true;
                }
            }

            $this->assertEquals(true, $hasRateData);
        }

        public function testRateIsConvertedCorrectly()
        {
            $rate_from_datafile = '1.1298';
            $test_amount_euros = '12.99';

            // Simply a sanity check
            $value = (float) $rate_from_datafile * (float) $test_amount_euros;
            $value = round($value, 2);

            $this->assertEquals(14.68, $value);
        }
    }
