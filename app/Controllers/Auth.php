<?php

namespace App\Controllers;

class Auth extends BaseController
{

  private $model;
  private $link = 'auth';
  private $view = 'auth';
  private $title = 'Login';
  public function __construct()
  {
    $this->model = new \App\Models\UserModel();
  }

  public function index()
  {
    $data = [
      'title' => $this->title,
      'link' => $this->link
    ];
    return view($this->view . '/login', $data);
  }

  public function verify()
  {
    $rules = [
      'username' => 'required',
      // 'password' => 'required|min_length[8]',
      'password' => 'required',
    ];

    $input = $this->request->getVar();

    if (!$this->validateData($input, $rules)) {
      return redirect()->back()->withInput();
    }

    $username = htmlspecialchars($this->request->getVar('username'), true);
    $password = htmlspecialchars($this->request->getVar('password'), true);

    $dataUser = $this->model->where('username', $username)->orWhere('email', $username)->first();
    if ($dataUser) {
      if (password_verify($password, $dataUser['password'])) {
        if ($dataUser['is_active'] == 1) {
          if (!$dataUser['deleted_at']) {
            session()->set('id', $dataUser['id']);
            session()->set('role_id', $dataUser['role_id']);
            session()->set('username', $dataUser['username']);

            setAlert('success', 'Success', 'User login');
            return redirect()->to('dashboard');
          } else {
            setAlert('warning', 'Warning', 'User deleted, please contact administrator');
          }
        } else {
          setAlert('warning', 'Warning', 'User disabled active, please contact administrator');
        }
      } else {
        setAlert('warning', 'Warning', 'Password Dont Match');
      }
    } else {
      setAlert('warning', 'Warning', 'User Not Register');
    }

    return redirect()->to('auth');
  }

  public function register()
  {
    $data = [
      'title' => 'Register',
      'link' => $this->link
    ];
    return view($this->view . '/register', $data);
  }

  public function registered()
  {
    $rules = [
      'name' => 'required',
      'password' => 'required|min_length[8]',
      'confirm_password' => 'required|min_length[8]|matches[password]',
      'email' => 'required|is_unique[users.email]|valid_email',
      'username' => 'required|is_unique[users.username]',
    ];

    $input = $this->request->getVar();

    if (!$this->validateData($input, $rules)) {
      return redirect()->back()->withInput();
    }

    $data = [
      'name' => htmlspecialchars($this->request->getVar('name'), true),
      'username' => htmlspecialchars($this->request->getVar('username'), true),
      'email' => htmlspecialchars($this->request->getVar('email'), true),
      'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
      'role_id' => 2,
      'is_active' => 1
    ];

    $res = $this->model->save($data);
    if ($res) {
      setAlert('success', 'Success', 'Register Success');
      return redirect()->to($this->link);
    } else {
      setAlert('warning', 'Warning', 'Register Failed');
      return redirect()->to($this->link . '/register');
    }
  }

  public function logout()
  {
    session()->remove('id');
    session()->remove('role_id');
    session()->remove('username');
    session()->destroy();

    return redirect()->to($this->link);
  }
}
