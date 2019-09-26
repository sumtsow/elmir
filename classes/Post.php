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
            $sth = $dbh->prepare('SELECT * FROM `posts` WHERE `id`=?');
            $sth->execute([$id]);
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
        //$sth = $dbh->prepare('SELECT * FROM `posts` ORDER BY `created_at` DESC LIMIT ? OFFSET ?');
        $sth = $dbh->prepare('SELECT *, (SELECT COUNT(*) FROM `comments` WHERE `post_id` = `posts`.`id`) comments FROM `posts` ORDER BY `created_at` DESC LIMIT ? OFFSET ?');
        $sth->bindParam(1, intval($itemsPerPage), PDO::PARAM_INT);
        $sth->bindParam(2, $offset, PDO::PARAM_INT);
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
        $xml = new SimpleXMLElement('<posts/>');
        $xml->addChild('page', $page);
        $xml->addChild('count', self::count());
        $xml->addChild('itemsPerPage', $itemsPerPage);
        foreach (self::all($page, $itemsPerPage) as $post) {
            $xmlPost = $xml->addChild('post');
            foreach ($post as $key => $value) {
                if($key == 'text') {
                    $value = nl2br($value, true);
                }                
                $xmlPost->addChild($key, $value);
            }
        }
        return $xml;
    }
    
    /**
     * read Post from database and
     * add all Comments to Post 
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
     * read Post's children Comments from database
     * @return array of Comments
     */
    public function comments()
    {
        $dbh = new DBConnect();
        $sth = $dbh->prepare('SELECT * FROM `comments` WHERE `post_id` = ? ORDER BY `created_at` DESC');
        $sth->execute([$this->id]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $key => $comment) {
            $result[$key]['text'] = nl2br($result[$key]['text'], true);
        }
        return $result;
    }
    
    /**
     * check the Post ID exists in database
     * @param integer $id the Post ID
     * @return boolean
     */
    public static function exists($id)
    {
        $dbh = new DBConnect();
        $sth = $dbh->prepare('SELECT `id` FROM `posts` WHERE `id` = ? LIMIT 1');
        $sth->execute([$id]);
        $result = $sth->fetch(PDO::FETCH_NUM);
        ($result[0]) ? $exists = true : $exists = false;
        return $exists;
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
