<?php

    class Store
    {

        private $name;
        private $id;

        function __construct($name, $id){
            $this->name = $name;
            $this->id = $id;
        }

    //SET GET PROPS

        function setName($new_name){
            $this->name = (string) $new_name;
        }

        function getStoreName(){
            return $this->name;
        }

        function setId($new_id){
            $this->id = (int) $new_id;
        }

        function getId(){
            return $this->id;
        }

    //SAVE GET-ALL, DELETE-ALL

        function save(){
            $statement = $GLOBALS['DB']->query("INSERT INTO stores (name) VALUES ('{$this->getStoreName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll(){
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach ($returned_stores as $store){
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM stores *;");
        }


    // √ FIND, UPDATE & DELETE STORE

        static function find($search_id){
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store){
                $store_id = $store->getId();
                if($store_id == $search_id){
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        function updateStore($new_name){
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function deleteStore(){ //?
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
        }

    // JOIN
        function addStoreBrand($brand){
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$this->getId()}, {$brand->getId()});");
        }

        function getStoreBrands(){
            $query = $GLOBALS['DB']->query("SELECT brands.* FROM stores
                JOIN stores_brands ON (stores.id = stores_brands.store_id)
                JOIN brands ON (stores_brands.brand_id = brands.id)
                WHERE stores.id = {$this->getId()};");
            $returned_brands = $query->fetchAll(PDO::FETCH_ASSOC);
            $brands = array();
            foreach($returned_brands as $brand){
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }




    }

?>
