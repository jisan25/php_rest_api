<?php

class Category
{
    // DB stuff
    private $conn;
    private $table = 'categories';

    // Post Properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with DB

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Posts 

    public function read()
    {
        $query = 'SELECT 
        id,
        name
        FROM
        ' . $this->table . ' 
        ORDER BY
         created_at DESC';

        //  Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute Query

        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT 
        id,
        name
        FROM
        ' . $this->table . ' 
         WHERE 
         id = ?
         LIMIT 0,1';


        //  Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID

        $stmt->bindParam(1, $this->id);


        // Execute Query

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties

        $this->name = $row['name'];
    }

    // create post

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET
        name = :name
        ';

        // prepare statement

        $stmt = $this->conn->prepare($query);

        // clean data
        $this->name = htmlspecialchars(strip_tags($this->name));


        // Bind Data

        $stmt->bindParam(':name', $this->name);


        // Execute Query

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s. \n", $stmt->error);
        return false;
    }

    // update post

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET
        name = :name
       WHERE
        id = :id';

        // prepare statement

        $stmt = $this->conn->prepare($query);

        // clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        // Execute Query

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s. \n", $stmt->error);
        return false;
    }
    public function delete()
    {
        // delete query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // prepare statement

        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(':id', $this->id);

        // Execute Query

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s. \n", $stmt->error);
        return false;
    }
}
