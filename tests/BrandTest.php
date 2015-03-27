<?php

    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

    require_once "src/Store.php";
    require_once "src/Brand.php";

    class BrandTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Store::deleteAll();
            Brand::deleteAll();
        }

    // SET-GET PROPERTIES
        function test_setBrandName(){
            //Arrange
            $brand_name = "New Balance";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            //Act
            $test_brand->setBrandName("Newt Balance");
            $result = $test_brand->getBrandName();

            //Assert
            $this->assertEquals("Newt Balance", $result);
        }

        function test_setId(){
            //Arrange
            $brand_name = "Floppy Shoes";
            $id = 1;
            $new_brand = new Brand($brand_name, $id);
            $new_brand->save();

            //Act
            $new_brand->setId(2);

            //Assert
            $this->assertEquals(2, $new_brand->getId());
        }

    // SAVE GET-ALL, DELETE-ALL
        function test_save(){
            //Arrange
            $brand_name = "Keds";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals($test_brand, $result[0]);
        }

        function test_getAll(){
            //Arrange
            $brand_name = "Roos";
            $id = 1;
            $test_brand = new Brand($brand_name, $id);
            $test_brand->save();

            $brand_name2 = "Keds";
            $id2 = 2;
            $test_brand2 = new Brand($brand_name2, $id2);
            $test_brand2->save();

            //Act
            $result = Brand::getAll();
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_deleteAll(){
            //Arrange
            $brand_name = "Roos";
            $id = 1;
            $roos = new Brand($brand_name, $id);
            $roos->save();

            $brand_name2 = "Keds";
            $id2 = 2;
            $keds = new Brand($brand_name2, $id2);
            $keds->save();


            //Act
            Brand::deleteAll();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([], $result);
        }


    // FIND, UPDATE & DELETE BRAND
        function test_findBrand(){
            //Arrange
            $brand_name = "Roos";
            $id = 1;
            $roos = new Brand($brand_name, $id);
            $roos->save();

            $brand_name2 = "Keds";
            $id2 = 2;
            $keds = new Brand($brand_name2, $id2);
            $keds->save();

            //Act
            $result = Brand::findBrand($roos->getId());

            //Assert
            $this->assertEquals($roos, $result);//$result->id);
        }

        function test_update(){
            //Arrange
            $brand_name = "Roos";
            $id = 1;
            $roos = new Brand($brand_name, $id);
            $roos->save();

            //Act
            $rename = "Roosters";
            $roos->update($rename);

            //Assert
            $this->assertEquals('Roosters', $roos->getBrandName());
        }

        function test_deleteBrand(){ // Brand no longer available
            //Arrange
            $brand_name = "Nazi Boots";
            $id = 1;
            $naziboots = new Brand($brand_name, $id);
            $naziboots->save();
            //Act
            $naziboots->deleteBrand();
            $result = Brand::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

    // JOINS
        function test_addStoreToBrand(){ // + getBrandStores()
            //Arrange
            $brand_name = "Roos";
            $id = 1;
            $roos = new Brand($brand_name, $id);
            $roos->save();

            $name = "Payless";
            $id2 = 2;
            $payless = new Store($name, $id);
            $payless->save();

            //Act
            $roos->addStoreToBrand($payless);
            $result = $roos->getBrandStores();

            //Assert
            $this->assertEquals([$payless], $result);
        }



        function test_deleteStoreBrand(){ // Store drops brand
            //Arrange
            $brand_name = "Adidas";
            $id = 1;
            $adidas = new Brand($brand_name, $id);
            $adidas->save();

            $brand_name2 = "Roos";
            $id2 = 2;
            $roos = new Brand($brand_name2, $id2);
            $roos->save();

            //Act
            $adidas->deleteBrand();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$roos], $result);
        }










    }

?>
