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
     * creates new Comment object
     * and set $this->created_at to current DateTime
     * and set $this->ip to client IP address
     * @return boolean TRUE if Comment created FALSE otherwise
     */
    public function __construct()
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->ip = $_SERVER['REMOTE_ADDR'];
        return true;
    }

    /**
     * save Comment attributes to database
     * @return boolean TRUE if data saved successfull FALSE otherwise
     */
    public function save()
    {
        $dbh = new DBConnect();
        if( isset($this->post_id) &&
            isset($this->author) &&
            isset($this->text) &&
            isset($this->created_at) &&
            isset($this->ip))
        {
            $sth = $dbh->prepare('INSERT INTO `comments` (`id`, `post_id`, `author`, `text`, `ip`, `created_at`) VALUES (NULL, "'.$this->post_id.'", "'.$this->author.'", "'.$this->text.'", "'.$this->ip.'", "'.$this->created_at.'")');
            return $sth->execute();
        }
        
        return false;
    }
    
    /**
     * @return string client PI address
     */
    public function getIP()
    {
        return $this->ip;
    }
        
    /**
     * @return DateTime Comment creation date&time
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    /**
     * magic function
     * set specified attribute to value
     * @param string $attr attribute name
     * @param string $value attribute value
     * @return boolean TRUE if set or FALSE otherwise
     */
    public function __set($attr, $value)
    {
        $result = false;
        if(property_exists('Comment', $attr))
        {
            $this->$attr = $value;
            $result = true;
        }
        
        return $result;
    }
}
