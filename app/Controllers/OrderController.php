<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\CartModel;
use App\Models\ProductVariantModel;

class OrderController extends BaseController
{
    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $userId = $this->session->get('user_id');

        $orders = $orderModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('OrdersView', ['orders' => $orders]);
    }

    public function complete()
    {
        // Giriş kontrolü
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId          = $this->session->get('user_id');
        $cartModel       = new CartModel();
        $variantModel    = new ProductVariantModel();
        $orderModel      = new OrderModel();
        $orderDetailsModel = new OrderDetailsModel();

        // Sepet Kalemlerini Çek
        $cartItems = $cartModel
            ->select('cart.*, 
                      product_variants.stock AS variant_stock, 
                      product_variants.variant_value,
                      product_variants.id AS variant_real_id, 
                      product_variants.product_id,
                      products.name AS product_name,
                      products.price as product_price')
            ->join('product_variants', 'product_variants.id = cart.variant_id')
            ->join('products', 'products.id = product_variants.product_id')
            ->where('cart.user_id', $userId)
            ->findAll();

        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Sepetiniz boş!');
        }

        // Sipariş Toplamı + JSON Dizisi Oluşturma
        $totalAmount = 0;
        $lineItems   = [];  // JSON için ürün kalemlerini toplayacağız

        foreach ($cartItems as $item) {
            $subtotal    = $item['product_price'] * $item['quantity'];
            $totalAmount += $subtotal;

            // JSON'a yazmak için diziye ekle
            $lineItems[] = [
                'product_name'  => $item['product_name'],
                'variant_value' => $item['variant_value'],
                'quantity'      => $item['quantity'],
                'unit_price'    => $item['product_price'],
                'subtotal'      => $subtotal
            ];
        }

        // Transaction Başlat
        $db = db_connect();
        $db->transStart();

        // 1) orders tablosuna ekle
        // items_json'ı şimdilik boş string olarak kaydediyoruz
        $orderId = $orderModel->insert([
            'user_id'      => $userId,
            'total_amount' => $totalAmount,
            'items_json'   => ''  // Sonradan güncelleyeceğiz
        ]);

        // 2) order_details ve stok güncelle
        foreach ($cartItems as $item) {
            // Stok kontrolü
            $newStock = $item['variant_stock'] - $item['quantity'];
            if ($newStock < 0) {
                // Hata fırlat
                throw new \Exception('Stok yetersiz! Ürün: '.$item['product_name']);
            }


            // product_variants stok düş
            $variantModel->update($item['variant_real_id'], [
                'stock' => $newStock
            ]);
        }

        // 3) JSON veriyi encode ederek orders tablosuna güncelle
        $encodedJson = json_encode($lineItems, JSON_UNESCAPED_UNICODE);
        $orderModel->update($orderId, [
            'items_json' => $encodedJson
        ]);

        // 4) Sepeti Temizle
        $cartModel->where('user_id', $userId)->delete();

        // Transaction Tamamla
        $db->transComplete();
        if ($db->transStatus() === false) {
            // Hata oldu, rollback
            $db->transRollback();
            return redirect()->to('/cart')->with('error', 'Sipariş oluşturulamadı! (Transaction Error)');
        }

        // Başarılı
        return redirect()->to('/orders')->with('success', 'Siparişiniz başarıyla oluşturuldu.');
    }

    public function details($orderId)
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $userId = $this->session->get('user_id');

        // İlgili siparişi çek
        $order = $orderModel
            ->where('id', $orderId)
            ->where('user_id', $userId) // sadece kullanıcıya ait sipariş
            ->first();

        if (!$order) {
            throw PageNotFoundException::forPageNotFound("Sipariş bulunamadı veya erişiminiz yok!");
        }

        // JSON veriyi decode edelim
        $itemsJson = $order['items_json'] ?? '';
        $lineItems = [];
        if (!empty($itemsJson)) {
            $decoded = json_decode($itemsJson, true);
            if (is_array($decoded)) {
                $lineItems = $decoded;
            }
        }

        $data = [
            'order'     => $order,
            'lineItems' => $lineItems
        ];

        return view('OrderDetailView', $data);
    }



}
