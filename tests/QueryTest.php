<?php

    class QueryTest extends PHPUnit_Framework_TestCase
    {
        public function testRequestIsExplodedCorrectly()
        {
            $request = '/api/v1/guestbook?year=2015';
            list($request, $filters) = explode('?', $request);

            $this->assertEquals('/api/v1/guestbook', $request);
        }

        public function testRequestFilterIsExplodedCorrectly()
        {
            $request = '/api/v1/guestbook?year=2015&month=3';
            list($request, $filters) = explode('?', $request);

            $this->assertEquals('year=2015&month=3', $filters);
        }

        public function testQueryReceivesCorrectSQL()
        {
            $queryFunctionResult = $this->queryTestFunction();
            $statement = $queryFunctionResult['statement'];

            $this->assertEquals('SELECT id FROM news WHERE id = :id', $statement);
        }

        public function testQueryReceivesCorrectParams()
        {
            $queryFunctionResult = $this->queryTestFunction();
            $parameters = $queryFunctionResult['params'];

            $this->assertEquals(123, $parameters['id']);
        }

        /* Helpers */
        private function queryTestFunction()
        {
            $result['statement'] = 'SELECT id FROM news WHERE id = :id';
            $result['params'] = array('id' => 123);

            return $result;
        }
    }
