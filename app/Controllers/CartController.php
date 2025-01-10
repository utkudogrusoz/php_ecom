<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductVariantModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CartController extends BaseController
{
    public function index()
    {
        // Kullanıcının sepetini listeler
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = $this->session->get('user_id');
        $cartModel = new CartModel();

        // cart tablosundan variant bilgileriyle birlikte verileri çekmek
        // product_variants -> products JOIN de isteğe göre eklenebilir
        $db = db_connect();
        $sql = "
            SELECT cart.id AS cart_id, 
                   cart.variant_id, 
                   cart.quantity,
                   product_variants.variant_value,
                   product_variants.stock AS variant_stock,
                   products.name AS product_name,
                   products.price AS product_price
            FROM cart
            JOIN product_variants ON product_variants.id = cart.variant_id
            JOIN products         ON products.id = product_variants.product_id
            WHERE cart.user_id = ?
        ";
        $query = $db->query($sql, [$userId]);
        $cartItems = $query->getResultArray();

        $data['cartItems'] = $cartItems;
        return view('CartView', $data);
    }

    public function add()
    {
        // Sepete ekleme işlemi
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $variantId = $this->request->getPost('variant_id');
        $quantity  = (int) $this->request->getPost('quantity');
        $userId    = $this->session->get('user_id');

        if (!$variantId || $quantity < 1) {
            return redirect()->back()->with('error', 'Geçersiz istek!');
        }

        // Variant var mı, stok uygun mu kontrol edelim
        $variantModel = new ProductVariantModel();
        $variant = $variantModel->find($variantId);
        if (!$variant) {
            return redirect()->back()->with('error', 'Varyant bulunamadı!');
        }

        // Stok kontrolü
        if ($quantity > $variant['stock']) {
            return redirect()->back()->with('error', 'Stok yetersiz!');
        }

        // Aynı varyant sepette varsa miktarı arttıralım
        $cartModel = new \App\Models\CartModel();
        $existing = $cartModel
            ->where('user_id', $userId)
            ->where('variant_id', $variantId)
            ->first();

        if ($existing) {
            // Güncel quantity
            $newQuantity = $existing['quantity'] + $quantity;

            // Tekrar stok kontrolü
            if ($newQuantity > $variant['stock']) {
                return redirect()->back()->with('error', 'Stok yetersiz!');
            }

            // Sepetteki kaydı güncelle
            $cartModel->update($existing['id'], [
                'quantity' => $newQuantity
            ]);
        } else {
            // Yeni sepet kaydı
            $cartModel->insert([
                'user_id'    => $userId,
                'variant_id' => $variantId,
                'quantity'   => $quantity
            ]);
        }

        return redirect()->to('/cart')->with('success', 'Ürün sepete eklendi.');
    }

    public function remove($cartId)
    {
        // Sepetten ürün kaldırma
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $cartModel = new CartModel();
        $userId = $this->session->get('user_id');

        $item = $cartModel->find($cartId);
        if (!$item) {
            return redirect()->back()->with('error', 'Sepet öğesi bulunamadı!');
        }

        // Bu ürün kullanıcının sepetine mi ait kontrol
        if ($item['user_id'] != $userId) {
            return redirect()->back()->with('error', 'Bu ürünü kaldırma yetkiniz yok!');
        }

        // Silme işlemi
        $cartModel->delete($cartId);

        return redirect()->to('/cart')->with('success', 'Ürün sepetten kaldırıldı.');
    }

    public function checkout()
    {
        // Ödeme & sipariş tamamlama ekranına yönlendirme
        // (Sadece basit bir "checkout" view gösterebiliriz veya
        //  OrdersController::complete metoduna gitmeden önce adres vs. alabiliriz.)
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('CheckoutView');
    }
}
