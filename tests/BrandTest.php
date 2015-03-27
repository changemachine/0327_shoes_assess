<?php


    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    require_once "src/Author.php";
    require_once "src/Book.php";
    require_once "src/Copy.php";
    require_once "src/Patron.php";
    require_once "src/Checkout.php";

    class BookTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Author::deleteAll();
            Book::deleteAll();
            Copy::deleteAll();
            Patron::deleteAll();
            Checkout::deleteAll();
        }

        // SET & GET PROPERTIES

        //SAVE GET-ALL, DELETE-ALL
        function test_save()
        {
            //Arrange
            $title = "Create Dangerously";
            $genre = "Memoir";
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            //Act
            $test_book->save();

            //Assert
            $result = Book::getAll();
            $this->assertEquals($test_book, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
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
            $result = Book::getAll();
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
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
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        //FIND BY AUTHOR, UPDATE & DELETE AUTHOR
        function test_find()
        {
            //Arrange
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
            $result = Book::find($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);
        }

        function test_update()
        {
            //Arrange
            $title = "Create Dangerously";
            $genre = "Memoir";
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();
            $new_title = "Sam Clemens";
            $new_genre = "Willa Cather";

            //Act
            $test_book->update($new_title, $new_genre);

            //Assert
            $this->assertEquals(['Sam Clemens', 'Willa Cather'], [$test_book->getTitle(), $test_book->getGenre()]);
        }

        function test_deleteAuthor()
        {
            //Arrange
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
            $test_book2->deleteBook();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book], $result);

        }

        // CREATE, GET COPIES
        function test_addCopy()
        {
            //Arrange
            $title = "Create Dangerously";
            $genre = "Memoir";
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            //Act
            $test_book->addCopy();
            $result = $test_book->getCopies();
            //Assert
            $this->assertEquals(1, $result);
        }

        function test_getCopies()
        {
            $title = "Create Dangerously";
            $genre = "Memoir";
            $id = 1;
            $test_book = new Book($title, $genre, $id);
            $test_book->save();

            $test_book->addCopy();
            $test_book->addCopy();

            $result = $test_book->getCopies();
            $this->assertEquals(2, $result);
        }








    }

?>
