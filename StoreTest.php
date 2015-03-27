<?php


    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    require_once "src/Store.php";
    require_once "src/Brand.php";


    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Author::deleteAll();
            Book::deleteAll();
            Copy::deleteAll();
            Patron::deleteAll();
            Checkout::deleteAll();
        }

        // SET & GET PROPERTIES
        function test_setAuthor()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);

            //Act
            $test_author->setAuthor("Samuel Clemens");
            $author = $test_author->getAuthor();

            //$result = array();
            $result1 = $test_author->getAuthor();

            //Assert
            $this->assertEquals($author, $result1);
        }

        //SAVE GET-ALL, DELETE-ALL
        function test_save()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);

            //Act
            $test_author->save();

            //Assert
            $result = Author::getAll();
            $this->assertEquals($test_author, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);
            $test_author->save();

            $author4 = "Mark Twain";
            $id2 = 2;
            $test_author2 = new Author($author4, $id2);
            $test_author2->save();

            //Act
            $result = Author::getAll();
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);
            $test_author->save();

            $author4 = "Mark Twain";
            $id2 = 2;
            $test_author2 = new Author($author4, $id2);
            $test_author2->save();

            //Act
            Author::deleteAll();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        //FIND BY AUTHOR, UPDATE & DELETE AUTHOR
        function test_find()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);
            $test_author->save();

            $author4 = "Mark Twain";
            $id2 = 2;
            $test_author2 = new Author($author4, $id2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        function test_update()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);
            $test_author->save();
            $new_author = "Sam Clemens";

            //Act
            $test_author->update($new_author);

            //Assert
            $this->assertEquals('Sam Clemens', $test_author->getAuthor());
        }

        function test_deleteAuthor()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);
            $test_author->save();

            $author4 = "Mark Twain";
            $id2 = 2;
            $test_author2 = new Author($author4, $id2);
            $test_author2->save();

            //Act
            $test_author2->deleteAuthor();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author], $result);

        }

        function test_addBook()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);
            $test_author->save();

            $title = "Create Dangerously";
            $genre = "Memoir";
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            $title2 = "Spiritual Economics";
            $genre2 = "Economics";
            $id2 = 2;
            $test_book2 = new Book($title2, $genre2, $id2);
            $test_book2->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        }

        function test_getBooks()
        {
            //Arrange
            $author = "Mark Twain";
            $id = 1;
            $test_author = new Author($author, $id);
            $test_author->save();

            $title = "Create Dangerously";
            $genre = "Memoir";
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            $title2 = "Spiritual Economics";
            $genre2 = "Economics";
            $id2 = 2;
            $test_book2 = new Book($title2, $genre2, $id2);
            $test_book2->save();

            //Act

            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);
            $result = $test_author->getBooks();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);

        }

















    }

?>
