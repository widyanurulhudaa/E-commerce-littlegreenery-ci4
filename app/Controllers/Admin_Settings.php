<?php

namespace App\Controllers;

use Myth\Auth\Password;
use App\Models\Admin\Product_model;
use App\Models\Admin\Customer_model;
use App\Models\Admin\Order_model;
use App\Models\Admin\Setting_model;
use CodeIgniter\Validation\Rules;

class Admin_Settings extends BaseController
{
    public function __construct()
    {

        $this->validation =  \Config\Services::validation();
        $this->setting = new Setting_model();
        $this->session = session();
    }

    public function index()
    {
        $settings['title'] = 'Pengaturan';

        $settings['flash'] = $this->session->getflashdata('settings_flash');
        $settings['banks'] = (array) json_decode(get_settings('payment_banks'));
        return view('admin/settings/settings', $settings);
    }

    public function update()
    {
        $fields = array(
            'store_name', 'store_phone_number', 'store_email', 'store_tagline', 'store_description',
            'store_address', 'min_shop_to_free_shipping_cost', 'shipping_cost'
        );

        foreach ($fields as $field) {
            $data = $this->request->getPost($field);

            update_settings($field, $data);
        }


        if (isset($_FILES['picture']) && @$_FILES['picture']['error'] == '0') {
            $current_profile_picture = get_settings('store_logo');
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
            if ($img->getName() != 'logo.jpg') {
                $img->move('assets/uploads/sites');
            }
            $new_file_name = $img->getName();
            $profile_picture = $new_file_name;
            // dd($current_profile_picture);
            if ($current_profile_picture != 'logo.jpg') {
                if (file_exists('assets/uploads/sites/' . $current_profile_picture))
                    unlink('./assets/uploads/sites/' . $current_profile_picture);
            }
            $field = 'store_logo';
            update_settings($field, $new_file_name);
        } else {
            $field = 'store_logo';
            $current_profile_picture = get_settings('store_logo');
            $profile_picture = $current_profile_picture;
            update_settings($field, $profile_picture);
        }
        $banks = $this->request->getPost('banks');
        update_settings('payment_banks', '{}');

        if (is_array($banks) && count($banks) > 0 && !empty($banks[0]['bank'])) {
            $data = [];
            foreach ($banks as $bank) {
                $bank_name = $bank['bank'];
                $bank_name = $this->_bank_slug($bank_name);

                $data[$bank_name] = $bank;
            }

            $data = json_encode($data);
            update_settings('payment_banks', $data);
        }

        $this->session->setFlashdata('settings_flash', 'Pengaturan berhasil diperbarui');
        return redirect()->to(base_url('admin_settings'));
    }

    public function add_bank()
    {
        $bank_name = $this->request->getPost('bank');
        $bank_number = $this->request->getPost('number');
        $owner = $this->request->getPost('name');

        $bank_slug = $this->_bank_slug($bank_name);
        $data[$bank_slug] = [
            'bank' => $bank_name,
            'number' => $bank_number,
            'name' => $owner
        ];

        $old_data = (array) json_decode(get_settings('payment_banks'));
        $new_data = array_merge($old_data, $data);
        $new_data = json_encode($new_data);

        update_settings('payment_banks', $new_data);

        $this->session->setFlashdata('settings_flash', 'Berhasil menambah data bank');
        return redirect()->to(base_url('admin_settings'));
    }

    public function profile()
    {
        $profile['title'] = 'Profil Saya';

        $profile['flash'] = $this->session->getFlashdata('settings_flash');
        $profile['user'] = $this->setting->get_profile();
        return view('admin/settings/profile', $profile);
    }

    public function profile_update()
    {
        $validate = $this->validate([
            'name' => [
                'label' => 'Nama',
                'rules' => 'required'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required'
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required'
            ]
        ]);
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $data = $this->setting->get_profile();
        $current_profile_picture = $data->profile_picture;
        $current_password = $data->password_hash;

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($password))
            $password = $current_password;
        else
            // $password = password_hash($password, PASSWORD_BCRYPT);
            $password = Password::hash($password);

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
            if ($img->getName() != 'user.jpg') {
                $img->move('assets/uploads/users');
            }
            $new_file_name = $img->getName();
            $profile_picture = $new_file_name;
            if ($current_profile_picture != 'user.jpg') {
                if (file_exists('assets/uploads/users/' . $current_profile_picture))
                    unlink('./assets/uploads/users/' . $current_profile_picture);
            }
        } else {
            $profile_picture = $current_profile_picture;
        }

        $data = array(
            'name' => $name,
            'email' => $email,
            'username' => $username,
            'password_hash' => $password,
            'profile_picture' => $profile_picture
        );

        $this->setting->update_profile($data);

        $this->session->setFlashdata('settings_flash', 'Profil berhasil diperbarui');
        return redirect()->to(base_url('admin_settings/profile'));
    }

    protected function _bank_slug($bank)
    {
        $bank = strtolower($bank);
        $bank = str_replace(' ', '-', $bank);

        return $bank;
    }
}
