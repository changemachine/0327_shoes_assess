<?php

    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

    require_once "src/Store.php";
    require_once "src/Brand.php";


    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Store::deleteAll();
            Brand::deleteAll();
        }

    //SET n GET PROPERTIES
        function test_setName(){
            //Arrange
            $name = "Newt Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            //Act
            $test_store->setName("New Shoes");
            $test_store->save();

            //$result = array();
            $result = $test_store->getName();

            //Assert
            $this->assertEquals("New Shoes", $result);
        }

    //SAVE, GET-ALL, DELETE-ALL

        function test_save(){
            //Arrange
            $name = "New Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store, $result[0]);
        }

        function test_getAll(){
            //Arrange
            $name = "New Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Shootopia";
            $id2 = 2;
            $test_store2 = new Store($name2, $id2);
            $test_store2->save();

            //Act
            $result = Store::getAll();
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_deleteAll(){
            //Arrange
            $name = "New Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Shootopia";
            $id2 = 2;
            $test_store2 = new Store($name2, $id2);
            $test_store2->save();

            //Act
            Store::deleteAll();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        //FIND, UPDATE & DELETE STORE
        function test_find(){
            //Arrange
            $name = "New Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Shootopia";
            $id2 = 2;
            $test_store2 = new Store($name2, $id2);
            $test_store2->save();

            //Act
            $result = Store::find($test_store2->getId());

            //Assert
            $this->assertEquals($test_store2, $result);
        }

        function test_update(){
            //Arrange
            $name = "New Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();
            $new_name = "Shootropolis";

            //Act
            $test_store->update($new_name);

            //Assert
            $this->assertEquals('Shootropolis', $test_store->getName());
        }

        function test_deleteStore(){
            //Arrange
            $name = "New Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Shoo Fever";
            $id2 = 2;
            $test_store2 = new Store($name2, $id2);
            $test_store2->save();

            //Act
            $test_store->deleteStore();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store2], $result);

        }

    //JOIN
        function test_addStoreBrand(){
            //Arrange
            $name = "New Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $brand_name = "Keds";
            $id = 1;
            $new_brand = new Brand($brand_name, $id);
            $new_brand->save();

            $brand_name2 = "Roos";
            $id2 = 2;
            $new_brand2 = new Brand($brand_name2, $id2);
            $new_brand2->save();

            //Act
            $test_store->addStoreBrand($new_brand);
            $test_store->addStoreBrand($new_brand2);

            //Assert
            $this->assertEquals($test_store->getStoreBrands(), [$new_brand, $new_brand2]);
        }

        function test_getStoreBrands(){
            //Arrange
            $name = "New Shoes";
            $id = 1;
            $test_store = new Store($name, $id);
            $test_store->save();

            $brand_name = "Keds";
            $id = 1;
            $new_brand = new Brand($brand_name, $id);
            $new_brand->save();

            $brand_name2 = "Roos";
            $id2 = 2;
            $new_brand2 = new Brand($brand_name2, $id2);
            $new_brand2->save();

            //Act
            $test_store->addStoreBrand($new_brand);
            $test_store->addStoreBrand($new_brand2);
            $result = $test_store->getStoreBrands();

            //Assert
            $this->assertEquals([$new_brand, $new_brand2], $result);
        }







    }

?>
