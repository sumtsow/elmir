<?php

require_once 'classes/Comment.php';

if (isset($_POST["post_id"]) &&
    isset($_POST["author"]) &&
    isset($_POST["text"]) &&
    isset($_POST["_csrf"]))
{
    $author = @strip_tags(@htmlentities($_POST["author"]));
    $comment = new Comment();
    $comment->__set('post_id', @strip_tags(@htmlentities($_POST["post_id"])));
    $comment->__set('author', $author);
    $comment->__set('text', @strip_tags(@htmlentities($_POST["text"]), '<br>'));
    $comment->save();
    
    $result = array(
        'author' => $author,
    ); 

    echo json_encode($result);

}



