<?php 
    class Post {
        // DB Stuff
        private $conn;
        private $table = "posts";

        // Posts properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get posts 
        public function read() {
            // create query
            $query = "SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
                FROM
                " . $this->table . " p
                LEFT JOIN 
                    categories c on p.category_id = c.id
                ORDER BY 
                    p.created_at DESC";
            
            // prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }


        // Get single post 
        public function read_single() {
            // create query
            $query = "SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM
            " . $this->table . " p
            LEFT JOIN 
                categories c on p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT 0, 1";

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // bind param
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }

        // Create Post
        public function create() {
            // create query
            $query = "INSERT INTO " . $this->table ."
                SET 
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id";

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            // execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }


        // Update Post
        public function update() {
            // create query
            $query = "UPDATE " . $this->table ."
                SET 
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                WHERE 
                    id = :id";

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            // execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }


        // Delete Post
        public function delete() {
            // create query
            $query = "DELETE FROM " . $this->table ."
                WHERE 
                    id = :id";

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // bind data
            $stmt->bindParam(':id', $this->id);

            // execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
?>