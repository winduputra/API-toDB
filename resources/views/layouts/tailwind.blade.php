<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title', 'VMS')</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @stack('style')
</head>
<body class="@yield('bg_body', '')">
  @yield('content', '')
  <script>
  const haveSubMenu   = document.querySelectorAll('.have-sub-menu')
  const toggleSubmenu = (submenu) => {
    if( Boolean(submenu) ) {
      submenu.classList.toggle('hidden')
    }
  }
  if( Boolean(haveSubMenu) ) {
    haveSubMenu.forEach(el => {
      el.addEventListener('mouseover', ev => {
        const target  = el.getAttribute('data-target')
        const objectTarget  = document.querySelector('#' + target)
        if( Boolean(objectTarget) ) {
          objectTarget.classList.remove('hidden')
        }
      })
      el.addEventListener('click', ev => {
        ev.preventDefault()
        const target = el.getAttribute('data-target')
        const objectTarget  = document.querySelector('#' + target)
        if( Boolean(objectTarget) ) {
          toggleSubmenu(objectTarget)
        }
        
      })
    });
  }
  </script>
  @stack('script')
</body>
</html>