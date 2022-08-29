<?php

namespace App\Controllers;

use App\Models\Admin\Product_model;
use App\Models\Admin\Customer_model;
use App\Models\Admin\Order_model;
use App\Models\Admin\Review_model;
use CodeIgniter\Validation\Rules;

class Admin_Reviews extends BaseController
{
    public function __construct()

    {
        $this->order = new Order_model();
        $this->review = new Review_model();
        $this->session = session();
    }

    public function index()
    {
        $pager = \Config\Services::pager();
        $reviews = [
            'title' => 'Kelola Review',
            'reviews' => $this->review
                ->select('reviews.*, o.order_number, c.*, reviews.id as id')
                ->join('orders o', 'o.id = reviews.order_id')
                ->join(' users c', 'c.id = reviews.user_id')
                ->paginate(10, 'table'),
            'pager' => $this->review->pager
        ];

        return view('admin/reviews/reviews', $reviews);
    }

    public function view($id = 0)
    {
        if ($this->review->is_review_exist($id)) {
            $data = $this->review->review_data($id);

            $reviews['title'] = 'Review Order #' . $data->order_number;

            $reviews['review'] = $data;
            $reviews['flash'] = $this->session->setflashdata('review_flash');

            return view('admin/reviews/view', $reviews);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function delete($id)
    {
        if ($this->review->is_review_exist($id)) {
            $this->review->delete($id);

            $this->session->setflashdata('review_flash', 'Review berhasil dihapus');
            return redirect()->to('admin_reviews');
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
