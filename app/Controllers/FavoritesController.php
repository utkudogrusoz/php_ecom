<?php

namespace App\Controllers;

use App\Models\FavoriteModel;
use App\Models\ProductModel;

class FavoritesController extends BaseController
{
    public function index()
    {
        // Kullanıcının favorilerini listeleme
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = $this->session->get('user_id');
        $favoriteModel = new FavoriteModel();

        // JOIN ile ürün bilgilerini de alabiliriz
        // favorites -> products
        $db = db_connect();
        $sql = "
            SELECT favorites.id as fav_id,
                   products.id as product_id,
                   products.name as product_name,
                   products.price as product_price,
                   products.image as product_image
            FROM favorites
            JOIN products ON products.id = favorites.product_id
            WHERE favorites.user_id = ?
        ";

        $query = $db->query($sql, [$userId]);
        $favorites = $query->getResultArray();

        return view('FavoritesView', ['favorites' => $favorites]);
    }

    public function add($productId)
    {
        // Ürünü favorilere ekleme
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = $this->session->get('user_id');
        $favoriteModel = new FavoriteModel();

        // Ürün var mı kontrol
        $productModel = new ProductModel();
        $product = $productModel->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Ürün bulunamadı!');
        }

        // Zaten favoride mi kontrol (unique constraint yakalayabilir, ama manual de bakabiliriz)
        $exists = $favoriteModel->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Bu ürün zaten favorilerinizde!');
        }

        // Favorilere ekle
        $favoriteModel->insert([
            'user_id'    => $userId,
            'product_id' => $productId
        ]);

        return redirect()->back()->with('success', 'Ürün favorilere eklendi.');
    }

    public function remove($id)
    {
        // Favoriden çıkarma
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = $this->session->get('user_id');
        $favoriteModel = new FavoriteModel();

        // favori kaydını bulalım
        $favorite = $favoriteModel->find($id);
        if (!$favorite) {
            return redirect()->back()->with('error', 'Favori kaydı bulunamadı!');
        }

        // Bu favori, giriş yapan kullanıcıya mı ait?
        if ($favorite['user_id'] != $userId) {
            return redirect()->back()->with('error', 'Bu favoriyi silme yetkiniz yok!');
        }

        // Sil
        $favoriteModel->delete($id);
        return redirect()->back()->with('success', 'Ürün favorilerden çıkarıldı.');
    }
}
