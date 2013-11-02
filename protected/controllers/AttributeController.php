<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttributeController
 *
 * @author Alex Hoang
 */
class AttributeController extends CTController {

    public function actionView($productID) {
        //get the product atrributes list
        //get the product info
        $product = new Product($productID);
        $productData = $product->getData();
        $attributes = $product->getProductAttributes();
        $productData['picUrls'] = Pictures::getProductPictures($productID);
        $this->render('view', array(
            'product' => $productData,
            'attributes' => $attributes,
            'colors' => Color::getAll(),
            'sizes' => Size::getAll(),
        ));
    }

    public function actionAdd() {
        if (isset($_POST)) {
            $newAtt = $_POST;
            $model = new Attribute();
            $model->setVal('size_id', $newAtt['size_id']);
            $model->setVal('color_id',$newAtt['color_id']);
            if (!$model->checkExists()) {
                $model->setData($newAtt);
                $model->create();
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                echo 'that attribute already existed';
            }
        }
    }

    public function actionUpdate() {
        if (isset($_POST)) {
            $model = new Attribute();
            $model->setData($_POST);
            if ($model->update()) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                echo "update failed";
            }
        }
    }

    public function actionDelete($id) {
        $model = new Attribute($id);
        if ($model->delete()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo 'Cannot delete';
        }
    }

}
