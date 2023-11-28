<?php


function copyright($year = null)
{
  $tahun_start = ($year == null) ? '2023' : $year;
  $tahun_now = date('Y');
  if ($tahun_start == $tahun_now) {
    return $tahun_start;
  } else {
    return $tahun_start . '-' . $tahun_now;
  }
}


function logged($key)
{
  return session()->get($key);
}


if (!function_exists('getProfile')) {

  function getProfile()
  {
    $id = logged('id');
    $data = model('App\Models\UserModel')->select('users.*, title')->join('roles', 'roles.id = users.role_id')->find($id);
    return $data;
  }
}

function setAlert($icon, $title, $text = '', $type = 'sweetalert', $url = null)
{

  $session = session();

  $session->setFlashdata('iconFlash', $icon);
  $session->setFlashdata('titleFlash', $title);
  $session->setFlashdata('textFlash', $text);
  $session->setFlashdata('typeFlash', $type);
  $session->setFlashdata('urlFlash', $url);
}

function initAlert()
{
  $session = session();
  return "

  <div id='flash' data-icon='" . $session->getFlashdata('iconFlash') . "' data-title='" . $session->getFlashdata('titleFlash') . "' data-text='" . $session->getFlashdata('textFlash') . "' data-url='" . $session->getFlashdata('urlFlash') . "' data-type='" . $session->getFlashdata('typeFlash') . "'></div>

  <script>

  const Swal2 = Swal.mixin({
    customClass: {
      input: 'form-control'
    }
  })
  
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  
  
  function deleteTombol(e){
    const ket = e.getAttribute('data-ket');
    const href = e.getAttribute('data-href') ? e.getAttribute('data-href') : e.getAttribute('href');
    Swal.fire({
      title: 'Are you sure?',
      text: ket,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        if(href){
          window.location.href = href;
        }else{
          e.parentElement.submit();
        }
      }
    })
    e.preventDefault();
  }
  
  const iconFlash = document.getElementById('flash').getAttribute('data-icon');
  const titleFlash = document.getElementById('flash').getAttribute('data-title');
  const textFlash = document.getElementById('flash').getAttribute('data-text');
  const urlFlash = document.getElementById('flash').getAttribute('data-url');
  const typeFlash = document.getElementById('flash').getAttribute('data-type');


  if(typeFlash == 'sweetalert'){
    
    if (iconFlash && urlFlash) {
      Swal.fire({
        icon: iconFlash,
        title: titleFlash,
        text: textFlash
      }).then((result) => {
        if (result.value) {
          window.location.href = urlFlash;
        }
      })
    } else if (iconFlash) {
      Swal.fire({
        icon: iconFlash,
        title: titleFlash,
        text: textFlash
      })
    }

  }else if(typeFlash =='toast'){
    Toast.fire({
      icon: iconFlash,
      title: titleFlash
    })
  }

  </script>
  
  
  ";
}
