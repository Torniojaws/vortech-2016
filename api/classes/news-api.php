<?php

    class NewsAPI
    {
        public function __construct($request, $filters)
        {
            echo "In news api!";
            var_dump($request);
            var_dump($filters);
            $filters = explode('?', $request);
            $sql = $this->getQuery($request, $filters);
            return $sql;
        }

        private function getQuery($args, $filters) {
            echo $filters;
        }



    }


    /*
        GET /news                           All news
        GET /news?year=2016                 All news from 2016
        GET /news?year=2010&month=3         All news from March 2010

        GET /news/:id                       A specific news (1 = oldest news)
        GET /news/:id/comments              All comments for news {id}
        GET /news/:id/comments/:id          A specific comment for release {id}

        GET /news/:id/songs                 All songs for release {id}
        GET /news/:id/songs/:id             A specific song for release {id}
        GET /news/:id/songs/:id/comments    Comments for a specific song
    */
