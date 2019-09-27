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
     * with Comment Number to each Post as 'comments'
     */
    public static function all($page = null, $itemsPerPage = 10)
    {
        $postsNum = self::count();
        $offset = ($page * $itemsPerPage < $postsNum) ? $page * $itemsPerPage : 0;
        $dbh = new DBConnect();
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
     * copy Post attributes to DOMAttributes
     * add Comments Number to each Post as 'comments' DOMAttribute
     * @param int $page
     * 
     * @return DOMDocument
     */
    public static function postsAsDOM($page = null)
    {
        $settings = DBConnect::getConfig();
        $itemsPerPage = $settings['db']['itemsPerPage'];

        $domDocument = new DOMDocument();
        $domRoot = $domDocument->createElement('posts');
        
        $id = $domDocument->createAttribute('id');
        $id->value = 'posts';
        $domRoot->appendChild($id);
        $domDocument->appendChild($domRoot);
        
        $pageAttr = $domDocument->createAttribute('page');
        $pageAttr->value = $page;
        $domRoot->appendChild($pageAttr);
        
        $count = $domDocument->createAttribute('count');
        $count->value = self::count();
        $domRoot->appendChild($count);
       
        $itemsAttr = $domDocument->createAttribute('itemsPerPage');
        $itemsAttr->value = $itemsPerPage;
        $domRoot->appendChild($itemsAttr);

        foreach (self::all($page, $itemsPerPage) as $post) {
            $domElement = $domDocument->createElement('post');
            foreach ($post as $key => $value) {
                if($key == 'created_at') {
                    $value = self::getFormattedDateTime($value);
                }                
                elseif($key == 'text') {
                    $value = nl2br($value, true);
                }
                $domAttribute = $domDocument->createAttribute($key);
                $domAttribute->value = $value;
                $domElement->appendChild($domAttribute);
            }
            $domRoot->appendChild($domElement);
            
        }
        return $domDocument;
    }
    
    /**
     * read Post from database and
     * add all own Comments to Post 
     * copy Post attributes to DOMAttributes
     * @return DOMDocument
     */
    public function asDOM()
    {
        $domDocument = new DOMDocument();
        
        $domRoot = $domDocument->createElement('post');
      
        $id = $domDocument->createAttribute('id');
        $id->value = $this->id;
        $domRoot->appendChild($id);
        $domDocument->appendChild($domRoot);
        
        $title = $domDocument->createAttribute('title');
        $title->value = $this->title;
        $domRoot->appendChild($title);
        
        $text = $domDocument->createAttribute('text');
        $text->value = $this->text;
        $domRoot->appendChild($text);        

        $created_at = $domDocument->createAttribute('created_at');
        $created_at->value = self::getFormattedDateTime($this->created_at);
        $domRoot->appendChild($created_at);  

        $comments = $domDocument->createAttribute('comments');
        $comments->value = count($this->comments);
        $domRoot->appendChild($comments);
        
        foreach ($this->comments as $comment) {
            $domElement = $domDocument->createElement('comment');
            foreach ($comment as $key => $value) {
                if($key == 'created_at') {
                    $value = self::getFormattedDateTime($value);
                }                
                $domAttribute = $domDocument->createAttribute($key);
                $domAttribute->value = $value;
                $domElement->appendChild($domAttribute);
            }
            $domRoot->appendChild($domElement);
        }
        return $domDocument;
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
    
    /**
     * @return string localized formatted DateTime
     */
    public static function getFormattedDateTime($dateTime)
    {
        $dateTime = date_create($dateTime);
        return date_format($dateTime, 'd.m.Y H:i:s');
    }
}
