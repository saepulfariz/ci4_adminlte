<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Users extends BaseController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    private $model;
    private $link = 'users';
    private $view = 'users';
    private $title = 'Users';
    private $dir = 'public/assets/uploads/users';
    public function __construct()
    {
        $this->model = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title' => $this->title,
            'link' => $this->link,
            'data' => $this->model->select('users.*, title')->join('roles', 'roles.id = users.role_id')->findAll()
        ];

        return view($this->view . '/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        return redirect()->to($this->link);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = [
            'title' => $this->title,
            'link' => $this->link,
            'role' => $this->model->getRoles(),
        ];

        return view($this->view . '/new', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = [
            'name' => 'required',
            'password' => 'required|min_length[8]',
            'email' => 'required|is_unique[users.email]|valid_email',
            'username' => 'required|is_unique[users.username]',
        ];

        $dataBerkas = $this->request->getFile('image');

        if ($dataBerkas->getError() != 4) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|mime_in[image,image/png,image/jpeg]|ext_in[image,png,jpg,gif]|is_image[image]';
        }

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name')),
            'email' => htmlspecialchars($this->request->getVar('email')),
            'username' => htmlspecialchars($this->request->getVar('username')),
            'role_id' => htmlspecialchars($this->request->getVar('role_id')),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        if ($dataBerkas->getError() != 4) {

            $fileName = $dataBerkas->getName();

            $dataBerkas->move($this->dir, $fileName);

            $data['image'] = $fileName;
        }

        $res = $this->model->save($data);
        if ($res) {
            setAlert('success', 'Success', 'Add Success');
        } else {
            setAlert('warning', 'Warning', 'Add Failed');
        }

        return redirect()->to($this->link);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $data = [
            'title' => $this->title,
            'link' => $this->link,
            'data' => $result,
            'role' => $this->model->getRoles(),
        ];

        return view($this->view . '/edit', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $rules = [
            'name' => 'required',
        ];

        $input = $this->request->getVar();

        if ($input['email'] != $result['email']) {
            $rules['email'] = 'required|valid_email|is_unique[users.email]';
        }

        if ($input['username'] != $result['username']) {
            $rules['username'] = 'required|is_unique[users.username]';
        }

        if ($input['password'] != '') {
            $rules['password'] = 'required|min_length[8]';
        }

        $dataBerkas = $this->request->getFile('image');

        if ($dataBerkas->getError() != 4) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|mime_in[image,image/png,image/jpeg]|ext_in[image,png,jpg,gif]|is_image[image]';
        }


        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name')),
            'email' => htmlspecialchars($this->request->getVar('email')),
            'username' => htmlspecialchars($this->request->getVar('username')),
            'role_id' => htmlspecialchars($this->request->getVar('role_id')),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        if ($dataBerkas->getError() != 4) {

            $fileName = $dataBerkas->getName();

            $dataBerkas->move($this->dir, $fileName);

            $data['image'] = $fileName;

            if ($result['image'] != 'user.png') {
                @unlink($this->dir . '/' . $result['image']);
            }
        }

        $res = $this->model->update($id, $data);
        if ($res) {
            setAlert('success', 'Success', 'Edit Success');
        } else {
            setAlert('warning', 'Warning', 'Edit Failed');
        }

        return redirect()->to($this->link);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        if ($result['image'] != 'user.png') {
            @unlink($this->dir . '/' . $result['image']);
        }

        $res = $this->model->delete($id);
        if ($res) {
            setAlert('success', 'Success', 'Delete Success');
        } else {
            setAlert('warning', 'Warning', 'Delete Failed');
        }

        return redirect()->to($this->link);
    }

    public function active($id = null, $active = null)
    {
        if ($id == null || $active == null) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $data = [
            'is_active' => $active
        ];

        $res = $this->model->update($id, $data);
        if ($res) {
            $title = ($active == 0) ? 'Non ' : '';
            setAlert('success', 'Success', $title . 'Active Success');
        } else {
            setAlert('warning', 'Warning', 'Active Failed');
        }
        return redirect()->to($this->link);
    }

    public function profile()
    {
        $data = [
            'title' => 'My Profile',
            'data' => getProfile()
        ];

        return view($this->view . '/profile', $data);
    }

    public function editProfile()
    {
        $data = [
            'title' => 'Edit My Profile',
            'data' => getProfile()
        ];

        return view($this->view . '/profile_edit', $data);
    }

    public function updateProfile()
    {
        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => 'required|valid_email',
        ];

        $input = $this->request->getVar();

        $dataUser = getProfile();

        if ($input['email'] != $dataUser['email']) {
            $rules['email'] = 'required|valid_email|is_unique[users.email]';
        }

        $dataBerkas = $this->request->getFile('image');

        if ($dataBerkas->getError() != 4) {
            $rules['image'] = 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]';
        }

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'email' => $this->request->getVar('email'),
            'name' => $this->request->getVar('name'),
        ];

        if ($dataBerkas->getError() != 4) {
            $fileName = $dataBerkas->getName();

            if ($dataUser['image'] != 'user.png') {
                @unlink($this->dir . '/' . $dataUser['image']);
            }

            $dataBerkas->move($this->dir, $fileName);
            $data['image'] = $fileName;
        }

        $res = $this->model->update($dataUser['id'], $data);
        if ($res) {
            setAlert('success', 'Success', 'Update Success');
        } else {
            setAlert('warning', 'Warning', 'Update Failed');
        }
        return redirect()->to('profile');
    }

    public function changePassword()
    {
        $data = [
            'title' => 'Change Password',
            'link' => 'change-password'
        ];

        return view($this->view . '/change_password', $data);
    }


    public function updatePassword()
    {
        $password_old = $this->request->getVar('password_old');
        $password_new = $this->request->getVar('password_new');
        $password_retype = $this->request->getVar('password_retype');

        $dataRes = getProfile();

        if (password_verify($password_old, $dataRes['password'])) {
            if ($password_new == $password_retype) {
                $data = [
                    'password' => password_hash($password_new, PASSWORD_DEFAULT)
                ];

                $this->model->update($dataRes['id'], $data);

                setAlert('success', 'Success', 'Password Changed Successfully');
            } else {
                setAlert('warning', 'Warning', 'The new password is not the same');
            }
        } else {
            // setAlert('warning', 'Warning', 'The old password is different');
            $data = [
                'password_old' => 'The old password is different'
            ];
            return redirect()->back()->with('_ci_validation_errors', $data)->withInput();
        }

        return redirect()->to('change-password');
    }
}
