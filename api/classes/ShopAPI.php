<?php

    class ShopAPI
    {
        public $result;

        public function __construct($request, $filters = null)
        {
            $this->result = $this->getQuery($request, $filters);
        }

        public function getResult()
        {
            return $this->result;
        }

        private function getQuery($args, $filters = null)
        {
            $base_sql = 'SELECT shop_items.*,
                                shop_categories.name_id
                         FROM shop_items
                         JOIN shop_categories
                              ON shop_categories.id = shop_items.category_id';

            switch ($args) {
                # /shopitems
                case isset($args[2]) == false and isset($filters) == false:
                    $query['statement'] = $base_sql.' ORDER BY id';
                    $query['params'] = array();
                    break;

                # /shopitems?year=2015
                case isset($args[2]) == false and isset($filters):
                    // Expected parse_str variables are "year" and "category"
                    parse_str($filters);

                    // There are no real dates/years for the items, but the name field can contain
                    // a year, eg. "T-shirt 2009".
                    if (isset($year)) {
                        $query['statement'] = $base_sql.' WHERE shop_items.name LIKE :year
                                               ORDER BY id';
                        $query['params'] = array('year' => '%'.$year.'%');

                    # /shopitems?category=merch (or "cd" or "digital")
                    } elseif (isset($category)) {
                        $query['statement'] = $base_sql.' WHERE shop_categories.name_id = :category
                                               ORDER BY id';
                        $query['params'] = array('category' => $category);
                    }
                    break;

                # /shopitems/categories
                case isset($args[2]) and $args[2] == 'categories' and isset($args[3]) == false:
                    $query['statement'] = 'SELECT * FROM shop_categories';
                    $query['params'] = array();
                    break;

                # /shopitems/categories/:id
                case isset($args[2]) and $args[2] == 'categories' and isset($args[3])
                     and is_numeric($args[3]):
                    $query['statement'] = 'SELECT *
                                           FROM shop_categories
                                           WHERE id = :id
                                           LIMIT 1';
                    $query['params'] = array('id' => $args[3]);
                    break;

                # /shopitems/:id
                case isset($args[2]) and isset($args[3]) == false:
                    $query['statement'] = $base_sql.' WHERE shop_items.id = :id
                                           ORDER BY id
                                           LIMIT 1';
                    $query['params'] = array('id' => (int) $args[2]);
                    break;

                # /shopitems/:id/comments
                case isset($args[2]) and isset($args[3]) and $args[3] == 'comments':
                    $query['statement'] = 'SELECT shop_items.*,
                                                  shop_categories.name_id,
                                                  shopitem_comments.shopitem_id,
                                                  shopitem_comments.shopitem_comment_id,
                                                  shopitem_comments.category_comment_subid,
                                                  shopitem_comments.comment,
                                                  shopitem_comments.author_id,
                                                  shopitem_comments.date_commented,
                                                  users.name AS author
                                           FROM shop_items
                                           JOIN shop_categories
                                                ON shop_categories.id = shop_items.category_id
                                           LEFT JOIN shopitem_comments
                                                ON shopitem_comments.shopitem_id = shop_items.id
                                           LEFT JOIN users
                                                ON users.id = shopitem_comments.author_id
                                           WHERE shop_items.id = :id';
                    $query['params'] = array('id' => (int) $args[2]);

                    # /shopitems/:id/comments/:id
                    if (isset($args[4])) {
                        $query['statement'] .= ' AND shopitem_comments.shopitem_comment_id = :comment_id';
                    }
                    $query['statement'] .= ' ORDER BY shopitem_comments.shopitem_comment_id';
                    if (isset($args[4])) {
                        $query['statement'] .= ' LIMIT 1';
                    }
                    break;

                # Show all - same as /shopitems
                default:
                    $query['statement'] = 'SELECT shop_items.*,
                                                  shop_categories.name_id
                                           FROM shop_items
                                           JOIN shop_categories
                                                ON shop_categories.id = shop_items.category_id
                                           ORDER BY id';
                    $query['params'] = array();
            }

            return $query;
        }
    }
