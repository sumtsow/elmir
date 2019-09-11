<?php

require_once 'classes/Comment.php';

if (isset($_POST['post_id']) &&
    isset($_POST['author']) &&
    isset($_POST['text']))
{
    $post_id = preg_replace("/[^0-9]/", '', $_POST['post_id']);
    $author = @htmlspecialchars($_POST['author']);
    $text = @htmlspecialchars($_POST['text']);
    
    $comment = new Comment();
    $comment->__set('post_id', $post_id);
    $comment->__set('author', $author);
    $comment->__set('text', $text);
    $comment->save();
    
    $result = array(
        'author' => $author,
        'text' => $text,
        'ip' => $comment->getIP(),
        'created_at' => $comment->getCreatedAt(),
    ); 

    echo json_encode($result);

}



