<?php

namespace App\Controllers;

use Myth\Auth\Password;
use App\Models\ProductModel;
use App\Models\Customer\Profile_model;
use App\Models\Customer\Payment_model;
use App\Models\ReviewModel;
use phpDocumentor\Reflection\Types\This;

class Customer_Profile extends BaseController
{
    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
        $this->profile = new Profile_model();
        $this->session = session();
    }

    public function index()
    {
        $data = $this->profile->get_profile();

        $user['title'] = $data->name;
        $user['user'] = $data;
        $user['flash'] = $this->session->getflashdata('profile');

        return view('customers/profile', $user);
    }

    public function edit_name()
    {
        $validate = $this->validate([
            'name' => [
                'label' => 'Nama lengkap',
                'rules' => 'required|max_length[32]|min_length[4]'
            ],
            'phone_number' => [
                'label' => 'Nomor Handphone',
                'rules' => 'required'
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'required'
            ],
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }

        $name = $this->request->getPost('name');
        $phone_number = $this->request->getPost('phone_number');
        $address = $this->request->getPost('address');

        $profile = $this->profile->get_profile();
        $old_profile = $profile->profile_picture;

        if (isset($_FILES) && @$_FILES['picture']['error'] == '0') {
            $validate = $this->validate([
                'picture' => [
                    'rules' => 'uploaded[picture]'
                        . '|is_image[picture]'
                        . '|mime_in[picture,image/jpg,image/jpeg,image/png,image/webp,image/webp,image/jfif]'
                        . '|max_size[picture,2048]',
                ]
            ]);
            if (!$validate) {
                return redirect()->back()->withInput();
            }
            $img = $this->request->getFile('picture');
            if ($img->getName() != 'user.jpg') {
                $img->move('assets/uploads/users');
            }
            $new_file_name = $img->getName();
            $profile_picture = $new_file_name;
            if ($old_profile != 'user.jpg') {
                if (file_exists('assets/uploads/users/' . $old_profile))
                    unlink('./assets/uploads/users/' . $old_profile);
            }
        } else {
            $profile_picture = $old_profile;
        }

        $data['name'] = $name;
        $data['phone_number'] = $phone_number;
        $data['address'] = $address;
        $data['profile_picture'] = $profile_picture;
        // dd($data);
        $flash_message = ($this->profile->update_account($data)) ? 'Profil berhasil diperbarui!' : 'Terjadi kesalahan';

        $this->session->setflashdata('profile', $flash_message);
        return redirect()->to(base_url('customer_profile'));
    }

    public function edit_account()
    {
        $validate = $this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[16]|min_length[4]'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'min_length[4]'
            ],

        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }

        $profile = $this->profile->get_profile();

        $get_password = $this->request->getPost('password');

        if (empty($get_password)) {
            $password = $profile->password_hash;
        } else {
            $password = Password::hash($get_password);
        }

        $data['username'] = $this->request->getPost('username');
        $data['password_hash'] = $password;

        $flash_message = ($this->profile->update_account($data)) ? 'Akun berhasil diperbarui' : 'Terjadi kesalahan';

        $this->session->setflashdata('profile', $flash_message);
        $this->session->setflashdata('show_tab', 'akun');
        return redirect()->to(base_url('customer_profile'));
    }

    public function edit_email()
    {
        $validate = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[32]|min_length[10]'
            ],

        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }


        $data['email'] = $this->request->getPost('email');

        $flash_message = ($this->profile->update_account($data)) ? 'Email berhasil diperbarui' : 'Terjadi kesalahan';

        $this->session->setflashdata('profile', $flash_message);
        $this->session->setflashdata('show_tab', 'email');
        return redirect()->to(base_url('customer_profile'));
    }
}
