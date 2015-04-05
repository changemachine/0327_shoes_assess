<?php

    require_once __DIR__."/../vendor/autoload.php";
    //Don't forget AUTOLOAD EVER AGAIN!
    require_once __DIR__.'/../src/Store.php';
    require_once __DIR__.'/../src/Brand.php';

    $app = new Silex\Application();

    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes');

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

//HOME, DISPLAY ALL BRANDS.
    $app->get("/", function() use($app){
        return $app['twig']->render('index.twig', array('brands'=> Brand::getAll(), 'stores'=> Store::getAll()));
    });

////BRANDS===============BRANDS===============BRANDS===============
    //-- CREATE A BRAND
    $app->post("/new_brand", function() use($app) {
        $brand_name = $_POST['brand_name'];
        $id = null;
        $new_brand = new Brand($brand_name, $id);
        $new_brand->save();
        return $app['twig']->render('index.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    //-- SINGLE BRAND DISPLAY
    $app->get('/brand/{id}', function($id) use($app){
        $brand = Brand::findBrand($id);
        return $app['twig']->render('brand.twig', array('brand' => $brand, 'brand_stores' => $brand->getBrandStores(), 'stores' => Store::getAll()));
    });

    //-- DELETE BRAND
    $app->post("/brand/{id}/delete", function($id) use($app){
        $brand = Brand::findBrand($id);
        $brand->deleteBrand($id);
        return $app->redirect('/');
    });

    //-- DELETE ALL BRANDS
    $app->post("/delete_brands", function() use($app){
        Brand::deleteAll();
        return $app['twig']->render('index.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    //-- EDIT BRAND --------------------
    $app->get("/brand/{id}/edit", function($id) use ($app){
        $brand = Brand::findBrand($id);
        return $app['twig']->render('brand_edit.twig', array('brand' => $brand, 'brand_stores' => $brand->getBrandStores(), 'stores' => Store::getAll()));
    });
    $app->post("/brand/{id}/edit", function($id) use ($app){
        $brand = Brand::findBrand($id);
        $new_name = $_POST['brand_name'];
        $brand->updateBrand($new_name);
        return $app['twig']->render('brand_edit.twig', array('brand' => $brand, 'brand_stores' => $brand->getBrandStores(), 'stores' => Store::getAll()));
    });

    //-- ADD STORE TO BRAND
    $app->post('/brand/{id}/add_store', function($id) use($app){
        $brand = Brand::findBrand($id);
        //if(isset(add_store...?  ));
        $add_stores = $_POST['select_stores'];
        foreach($add_stores as $store){
            $brand->addStoreToBrand($store);
        }
        return $app['twig']->render('brand.twig', array('brand' => $brand, 'brand_stores' => $brand->getBrandStores(), 'stores' => Store::getAll()));
    });

    //-- DROP STORE ASSOCIATIONS
    $app->post('/brand/{id}/drop_store', function($id) use($app){
        $brand = Brand::findBrand($id);
        //if(isset(add_store...?  ));
        $drop_stores = $_POST['select_stores'];
        foreach($drop_stores as $store){
            $brand->dropStore($store);
            //? $brand->save();
        }
        return $app['twig']->render('brand.twig', array('brand' => $brand, 'brand_stores' => $brand->getBrandStores(), 'stores' => Store::getAll()));
    });


////// STORES =========================STORES =========================
    $app->get('/store/{id}', function($id) use($app){
        $store = Store::findStore($id);
        return $app['twig']->render('store.twig', array('store' => $store, 'store_brands' => $store->getStoreBrands(), 'brands' => Brand::getAll()));
    });
    //-- CREATE A STORE
    $app->post("/new_store", function() use($app) {
        $name = $_POST['name'];
        $id = null;
        $new_store = new Store($name, $id);
        $new_store->save();
        return $app['twig']->render('index.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });
    //-- DELETE STORE (need get?)
    $app->post("/store/{id}/delete", function($id) use($app){
        $store = Store::findStore($id);
        $store->deleteStore($id);
        return $app->redirect('/');
    });
    //-- DELETE ALL STORES
    $app->post("/delete_stores", function() use($app){
        Store::deleteAll();
        return $app['twig']->render('index.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    //-- EDIT STORE --------------------
    $app->get("/store/{id}/edit", function($id) use ($app){
        $store = Store::findStore($id);
        return $app['twig']->render('store_edit.twig', array('store' => $store, 'store_brands' => $store->getStoreBrands(), 'stores' => Brand::getAll()));
    });

    $app->post("/store/{id}/edit", function($id) use ($app){
        $store = Store::findStore($id);
        $new_name = $_POST['store_name'];
        $store->updateStore($new_name);
        return $app['twig']->render('store_edit.twig', array('store' => $store, 'store_brands' => $store->getStoreBrands(), 'brands' => Brand::getAll()));
    });

    // DELETE AND UPDATE STORE ASSOCIATIONS








    return $app;


?>
