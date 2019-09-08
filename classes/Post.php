<?php

require_once 'DBConnect.php';

/**
 * The Post Model Class
 * @author Sumtsov Dmytro sumtsow@gmail.com
 */

class Post {
 
    /**
    *  @var integer Post ID
    */
    private $id;
    
    /**
    *  @var string Post title
    */
    private $title;
    
    /**
    *  @var string Post text
    */
    private $text;
    
    /**
    *  @var datetime Post creation date
    */
    private $created_at;
        
    /**
    *  @var mixed array of child Comments
    */
    //private $comments;
    
    /**
     * read Post attributes from database with specified ID
     * @param integer $id Post ID
     * @return boolean true if Post exists or false otherwise
     */
    public function __construct($id = null)
    {
        if($id)
        {
            $dbh = new DBConnect();
            $sth = $dbh->prepare('SELECT * FROM `posts` WHERE `id`="' . $id . '"');
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $this->id = $result['id'];
            $this->title = $result['title'];
            $this->text = $result['text'];
            $this->created_at = $result['created_at'];
            $this->comments = $this->comments();
            return $result;
        }
        else {
            $this->created_at = date('Y-m-d H:i:s');
            return false;
        }
    }

    /**
     * read all Post's from database
     * @return array of Post's
     */
    public static function all()
    {
        $dbh = new DBConnect();
        $sth = $dbh->prepare('SELECT * FROM `posts`');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * read all Post's from database and
     * converts 2-dimentional array of Posts to Xml string
     * add Comments number to each Post
     * @return SimpleXMLElement
     */
    public static function allAsXml()
    {
        $posts = self::all();
        $commentsNum = self::getCommentNumber();
        $xml = new SimpleXMLElement('<posts/>');
        foreach ($posts as $post) {
            $xmlPost = $xml->addChild('post');
            foreach ($post as $key => $value) {
                $xmlPost->addChild($key, $value);
            }
            $xmlPost->addChild('comments', $commentsNum[$post['id']]);
        }
        return $xml;
    }
    
    /**
     * reads Post's children Comments number
     * @return array of Post's children Comments number
     */
    public static function getCommentNumber()
    {
        $dbh = new DBConnect();
        $sth = $dbh->prepare('SELECT `post_id`, COUNT(*) FROM `comments` GROUP BY `post_id`;');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row)
        {
            $commentNumber[$row['post_id']] = $row['COUNT(*)'];
        }
        return $commentNumber;
    }
    
    /**
     * read Post's children Comments from database
     * @return array of Comment's Ids
     */
    public function comments()
    {
        $dbh = new DBConnect();
        $sth = $dbh->prepare('SELECT `id` FROM `comments` WHERE `post_id` = ' . $this->id);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
        return $result;
    }
    
    /**
     * magic function
     * return specified attribute if exists or false
     * @param string $attr attribute name
     * @return mixed attribute if exists or false
     */
    public function __get($attr)
    {
        if(property_exists($this, $attr))
        {
            return $this->$attr;
        }
        else
        {
            return false;
        }
    }

    /**
     * magic function
     * set specified attribute to value
     * @param string $attr attribute name
     * @param string $attr attribute name
     * @return array of Post's Ids
     */
    /*public function __set($attr, $value)
    {
        if(property_exists('Post', $attr))
        {
            $this->$attr = $value;
            return true;
        }
        else
        {
            return false;
        }
    }*/
    
}
