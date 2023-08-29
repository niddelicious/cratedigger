<!DOCTYPE html>
<html lang="en">

<head>
    <title>niddelicious | nidde.nu | An archive of DJ streams</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;500;700;900&display=swap" rel="stylesheet">
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
    @yield('meta')
</head>

<body>
    <div class="content">
        <div class="main">
            <div class="container tight-container">
                @yield('content')
            </div>
        </div>

        <div class="footer gallery-footer">
            <div class="container tight-container">
                @include('gallery.footer')
            </div>
        </div>
    </div>
</body>
@yield('footerScripts')

</html>
