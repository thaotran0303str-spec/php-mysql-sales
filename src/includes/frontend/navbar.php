<nav class="navbar navbar-expand-lg bg-dark navbar-dark">

    <div class="container">

        <a class="navbar-brand" href="/">
            Sales Management
        </a>

       <div class="d-flex gap-2">

    <a
        class="btn btn-outline-light btn-sm"
        href="/cart.php"
    >
        Giỏ hàng (<?= (int) $cartCount ?>)
    </a>

    <a
        class="btn btn-outline-light btn-sm"
        href="/admin/"
    >
        Quản trị
    </a>

</div>

        <div
            class="collapse navbar-collapse"
            id="frontendNavbar"
        >

            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="/products.php">
                        Sản Phẩm
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>