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
     * read  $itemsPerPage Posts from database
     * @param integer $page current page number
     * @param integer $itemsPerPage page size
     * @return array of Posts
     */
    public static function all($page = null, $itemsPerPage = 10)
    {
        $postsNum = self::count();
        $offset = ($page * $itemsPerPage < $postsNum) ? $page * $itemsPerPage : 0;
        $dbh = new DBConnect();
        $sth = $dbh->prepare('SELECT * FROM `posts` ORDER BY `created_at` DESC LIMIT '.$itemsPerPage.' OFFSET '.$offset);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @return total Posts count
     */
    public static function count()
    {
        $dbh = new DBConnect();
        $sth = $dbh->prepare('SELECT COUNT(*) FROM `posts`');
        $sth->execute();
        $postsNum = $sth->fetchAll(PDO::FETCH_COLUMN, 0);
        return $postsNum[0];
    }

    /**
     * read $itemsPerPage Posts from database and
     * converts 2-dimentional array of Posts to Xml
     * add Comments number to each Post
     * @param int $page
     * 
     * @return SimpleXMLElement
     */
    public static function postsAsXml($page = null)
    {
        $settings = DBConnect::getConfig();
        $itemsPerPage = $settings['db']['itemsPerPage'];
        $commentsNum = self::getCommentNumber();
        $xml = new SimpleXMLElement('<posts/>');
        $xml->addChild('page', $page);
        $xml->addChild('count', self::count());
        $xml->addChild('itemsPerPage', $itemsPerPage);
        foreach (self::all($page, $itemsPerPage) as $post) {
            $xmlPost = $xml->addChild('post');
            foreach ($post as $key => $value) {
                $xmlPost->addChild($key, $value);
            }
            if(array_key_exists($post['id'], $commentsNum)) {
                $xmlPost->addChild('comments', $commentsNum[$post['id']]);
            }
            else {
                $xmlPost->addChild('comments', 0);
            }
        }
        return $xml;
    }
    
    /**
     * read Post from database and
     * add all Comments  to Post 
     * converts 2-dimentional array of Comments to Xml
     * @return SimpleXMLElement
     */
    public function asXml()
    {
        $xml = new SimpleXMLElement('<post/>');
        $xml->addChild('id', $this->id);
        $xml->addChild('title', $this->title);
        $xml->addChild('text', $this->text);
        $xml->addChild('created_at', $this->created_at);
        $xml->addChild('comments', count($this->comments));
        foreach ($this->comments as $comment) {
            $xmlComment = $xml->addChild('comment');           
            foreach ($comment as $key => $value) {
                 $xmlComment->addChild($key, $value);
            }
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
     * @return array of Comments
     */
    public function comments()
    {
        $dbh = new DBConnect();
        $sth = $dbh->prepare('SELECT * FROM `comments` WHERE `post_id` = "' . $this->id . '" ORDER BY `created_at` DESC');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $key => $comment) {
            $result[$key]['text'] = nl2br($result[$key]['text'], true);
        }
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
   
}
