<?php

    require_once('get-dispatcher.php');
    #require_once('post-dispatcher.php');
    #require_once('put-dispatcher.php');

    class Query
    {
        private $query;

        public function __construct($method, $request, $input=null)
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

        public function getResult() {
            return $this->query;
        }

        private function query()
        {
            switch($this->method)
            {
                case 'GET':
                    $dispatcher = new GETDispatcher($this->request, $this->filters);
                    $result[] = $dispatcher->getStatement();
                    $result[] = $dispatcher->getParams();
                    break;
                case 'POST':
                    $dispatcher = new POSTDispatcher($this->request, $this->input);
                    $result[] = $dispatcher->getStatement();
                    $result[] = $dispatcher->getParams();
                    break;
                case 'PUT':
                    $dispatcher = new PUTDispatcher($this->request, $this->input);
                    $result[] = $dispatcher->getStatement();
                    $result[] = $dispatcher->getParams();
                    break;
                default:
                    break;
            }
            return $result;
        }
    }
