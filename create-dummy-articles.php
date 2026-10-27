<?php
    require_once "init.php";

    if(isPostRequest()) {

        $article = new Article();

        if($article->generateDummyData($_POST['article_count'])) {
            redirect("admin.php");
        } else {
            echo "Failed to generate dummy data.";
        }
    }

?>