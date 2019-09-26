<?php

require_once 'classes/Comment.php';

if (isset($_POST['post_id'], $_POST['author'], $_POST['text']))
{

    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);

    //$author  = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_ENCODED);
    $author  = filter_input(INPUT_POST, 'author');
    
    //$text  = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_ENCODED);
    $text  = filter_input(INPUT_POST, 'text');
    
    $comment = new Comment();
    $comment->__set('post_id', $post_id);
    $comment->__set('author', $author);
    $comment->__set('text', $text);
    //$save = $comment->save();
    
    $result = [
        'author' => $author,
        'text' => $text,
        'ip' => $comment->getIP(),
        'created_at' => $comment->getCreatedAt(),
    ];

    echo json_encode($result);

}



