<?php

require_once 'classes/Comment.php';

if (isset($_POST['post_id'], $_POST['author'], $_POST['text']))
{

    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
    $author  = filter_input(INPUT_POST, 'author');
    $text  = filter_input(INPUT_POST, 'text');    
    //$text  = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_ENCODED);

    
    $comment = new Comment();
    
    $errorInfo = false;
    foreach(['post_id', 'author', 'text'] as $attr) {
        $result = $comment->validate($attr, $$attr);
        (true === $result) ? $comment->__set($attr, $$attr) : $errorInfo .= $result .'<br />';
}
    if(!$errorInfo) {
        $save = $comment->save();
        $result = [
            'author' => $author,
            'text' => $text,
            'ip' => $comment->getIP(),
            'created_at' => $comment->getCreatedAt(),
        ];        
    }
    else {
        $result = ['errorInfo' => $errorInfo];
    }
    
    echo json_encode($result);
    $result = false;

}



