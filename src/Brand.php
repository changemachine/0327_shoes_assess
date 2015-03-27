<?php

    class Brand {

        private $brand_name;
        private $id;

        function __construct($brand_name, $id){
            $this->brand_name = $brand_name;
            $this->id = $id;
        }

        //SET GET PROPS
        function setBrandName($new_brand_name){
            $this->brand_name = (string) $new_brand_name;
        }
        function getBrandName(){
            return $this->brand_name;
        }

        function setId($new_id){
            $this->id = (int) $new_id;
        }
        function getId(){
            return $this->id;
        }

        //SAVE GET-ALL, DELETE-ALL
        function save(){
            $statement = $GLOBALS['DB']->query("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll(){
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach ($returned_brands as $brand){
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
        }


    // √ FIND, UPDATE & DELETE BRAND

        static function findBrand($search_id){
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand){
                $brand_id = $brand->getId();
                if($brand_id == $search_id){
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        function update($new_brand_name){
            $GLOBALS['DB']->exec("UPDATE brands SET brand_name = '{$new_brand_name}' WHERE id = {$this->getId()};");
            $this->setBrandName($new_brand_name);
        }

        function deleteBrand(){ //UNTESTED JOIN-TABLE DELETE
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE id = {$this->getId()};");
        }

        function addStore($store){
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

        function getStores(){
            $query = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                JOIN stores_brands ON (brands.id = stores_brands.brand_id)
                JOIN stores ON (stores_brands.store_id = stores.id)
                WHERE brands.id = {$this->getId()};");
            $returned_stores = $query->fetchAll(PDO::FETCH_ASSOC);
            $stores = array();
            foreach($returned_stores as $store){
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        // function addPair() ADD INSTANCES OF SHOES
        // {
        //     $GLOBALS['DB']->exec("INSERT INTO copies (brand_id) VALUES ({$this->getId()});");
        // }
        //
        // function getCopies()
        // {
        //     $query = $GLOBALS['DB']->query("SELECT brand_id, count(1) FROM copies WHERE brand_id = {$this->getId()} GROUP BY brand_id;");
        //
        //     $returned_copies = $query->fetchAll(PDO::FETCH_ASSOC);
        //
        //         $count = $returned_copies[0]['count'];
        //         return $count;
        //     }
        //
        // }

?>
