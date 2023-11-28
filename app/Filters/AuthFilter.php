<?php



namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {

    $session = session();

    $segment = $request->uri->getSegment(1);

    if (!$session->has('id')) {
      setAlert('warning', 'Warning', 'User Not Login');
      return redirect()->to(base_url('auth'));
    }

    if ($segment == 'users') {
      if (session()->get('role_id') != 1) {
        setAlert('warning', 'Warning', 'User Not Access');
        return redirect()->to(base_url('dashboard'));
      }
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
