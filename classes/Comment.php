<?php

require_once 'DBConnect.php';

/**
 * The Comment Model Class
 * @author Sumtsov Dmytro sumtsow@gmail.com
 */

class Comment {
 
    /**
    *  @var integer Comment ID
    */
    private $id;
 
    /**
    *  @var integer parent Post ID
    */
    private $post_id;
    
    /**
    *  @var string Post author
    */
    private $author;
    
    /**
    *  @var string Comment text
    */
    private $text;
    
    /**
    *  @var string Comment client IP address
    */
    private $ip;
    
    /**
    *  @var datetime Comment creation date
    */
    private $created_at;    
    
    /**
     * read Comment attributes from database with specified ID
     * @param integer $id Comment ID
     * @return boolean TRUE if Comment exists FALSE otherwise
     */
    public function __construct($id = null)
    {
        if($id)
        {
            $dbh = new DBConnect();
            $sth = $dbh->prepare('SELECT * FROM `comments` WHERE `id`="'.$id.'"');
            $sth->execute();
            $result = $sth->fetch();
            $this->id = $result['id'];
            $this->post_id = $result['post_id'];
            $this->author = $result['author'];
            $this->text = $result['text'];
            $this->ip = $result['ip'];
            $this->created_at = $result['created_at'];
            return true;
        }
        else {
            $this->id = null;
            $this->post_id = null;
            $this->author = '';
            $this->text = '';
            $this->ip = '';
            $this->created_at = date('Y-m-d H:i:s');
            return false;
        }
    }

    /**
     * read all Comments from database
     * @param int $post_id
     * @return array of Comments
     */
    public static function all($post_id = null)
    {
        $dbh = new DBConnect();
        if(is_int($post_id))
        {
            $sth = $dbh->prepare('SELECT * FROM `posts` WHERE `post_id` = "'.$post_id.'"');
        }
         else {
            $sth = $dbh->prepare('SELECT * FROM `posts`');             
         }
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }
    
}
