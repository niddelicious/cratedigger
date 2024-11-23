<!DOCTYPE html>
<html lang="en">

<head>
    <title>niddelicious | nidde.nu | An archive of DJ streams</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0c46afc968.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#ffaa00">
    <meta name="msapplication-TileColor" content="#ffaa00">
    <meta name="theme-color" content="#ffaa00">

    @yield('styles')
    @yield('scripts')
</head>

<body>
    <div class="content">
        <div class="header">
            <div class="container">
                @include('frontend.introduction')
            </div>
        </div>

        <div class="main">
            <div class="container">
                @yield('content')
            </div>
        </div>

        <div class="footer">
            <div class="container">
                @include('frontend.footer')
            </div>
        </div>
    </div>
</body>
@yield('footerScripts')

</html>
