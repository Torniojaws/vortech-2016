<?php

    class Query
    {
        private $query;

        public function __construct($method, $request, $input = null)
        {
            $this->method = $method;
            list($request, $filters) = explode('?', $request);
            $this->request = str_replace('/api/v1', '', $request);
            $this->filters = $filters;
            $this->input = $input;

            $result = $this->query();
            $query['statement'] = $result[0];
            $query['params'] = $result[1];

            $this->query = $query;
        }

        public function getResult()
        {
            return $this->query;
        }

        private function query()
        {
            switch ($this->method) {
                case 'GET':
                    require_once 'GETDispatcher.php';
                    $dispatcher = new GETDispatcher($this->request, $this->filters);
                    break;
                case 'POST':
                    // TODO
                    #require_once('POSTDispatcher.php');
                    $dispatcher = new POSTDispatcher($this->request, $this->input);
                    break;
                case 'PUT':
                    require_once 'PUTDispatcher.php';
                    $dispatcher = new PUTDispatcher($this->request, $this->filters, $this->input);
                    break;
                default:
                    break;
            }
            $result[] = $dispatcher->getStatement();
            $result[] = $dispatcher->getParams();

            return $result;
        }
    }
