<!DOCTYPE html>
<html lang="en">
<head>

    <!-- META AND TITLE
    ================================================== -->
    @include("layout.meta")

    <!-- CSS
    ================================================== -->
    @include("layout.css")
</head>
<body>

    <!-- HEADER
    ================================================== -->
    @include("layout.header")


    <!-- SIDEBAR
    ================================================== -->
    @include("layout.sidebar")


    <div id="content">

        <!-- CONTENT
        ================================================== -->
        @yield('content')

    </div>

    <!-- FOOTER
    ================================================== -->
    @include("layout.footer")

    <!-- JS
    ================================================== -->
    @include("layout.js")

</body>
</html>
