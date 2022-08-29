<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SettingModel;
use App\Models\ReviewModel;

class Pages extends BaseController
{
    public function __construct()
    {
        $this->ReviewModel = new ReviewModel();
        $this->SettingModel = new SettingModel();
        $this->ProductModel = new ProductModel();
    }
    public function index()
    {

        $reviews = $this->ReviewModel->getReview();
        $data = [
            'store_name' => 'Toko Sayur Ku',
            'title' => 'About Us',
            'reviews' => $reviews
        ];
        return view('themes\littlegreenery\pages\about', $data);
    }

    public function contact()
    {
        session();
        // $profile = user_data();

        // $data['user'] = $profile;
        //$data['flash'] = $this->session->flashdata('contact_flash');
        $reviews = $this->ReviewModel->getReview();
        $data = [
            'store_name' => 'Toko Ku',
            'title' => 'Contact Us',
            //'flash' => $reviews,
            'reviews' => $reviews
        ];
        return view('themes\littlegreenery\pages\contact', $data);
    }

    public function send_message()
    {
        $this->form_validation =  \Config\Services::validation();
        // $this->form_validation->set_error_delimiters('<div class="text-danger font-weight-bold"><small>', '</small></div>');
        $this->form_validation->setRules([
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required|min_length[10]',
            'message' => 'required',
        ]);
        $this->form_validation->setRule('name', 'Nama lengkap', 'required');
        $this->form_validation->setRule('subject', 'Subjek pesan', 'required');
        $this->form_validation->setRule('email', 'Email', 'required|min_length[10]');
        $this->form_validation->setRule('message', 'Pesan', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->contact();
        } else {
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $subject = $this->request->getPost('subject');
            $message = $this->request->getPost('message');

            $data = array(
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'contact_date' => date('Y-m-d H:i:s')
            );

            $this->contact->register_contact($data);
            $this->session->set_flashdata('contact_flash', 'Pesan berhasil dikirimkan. Kami akan membalas dalam waktu 2x24 jam');

            redirect('pages/contact');
        }
    }
}
