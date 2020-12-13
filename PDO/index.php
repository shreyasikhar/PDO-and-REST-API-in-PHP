<?php 
    $host = "localhost";
    $user = "phpmyadmin";
    $password = "yayati23";
    $dbname = "pdoposts";

    // set DSN (Data Source Name)
    $dsn = 'mysql:host='. $host .';dbname='. $dbname;

    // create a PDO instance
    $pdo = new PDO($dsn, $user, $password);

    // to set default attribute for fetching data
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    // to remove placeholder for limit value in sql
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    # PDO Query

    // $stmt = $pdo->query('select * from posts');

    // while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //     echo $row['title']. '<br/>';
    // }

    // echo "<br/>";

    // while($row = $stmt->fetch()) {
    //     echo $row->title. '<br/>';
    // }


    # Prepared Statements (Prepare & Execute)

    // Unsafe way
    // $sql = "select * from posts where author = '$author'";


    // Fetch Multiple Posts

    // User Inputs
    $author = "Shreyas";
    $is_published = true;
    $id = 1;

    // Positional Parameters
    // $sql = "select * from posts where author = ? && is_published = ?";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([$author, $is_published]);
    // $posts = $stmt->fetchAll();

    // Named Parameters
    // $sql = "select * from posts where author = :author && is_published = :is_published";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['author' => $author, 'is_published' => $is_published]);
    // $posts = $stmt->fetchAll();

    // var_dump($posts);

    // foreach($posts as $post) {
    //     echo $post->title . "<br/>";
    // }


    // Fetch Single Post
    
    // $sql = "select * from posts where id = ?";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([$id]);
    // $post = $stmt->fetch();
    // echo $post->body;


    // Get The Row Count

    // $stmt = $pdo->prepare('select * from posts where author = ?');
    // $stmt->execute([$author]);
    // $postCount = $stmt->rowCount();
    // echo $postCount;


    // Insert Data

    // $title = "Post 5";
    // $body = "This is a post five";
    // $author = "Kevin";

    // $sql = "insert into posts(title, body, author) values (:title, :body, :author)";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['title' => $title, 'body' => $body, 'author' => $author]);
    // echo "Post Added";


    // Update Data

    // $id = 1;
    // $body = "This is an updated post";

    // $sql = "update posts set body = :body where id = :id";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['body' => $body, 'id' => $id]);
    // echo "Post Updated";


    // Delete Data

    // $id = 3;

    // $sql = "delete from posts where id = :id";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['id' => $id]);
    // echo "Post Deleted";


    // Search Data

    $search = "%1%";
    $sql = "select * from posts where title like ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$search]);
    $posts = $stmt->fetchAll();

    foreach($posts as $post) {
        echo $post->title . "<br/>";
    }
?>