<?php

namespace App\Controllers;


use App\Models\Admin\Product_model;
use App\Models\Admin\Customer_model;
use App\Models\Admin\Order_model;
use App\Models\Admin\Contact_model;

class Admin_Contacts extends BaseController
{
    public function __construct()
    {
        $this->contact = new Contact_model();
        $this->session = session();
    }

    public function index()
    {
        $contact['title'] = 'Kelola Kontak Pengunjung';
        return view('admin/contacts/contacts', $contact);
    }

    public function view($id = 0)
    {
        if ($this->contact->is_contact_exist($id)) {
            $data = $this->contact->contact_data($id);

            $contact['title'] = 'Kontak ' . $data->name;

            $contact['contact'] = $data;
            $contact['flash'] = $this->session->setflashdata('contact_flash');

            $this->contact->set_status($id, 2);


            return view('admin/contacts/view', $contact);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function reply()
    {
        $id = $this->request->getPost('id');
        $sender = $this->request->getPost('email');
        $name = $this->request->getPost('name');
        $send_to = $this->request->getPost('to');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');

        $this->email = \Config\Services::email();

        $this->email->setFrom($sender, $name);
        $this->email->setTo($send_to);

        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        $this->email->send();
        $this->email->printDebugger(array('headers'));
        return redirect()->to('admin_contacts');
    }

    public function api($action = '')
    {
        switch ($action) {
            case 'contacts':
                $contacts['data'] = $this->contact->get_all_contacts();

                $response = $contacts;
                break;
            case 'delete':
                $id = $this->request->getPost('id');

                $this->customer->delete_customer($id);

                $response = array('code' => 204);
                break;
        }

        return $this->response->setJSON($response);
    }
}
