<?php

namespace App\Controllers;

use App\Models\Admin\Product_model;
use App\Models\Admin\Customer_model;
use App\Models\Admin\Order_model;
use App\Models\Admin\Payment_model;
use CodeIgniter\Validation\Rules;

class Admin_Products extends BaseController
{
    public function __construct()
    {

        helper('html');
        $this->product = new Product_model();
        $this->order = new Order_model();
        $this->validation =  \Config\Services::validation();
        $this->session = session();
    }

    public function index()
    {
        if (isset($_GET['category_id'])) {
            $query = $this->request->getGet('category_id');
            $data = [
                'title' => 'Kelola Produk ' . get_store_name(),
                'products' => $this->product->like('category_id', $query)->paginate(8, 'card'),
                'pager' => $this->product->pager
            ];
            return view('admin/products/products', $data);
        }

        $pager = \Config\Services::pager();
        // $products['title'] = 'Kelola Produk ' . get_store_name();
        // $products['products'] = $this->product->paginate(4);
        // $products['pager'] = $this->product->pager;

        $data = [
            'title' => 'Kelola Produk ' . get_store_name(),
            'products' => $this->product->paginate(8, 'card'),
            'pager' => $this->product->pager
        ];
        return view('admin/products/products', $data);
    }

    public function search()
    {
        $query = $this->request->getGet('search_query');
        $pager = \Config\Services::pager();

        $data = [
            'title' => 'Cari "' .  $query . '"',
            'products' => $this->product->like('name', $query)->orLike('description', $query)->paginate(8, 'card'),
            'pager' => $this->product->pager,
            'query' => $this->request->getGet('search_query'),
            'count' => $this->product->count_search($query)
        ];
        return view('admin/products/search', $data);
    }

    public function add_new_product()
    {
        $product['title'] = 'Tambah Produk Baru';

        $product['flash'] = $this->session->getFlashdata('add_new_product_flash');
        $product['categories'] = $this->product->get_all_categories();

        return view('admin/products/add_new_product', $product);
    }

    public function add_product()
    {
        $validate = $this->validate([
            'name' => [
                'label' => 'Nama Produk',
                'rules' => 'trim|required|min_length[4]|max_length[255]'
            ],
            'price' => [
                'label' => 'Harga produk',
                'rules' => 'numeric|required'
            ],
            'stock' => [
                'label' => 'Stok barang',
                'rules' => 'required|numeric'
            ],
            'unit' => [
                'label' => 'Satuan barang',
                'rules' => 'required'
            ],
            'desc' => [
                'label' => 'Deskripsi produk',
                'rules' => 'max_length[512]'
            ],
            'picture' => [
                'rules' => 'uploaded[picture]'
                    . '|is_image[picture]'
                    . '|mime_in[picture,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[picture,2048]',
            ]
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $name = $this->request->getPost('name');
        $category_id = $this->request->getPost('category_id');
        $price = $this->request->getPost('price');
        $stock = $this->request->getPost('stock');
        $unit = $this->request->getPost('unit');
        $desc = $this->request->getPost('desc');
        $date = date('Y-m-d H:i:s');

        // $config['upload_path'] = './assets/uploads/products/';
        // $config['allowed_types'] = 'jpg|png|jpeg';
        // $config['max_size'] = 2048;

        $img = $this->request->getFile('picture');
        $img->move('assets/uploads/products');

        // if (isset($_FILES['picture']) && @$_FILES['picture']['error'] == '0') {
        //     if (!$this->upload->do_upload('picture')) {
        //         $error = array('error' => $this->upload->display_errors());

        //         //show_error($error);
        //     } else {
        //         $upload_data = $this->upload->data();
        //         $file_name = $upload_data['file_name'];
        //     }
        // }

        $category_data = $this->product->category_data($category_id);
        $category_name = $category_data->name;

        $sku = create_product_sku($name, $category_name, $price, $stock);

        $product['category_id'] = $category_id;
        $product['sku'] = $sku;
        $product['name'] = $name;
        $product['description'] = $desc;
        $product['price'] = $price;
        $product['stock'] = $stock;
        $product['product_unit'] = $unit;
        $product['picture_name'] = $img->getName();
        $product['add_date'] = $date;
        $this->product->add_new_product($product);
        $this->session->setFlashdata('add_new_product_flash', 'Produk baru berhasil ditambahkan!');

        return redirect()->to(base_url('admin_products/add_new_product'));
        // }
    }


    public function edit($id = 0)
    {
        if ($this->product->is_product_exist($id)) {
            $data = $this->product->product_data($id);

            $product['title'] = 'Edit ' . $data->name;

            $product['flash'] = $this->session->getflashdata('edit_product_flash');
            $product['product'] = $data;
            $product['categories'] = $this->product->get_all_categories();

            return view('admin/products/edit_product', $product);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function edit_product()
    {

        $validate = $this->validate([
            'name' => [
                'label' => 'Nama Produk',
                'rules' => 'trim|required|min_length[4]|max_length[255]'
            ],
            'price' => [
                'label' => 'Harga produk',
                'rules' => 'numeric|required'
            ],
            'stock' => [
                'label' => 'Stok barang',
                'rules' => 'required|numeric'
            ],
            'unit' => [
                'label' => 'Satuan barang',
                'rules' => 'required'
            ],
            'desc' => [
                'label' => 'Deskripsi produk',
                'rules' => 'max_length[512]'
            ],

        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        // if ($this->validation->run() == FALSE) {
        //     $id = $this->request->getPost('id');
        //     $this->edit($id);
        // } else {
        $id = $this->request->getPost('id');
        $data = $this->product->product_data($id);
        $current_picture = $data->picture_name;

        $name = $this->request->getPost('name');
        $category_id = $this->request->getPost('category_id');
        $price = $this->request->getPost('price');
        $discount = $this->request->getPost('price_discount');
        $stock = $this->request->getPost('stock');
        $unit = $this->request->getPost('unit');
        $desc = $this->request->getPost('desc');
        $available = $this->request->getPost('is_available');
        $date = date('Y-m-d H:i:s');

        // $config['upload_path'] = './assets/uploads/products/';
        // $config['allowed_types'] = 'jpg|png|jpeg';
        // $config['max_size'] = 2048;

        // $this->load->library('upload', $config);

        if (isset($_FILES['picture']) && @$_FILES['picture']['error'] == '0') {
            $validate = $this->validate([
                'picture' => [
                    'rules' => 'uploaded[picture]'
                        . '|is_image[picture]'
                        . '|mime_in[picture,image/jpg,image/jpeg,image/png,image/webp]'
                        . '|max_size[picture,2048]',
                ]
            ]);
            if (!$validate) {
                return redirect()->back()->withInput();
            }
            $img = $this->request->getFile('picture');
            $img->move('assets/uploads/products');
            $new_file_name = $img->getName();

            if ($this->product->is_product_have_image($id)) {
                $file = './assets/uploads/products/' . $current_picture;

                $file_name = $new_file_name;
                unlink($file);
            } else {
                $file_name = $new_file_name;
            }
        } else {
            $file_name = ($this->product->is_product_have_image($id)) ? $current_picture : NULL;
        }



        $product['category_id'] = $category_id;
        $product['name'] = $name;
        $product['description'] = $desc;
        $product['price'] = $price;
        $product['current_discount'] = $discount;
        $product['stock'] = $stock;
        $product['product_unit'] = $unit;
        $product['picture_name'] = $file_name;
        $product['is_available'] = $available;

        $this->product->edit_product($id, $product);
        $this->session->setflashdata('edit_product_flash', 'Produk berhasil diperbarui!');

        return redirect()->to(base_url('admin_products/view/' . $id));
        // }
    }

    public function product_api()
    {
        $action = $this->request->getGet('action');

        switch ($action) {
            case 'delete_image':
                $id = $this->request->getPost('id');
                $data = $this->product->product_data($id);
                $picture_name = $data->picture_name;
                $file = './assets/uploads/products/' . $picture_name;

                if (file_exists($file) && is_readable($file) && unlink($file)) {
                    $this->product->delete_product_image($id);
                    $response = array('code' => 204, 'message' => 'Gambar berhasil dihapus');
                } else {
                    $response = array('code' => 200, 'message' => 'Terjadi kesalahan sata menghapus gambar');
                }
                break;
            case 'delete_product':
                $id = $this->request->getPost('id');
                $data = $this->product->product_data($id);
                $picture = $data->picture_name;
                $file = './assets/uploads/products/' . $picture;

                $this->product->delete_product($id);

                if (file_exists($file) && is_readable($file)) {
                    unlink($file);
                }

                $response = array('code' => 204);
                break;
        }

        return $this->response->setJSON($response);
    }

    public function view($id = 0)
    {
        if ($this->product->is_product_exist($id)) {
            $data = $this->product->product_data($id);

            $product['title'] = $data->name . ' | SKU ' . $data->sku;

            $product['product'] = $data;
            $product['flash'] = $this->session->setflashdata('product_flash');
            $product['orders'] = $this->order->product_ordered($id);

            return view('admin/products/view', $product);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function category()
    {
        $categories['title'] = 'Kelola Kategori Produk';

        $categories['categories'] = $this->product->get_all_categories();

        return view('admin/products/category', $categories);
    }

    public function category_api()
    {
        $action = $this->request->getGet('action');

        switch ($action) {
            case 'list':
                $categories['data'] = $this->product->get_all_categories();
                $response = $categories;
                break;
            case 'view_data':
                $id = $this->request->getGet('id');

                $data['data'] = $this->product->category_data($id);
                $response = $data;
                break;
            case 'add_category':
                $name = $this->request->getPost('name');

                $this->product->add_category($name);
                $categories['data'] = $this->product->get_all_categories();
                $response = $categories;
                break;
            case 'delete_category':
                $id = $this->request->getPost('id');

                $this->product->delete_category($id);
                $response = array('code' => 204, 'message' => 'Kategori berhasil dihapus!');
                break;
            case 'edit_category':
                $id = $this->request->getPost('id');
                $name = $this->request->getPost('name');

                $this->product->edit_category($id, $name);
                $response = array('code' => 201, 'message' => 'Kategori berhasil diperbarui');
                break;
        }

        return $this->response->setJSON($response);
    }

    public function coupons()
    {
        $data['title'] = 'Kelola Kupon Belanja';

        return view('admin/products/coupons', $data);
    }

    public function _get_coupon_list()
    {
        $coupons = $this->product->get_all_coupons();
        $n = 0;

        foreach ($coupons as $coupon) {
            $coupons[$n]->credit = 'Rp ' . format_rupiah($coupon->credit);
            $coupons[$n]->start_date = get_formatted_date($coupon->start_date);
            $coupons[$n]->is_active = ($coupon->is_active == 1) ? ((strtotime($coupon->expired_date) < time()) ? 'Sudah kadaluarsa' : 'Masih berlaku') : 'Tidak aktif';
            $coupons[$n]->expired_date = get_formatted_date($coupon->expired_date);

            $n++;
        }

        return $coupons;
    }

    public function coupon_api()
    {
        $action = $this->request->getGet('action');

        switch ($action) {
            case 'coupon_list':
                $coupons['data'] = $this->_get_coupon_list();

                $response = $coupons;
                break;
            case 'view_data':
                $id = $this->request->getGet('id');

                $data['data'] = $this->product->coupon_data($id);
                $response = $data;
                break;
            case 'add_coupon':
                $name = $this->request->getPost('name');
                $code = $this->request->getPost('code');
                $credit = $this->request->getPost('credit');
                $start = $this->request->getPost('start_date');
                $end = $this->request->getPost('expired_date');

                $coupon = array(
                    'name' => $name,
                    'code' => $code,
                    'credit' => $credit,
                    'start_date' => date('Y-m-d', strtotime($start)),
                    'expired_date' => date('Y-m-d', strtotime($end))
                );

                $this->product->add_coupon($coupon);
                $coupons['data'] = $this->_get_coupon_list();

                $response = $coupons;
                break;
            case 'delete_coupon':
                $id = $this->request->getPost('id');

                $this->product->delete_coupon($id);
                $response = array('code' => 204, 'message' => 'Kupon berhasil dihapus!');
                break;
            case 'edit_coupon':
                $id = $this->request->getPost('id');
                $name = $this->request->getPost('name');
                $code = $this->request->getPost('code');
                $credit = $this->request->getPost('credit');
                $start = $this->request->getPost('start_date');
                $end = $this->request->getPost('expired_date');
                $active = $this->request->getPost('is_active');

                $coupon = array(
                    'name' => $name,
                    'code' => $code,
                    'credit' => $credit,
                    'start_date' => date('Y-m-d', strtotime($start)),
                    'expired_date' => date('Y-m-d', strtotime($end)),
                    'is_active' => $active
                );

                $this->product->edit_coupon($id, $coupon);
                $response = array('code' => 201, 'message' => 'Kupon berhasil diperbarui');
                break;
        }

        return $this->response->setJSON($response);
    }
}
