<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\Customer_model;
use App\Models\ReviewModel;
use phpDocumentor\Reflection\Types\This;

class Shop extends BaseController
{

    protected $session;
    public function __construct()
    {
        $this->ReviewModel = new ReviewModel();
        $this->customer = new Customer_model();
        $this->product = new ProductModel();
        $this->session = \Config\Services::session();
        $this->session->start();
        helper('text');
    }

    public function product($id = 0, $sku = '')
    {
        if ($id == 0 || empty($sku)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            if ($this->product->is_product_exist($id, $sku)) {
                $data = $this->product->product_data($id);
                $product['sold'] = $this->product->sold($id);
                $product['product'] = $data;
                $product['title'] = 'Produk - ' . $data->name;
                $product['related_products'] = $this->product->related_products($data->id, $data->category_id);
                return view('themes\littlegreenery\shop\view_single_product', $product);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }

    public function cart()
    {
        $cart = \Config\Services::cart();
        $data['carts'] = $cart->contents();
        $data['total_cart'] = $cart->total();
        $data['title'] = 'Keranjang';
        $data['ongkir'] = ($data['total_cart'] >= get_settings('min_shop_to_free_shipping_cost')) ? 0 : get_settings('shipping_cost');
        $data['total_price'] = $data['total_cart'] + $data['ongkir'];
        return view('themes\littlegreenery\shop\cart', $data);
    }

    public function checkout($action = '')
    {

        $auth = service('authentication');
        if (!$auth->check()) {
            $coupon = $this->request->getPost('coupon_code');
            $quantity = $this->request->getPost('quantity');

            $this->session->set('_temp_coupon', $coupon);
            $this->session->set('_temp_quantity', $quantity);

            $this->session->set('redirect_url', current_url());
            return redirect()->route('login');
        }

        $cart = \Config\Services::cart();
        switch ($action) {

            default:
                $coupon = $this->request->getPost('coupon_code') ? $this->request->getPost('coupon_code') : $this->session->get('_temp_coupon');
                $quantity = $this->request->getPost('quantity') ? $this->request->getPost('quantity') : $this->session->get('_temp_quantity');

                if ($this->session->get('_temp_quantity') || $this->session->get('_temp_coupon')) {
                    $this->session->remove('_temp_coupon');
                    $this->session->remove('_temp_quantity');
                }

                $items = [];

                foreach ($quantity as $rowid => $qty) {
                    $items['rowid'] = $rowid;
                    $items['qty'] = $qty;
                }

                $cart->update($items);

                if (empty($coupon)) {
                    $discount = 0;
                    $disc = 'Tidak menggunkan kupon';
                } else {
                    if ($this->customer->is_coupon_exist($coupon)) {
                        if ($this->customer->is_coupon_active($coupon)) {
                            if ($this->customer->is_coupon_expired($coupon)) {
                                $discount = 0;
                                $disc = 'Kupon kadaluarsa';
                            } else {
                                $coupon_id = $this->customer->get_coupon_id($coupon);
                                $this->session->set('coupon_id', $coupon_id);

                                $credit = $this->customer->get_coupon_credit($coupon);
                                $discount = $credit;
                                $disc = '<span class="badge badge-success">' . $coupon . '</span> Rp ' . format_rupiah($credit);
                            }
                        } else {
                            $discount = 0;
                            $disc = 'Kupon sudah tidak aktif';
                        }
                    } else {
                        $discount = 0;
                        $disc = 'Kupon tidak terdaftar';
                    }
                }

                $items = [];

                foreach ($cart->contents() as $item) {
                    $items[$item['id']]['qty'] = $item['qty'];
                    $items[$item['id']]['price'] = $item['price'];
                }

                $subtotal = $cart->total();
                $ongkir = (int) ($subtotal >= get_settings('min_shop_to_free_shipping_cost')) ? 0 : get_settings('shipping_cost');

                $params['customer'] = $this->customer->data();
                $params['subtotal'] = $subtotal;
                $params['ongkir'] = ($ongkir > 0) ? 'Rp' . format_rupiah($ongkir) : 'Gratis';
                $params['total'] = $subtotal + $ongkir - $discount;
                $params['discount'] = $disc;
                $params['title'] = 'Checkout';

                $this->session->set('order_quantity', $items);
                $this->session->set('total_price', $params['total']);


                return view('themes\littlegreenery\shop\checkout', $params);
                break;
            case 'order':
                $quantity = $this->session->get('order_quantity');

                $user_id = (int)user_id();
                $coupon_id = $this->session->get('coupon_id');
                $order_number = $this->_create_order_number($quantity, $user_id, $coupon_id);
                $order_date = date('Y-m-d H:i:s');
                $total_price = $this->session->get('total_price');
                $total_items = count((array)$quantity);
                $payment = $this->request->getPost('payment');

                $name = $this->request->getPost('name');
                $phone_number = $this->request->getPost('phone_number');
                $address = $this->request->getPost('address');
                $note = $this->request->getPost('note');

                $delivery_data = array(
                    'customer' => array(
                        'name' => $name,
                        'phone_number' => $phone_number,
                        'address' => $address
                    ),
                    'note' => $note
                );

                $delivery_data = json_encode($delivery_data);

                $order = array(
                    'user_id' => $user_id,
                    'coupon_id' => $coupon_id,
                    'order_number' => $order_number,
                    'order_status' => 1,
                    'order_date' => $order_date,
                    'total_price' => $total_price,
                    'total_items' => $total_items,
                    'payment_method' => $payment,
                    'delivery_data' => $delivery_data
                );
                // dd($order);
                $order = $this->product->create_order($order);
                // dd($order);
                $items = [];
                $n = 0;
                foreach ((array)$quantity as $id => $data) {
                    $items[$n]['order_id'] = $order;
                    $items[$n]['product_id'] = $id;
                    $items[$n]['order_qty'] = $data['qty'];
                    $items[$n]['order_price'] = $data['price'];

                    $n++;
                }
                // dd($items);
                $this->product->create_order_items($items);

                $cart->destroy();
                $this->session->remove('order_quantity');
                $this->session->remove('total_price');
                $this->session->remove('coupon_id');

                $this->session->setFlashdata('order_flash', 'Order berhasil ditambahkan');
                return redirect()->to(base_url('customer_orders/view/' . $order));
                break;
        }
    }

    public function cart_api()
    {
        $cart = \Config\Services::cart();
        $action = $this->request->getGet('action');

        switch ($action) {
            case 'add_item':
                $cart->insert(array(
                    'id'      => $this->request->getPost('id'),
                    'qty'     => 1,
                    'price'   => $this->request->getPost('price'),
                    'name'    => $this->request->getPost('name'),
                    'options' => array(
                        'sku' => $this->request->getPost('sku'),
                    )
                ));
                $total_item = $cart->totalItems();

                $response = array('code' => 200, 'message' => 'Item dimasukkan dalam keranjang', 'total_item' => $total_item);
                break;
            case 'display_cart':
                $carts = [];

                foreach ($cart->contents() as $items) {
                    $carts[$items['rowid']]['id'] = $items['id'];
                    $carts[$items['rowid']]['name'] = $items['name'];
                    $carts[$items['rowid']]['qty'] = $items['qty'];
                    $carts[$items['rowid']]['price'] = $items['price'];
                    $carts[$items['rowid']]['subtotal'] = $items['subtotal'];
                }

                $response = array('code' => 200, 'carts' => $carts);
                break;
            case 'cart_info':
                $total_price = $cart->total();
                $total_item = $cart->totalItems();

                $data['total_price'] = $total_price;
                $data['total_item'] = $total_item;

                $response['data'] = $data;
                break;
            case 'remove_item':
                $rowid = $this->request->getPost('rowid');

                $cart->remove($rowid);

                $total_price = $cart->total();
                $ongkir = (int) ($total_price >= get_settings('min_shop_to_free_shipping_cost')) ? 0 : get_settings('shipping_cost');
                $data['code'] = 204;
                $data['message'] = 'Item dihapus dari keranjang';
                $data['total']['subtotal'] = 'Rp ' . format_rupiah($total_price);
                $data['total']['ongkir'] = ($ongkir > 0) ? 'Rp ' . format_rupiah($ongkir) : 'Gratis';
                $data['total']['total'] = 'Rp ' . format_rupiah($total_price + $ongkir);

                $response = $data;
                break;
                // case 'update_qyt':

                //     $cart->update(array(
                //         'rowid'      => $this->request->getPost('rowid'),
                //         'qty'     => $this->request->getPost('qty')
                //     ));

                //     $total_price = $cart->total();
                //     $ongkir = (int) ($total_price >= get_settings('min_shop_to_free_shipping_cost')) ? 0 : get_settings('shipping_cost');
                //     $data['code'] = 204;
                //     $data['total']['subtotal'] = 'Rp ' . format_rupiah($total_price);
                //     $data['total']['ongkir'] = ($ongkir > 0) ? 'Rp ' . format_rupiah($ongkir) : 'Gratis';
                //     $data['total']['total'] = 'Rp ' . format_rupiah($total_price + $ongkir);

                //     $response = $data;
                //     break;
        }
        return $this->response->setJSON($response);
        // $this->output->set_content_type('application/json')->set_output($response);
    }

    public function _create_order_number($quantity, $user_id, $coupon_id)
    {
        $alpha = strtoupper(random_string('alpha', 3));
        $num = random_string('numeric', 3);
        $count_qty = count((array)$quantity);


        $number = $alpha . date('j') . date('n') . date('y') . $count_qty . $user_id . $coupon_id . $num;
        //Random 3 letter . Date . Month . Year . Quantity . User ID . Coupon Used . Numeric

        return $number;
    }
}
