<?php
$logged = false;
if (isset($_SESSION["email"]))
    $logged = true;
?>

<link href="css/navbar-top-fixed.css" rel="stylesheet">

<nav class="navbar navbar-light bg-faded rounded fixed-top navbar-toggleable-md">
    <div class='container'>
        <button class='navbar-toggler navbar-toggler-right' type='button' data-toggle='collapse'
                data-target='#siteNavbar' aria-controls='siteNavbar' aria-expanded='false'
                aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <a class='navbar-brand' href='#' align="left">Trackers</a>

        <div class='collapse navbar-collapse' id='siteNavbar'>
            <ul class='navbar-nav mr-auto'>
                <li class='nav-item active'>
                    <a class='nav-link' href='index.php'>Home</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='#'>Link</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='#'>How to</a>
                </li>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='http://example.com' id='dropdown02' data-toggle='dropdown'
                       aria-haspopup='true' aria-expanded='false'>Dropdown</a>
                    <div class='dropdown-menu' aria-labelledby='dropdown02'>
                        <a class='dropdown-item' href='#'>Action</a>
                        <a class='dropdown-item' href='#'>Another action</a>
                        <a class='dropdown-item' href='#'>Something else here</a>
                    </div>
                </li>
            </ul>
            <div>

                <input type='button' class='btn btn-outline-primary' id='loginBtt'
                       value='Login' <?php if ($logged) echo "hidden" ?>>
                <input type='button' class='btn btn-outline-danger' id='newReportBtt'
                       value='New Report' <?php if (!$logged) echo "hidden" ?>>

            </div>
            <script type='text/javascript'>
                document.getElementById('newReportBtt').onclick = function () {
                    window.location.href = 'new_report.php';
                };
                document.getElementById('loginBtt').onclick = function () {
                    window.location.href = 'login.php';
                };
            </script>
        </div>
    </div>
</nav>
