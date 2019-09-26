<?php

require_once 'DBConnect.php';
require_once 'Post.php';

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
            $sth = $dbh->prepare('INSERT INTO `comments` (`id`, `post_id`, `author`, `text`, `ip`, `created_at`) VALUES (NULL, ?, ?, ?, ?, ?)');
            $sth->bindParam(1, $this->post_id, PDO::PARAM_INT);
            $sth->bindParam(2, $this->author, PDO::PARAM_STR, 128);
            $sth->bindParam(3, $this->text, PDO::PARAM_STR);
            $sth->bindParam(4, $this->ip, PDO::PARAM_STR, 16);             
            $sth->bindParam(5, $this->created_at, PDO::PARAM_STR, 19);
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
     * @return string formatted Comment creation date&time
     */
    public function getCreatedAt()
    {
        $dateTime = date_create($this->created_at);
        return date_format($dateTime, 'd.m.Y H:i:s');
    }
    
    /**
     * magic function
     * set specified attribute to value
     * @param string $attr attribute name
     * @param string $value attribute value
     * @return boolean TRUE if set or string otherwise
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
    
    /**
     * validate input data
     * @param string $attr attribute name
     * @param string $value attribute value
     * @return true if validated or error message otherwise
     */
    public function validate($attr, $value)
    {
        switch ($attr) {
            
            case 'post_id':
                
                if(Post::exists($value)) {
                    $result = true;
                }
                else {
                    $result = 'Пост не найден!';
                }
                break;
                
            case 'author':
                $valid = filter_var(
                    $value,
                    FILTER_VALIDATE_REGEXP,
                    ['options'=>
                        ['regexp' => '/^[a-zA-Z0-9]+([_ -]?[a-zA-Z0-9])*$/']
                    ]
                );
                if(!$valid) {
                    $result = 'Недопустимые символы в имени автора! Допускаются буквы, цифры, "_", "-" и " " (пробел)';
                }
                else {
                    if(strlen($value) > 0 && strlen($value) < 129) {
                    $result = true;
                    }
                    else {
                        $result = 'Недопустимая длина имени автора! Допускается от 1 до 128 символов';
                    }
                }
                break;
            
            case 'text':
                $value = filter_var($value, FILTER_SANITIZE_STRING);
                if(strlen($value) > 0 && strlen($value) < 65536) {
                    $result = true;
                }
                else {
                    $result = 'Недопустимая длина сообщения! Допускается от 1 до 65535 символов';
                }
                break;
                
            default :
               $result = false;
        }
        return $result;
    }
}
