<?php

    session_start();
    require_once 'UserComment.php';

    class UserCommentWithCategory extends UserComment
    {
        protected function buildStatement()
        {
            $sql = '';
            switch ($this->category) {
                case 'photos':
                    $sql = 'INSERT INTO photo_comments
                                (`id`, `photo_id`, `photo_comment_id`, `comment`, `author_id`, `date_commented`,
                                 `category_comment_subid`)';
                    break;
                case 'shopitems':
                    $sql = 'INSERT INTO shopitem_comments
                                (`id`, `shopitem_id`, `shopitem_comment_id`, `comment`, `author_id`,
                                 `date_commented`, `category_comment_subid`)';
                    break;
                default:
                    break;
            }
            $sql .= ' VALUES(
                0,
                :id,
                :subid,
                :comment,
                :author_id,
                :date_posted,
                :category_comment_subid
            )';

            return $sql;
        }

        protected function buildParameters()
        {
            $parameters = array(
                'id' => $this->comment_target_id,
                'subid' => $this->comment_sub_id,
                'comment' => $this->comment,
                'author_id' => $this->user_id,
                'date_posted' => $this->date_posted,
                'category_comment_subid' => $this->category_comment_sub_id,
            );

            return $parameters;
        }
    }
