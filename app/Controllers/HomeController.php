<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\FavoriteModel;
use App\Models\ProductModel;
use App\Models\ProductVariantModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class HomeController extends BaseController
{
    public function index($categoryId = null)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // Tüm kategoriler
        $data['categories'] = $categoryModel->findAll();

        if ($categoryId) {
            // Seçili kategoriye ait ürünleri getir
            $data['products'] = $productModel->where('category_id', $categoryId)->findAll();

            // Geçerli kategori var mı diye kontrol edelim (opsiyonel)
            $currentCategory = $categoryModel->find($categoryId);
            if (!$currentCategory) {
                throw PageNotFoundException::forPageNotFound("Kategori bulunamadı!");
            }
            $data['currentCategory'] = $currentCategory['name'];
        } else {
            // Kategori seçilmemişse tüm ürünleri getir
            $data['products'] = $productModel->findAll();
            $data['currentCategory'] = null;
        }

        $data['userFavorites'] = [];
        if (session()->get('logged_in')) {
            $userId = session()->get('user_id');
            $favoriteModel = new \App\Models\FavoriteModel();
            // Bu kullanıcının TÜM favorilerini çekelim (product_id -> favorites.id eşlemesi de lazım)
            $favs = $favoriteModel
                ->select('favorites.id as fav_id, favorites.product_id')
                ->where('user_id', $userId)
                ->findAll();

            // product_id -> fav_id şeklinde dizi yapısı oluşturalım
            foreach ($favs as $f) {
                $data['userFavorites'][$f['product_id']] = $f['fav_id'];
            }
        }

        return view('HomeView', $data);
    }

    public function detail($id)
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();
        $variantModel  = new ProductVariantModel();

        // Ürün bilgisi
        $product = $productModel->find($id);
        if (!$product) {
            throw PageNotFoundException::forPageNotFound("Ürün bulunamadı!");
        }

        $category = $categoryModel->find($product['category_id']);

        $variants = $variantModel
            ->where('product_id', $id)
            ->findAll();

        $favorite= null;
        if (session()->get('logged_in')) {
            $userId = session()->get('user_id');
            $favoriteModel = new FavoriteModel();
            $fav = $favoriteModel
                ->where('user_id', $userId)
                ->where('product_id', $id)
                ->first();
            if ($fav) {
                $favorite = $fav['id'];  // favorites tablosundaki primary key
            }
        }

        // View'e gönderilecek veriler
        $data = [
            'product'       => $product,
            'variants'      => $variants,
            'category_type' => $category['type'] ?? null,
            'favoriteId' => $favorite
        ];

        // Ürün detay sayfasını göster
        return view('ProductDetailView', $data);
    }
}
