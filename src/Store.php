<?php

    class Author{

    private $author;
    private $id;

    function __construct($author, $id){
        $this->author = $author;
        $this->id = $id;
    }

    //SET GET PROPS
    function setAuthor($new_author){
        $this->author = (string) $new_author;
    }

    function getAuthor(){
        return $this->author;
    }

    function setId($new_id){
        $this->id = (int) $new_id;
    }

    function getId(){
        return $this->id;
    }

    //SAVE GET-ALL, DELETE-ALL
    function save(){
        $statement = $GLOBALS['DB']->query("INSERT INTO authors (author) VALUES ('{$this->getAuthor()}') RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }

    static function getAll(){
        $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
        $authors = array();
        foreach ($returned_authors as $r_author){
            $author = $r_author['author'];
            $id = $r_author['id'];
            $new_author = new Author($author, $id);
            array_push($authors, $new_author);
        }
        return $authors;
    }

    static function deleteAll(){
        $GLOBALS['DB']->exec("DELETE FROM authors *;");
    }


    // √ FIND BY AUTHOR, UPDATE & DELETE AUTHOR
    static function find($search_id){
        $found_author = null;
        $authors = Author::getAll();
        foreach($authors as $author){
            $author_id = $author->getId();
            if($author_id == $search_id){
                $found_author = $author;
            }
        }
        return $found_author;
    }

    function update($new_author){
        $GLOBALS['DB']->exec("UPDATE authors SET author = '{$new_author}' WHERE id = {$this->getId()};");
        $this->setAuthor($new_author);
    }

    function deleteAuthor(){
        $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
        // JOIN TABLE!
    }

    function addBook($book){
        $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
    }

    function getBooks(){
        $query = $GLOBALS['DB']->query("SELECT books.* FROM authors JOIN authors_books ON (authors.id = authors_books.author_id) JOIN books ON (authors_books.book_id = books.id) WHERE authors.id = {$this->getId()};");

        $returned_books = $query->fetchAll(PDO::FETCH_ASSOC);

        $books = array();
        foreach($returned_books as $r_book){
            $title = $r_book['title'];
            $genre = $r_book['genre'];
            $id = $r_book['id'];
            $new_book = new Book($title, $genre, $id);
            array_push($books, $new_book);
        }
        return $books;
    }




    }

?>
