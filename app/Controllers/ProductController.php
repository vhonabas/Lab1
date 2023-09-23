<?php

// App/Controllers/ProductController.php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel; // Import the existing ProductModel
use App\Models\TableCategoryModel; // Import the new TableCategoryModel

class ProductController extends BaseController
{
    private $product;
    private $tablecategory; // Add a private property for the TableCategoryModel

    public function __construct()
    {
        $this->product = new ProductModel();
        $this->tablecategory = new TableCategoryModel(); // Initialize the TableCategoryModel
    }

    public function delete($id)
    {
        $this->product->delete($id);
        return redirect()->to('/product');
    }

    public function edit($id)
    {
        $data = [
            'product' => $this->product->findAll(),
            'pro' => $this->product->where('id', $id)->first(),
        ];

        if (!$data['pro']) {
            echo 'ERROR';
        }

        return view('products', $data);
    }

    public function save()
    {
        $id = $_POST['id'];
        $data = [
            'ProductName' => $this->request->getVar('ProductName'),
            'ProductDescription' => $this->request->getVar('ProductDescription'),
            'ProductCategory' => $this->request->getVar('ProductCategory'),
            'ProductQuantity' => $this->request->getVar('ProductQuantity'),
            'ProductPrice' => $this->request->getVar('ProductPrice'),
        ];

        if ($id != null) {
            $this->product->set($data)->where('id', $id)->update();
        } else {
            $this->product->save($data);
        }

        // Save data to the TableCategoryModel as well
        $sectionData = 
        [
            'ProductCategory' => $this->request->getVar('ProductCategory'),
        ];

        $this->tablecategory->save($sectionData);

        return redirect()->to('/product');
    }

    public function product($product)
    {
        echo $product;
    }

    public function chalsim()
    {
        $data['product'] = $this->product->findAll();
        return view('products', $data);
    }

    public function index()
    {
        //
    }
}
