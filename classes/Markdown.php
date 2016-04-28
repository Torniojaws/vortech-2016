<?php

    class Markdown
    {
        private $original_text;
        private $converted_text;
        private $markdown;
        private $replacements;

        public function __construct()
        {
            $this->replacements = array(
                '[p]' => '<p>',
                '[/p]' => '</p>',
                '[b]' => '<strong>',
                '[/b]' => '</strong>',
            );
        }

        public function convert($text)
        {
            $result = strtr($text, $this->replacements);
            $result = $this->url_conversion($result);
            $this->converted_text = $result;

            return $this->converted_text;
        }

        /**
         * URLs require a slightly different handling
         * [url=http://link.com]Text[/url]
         * will create:
         * <a href="http://link.com">Text/<a>.
         */
        private function url_conversion($text)
        {
            $search = '/[url=(.*?)](.*?)[/url]/';
            $converted = '<a href="$1">$2</a>';
            $result = preg_replace($search, $converted, $text);

            return $result;
        }

        /**
         * Images also have a bit different handling.
         * [img]relative/path/image.jpg[/img] (or url)
         * will create:
         * <img src="relative/path/image.jpg" alt="Image" />.
         */
        private function img_conversion($text)
        {
            $search = '/[img](.*?)[/img]/';
            $converted = '<img src="$1" alt="Image" />';
            $result = preg_replace($search, $converted, $text);

            return $result;
        }
    }
