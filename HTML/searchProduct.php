<?php
session_start();
$conn = mysqli_connect('localhost', 'nhatthien', '12345', 'btl');

//check connection 
if (!$conn) {
    echo 'Connection failed: ' . mysqli_connect_error();
}
$searches = $_SESSION['search'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="..\CSS\searchProduct.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
    <title>Search Products</title>
</head>

<body>
    <div class="header">
        <div class="header2">
            <nav>
                <input type="checkbox" id="show-search">
                <input type="checkbox" id="show-menu">
                <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
                <div class="content1">
                    <div class="logo">
                        <a class="text_logo" href="index.php">Fashionista</a>
                        <br>
                        <a class="text_logo1" href="index.php">Online Shopping</a>
                    </div>
                    <ul class="links">
                        <li><a href="index.php">Trang ch???</a></li>
                        <li><a href="introduce.php">Gi???i thi???u</a></li>
                        <li>
                            <a href="product/list.php" class="desktop-link">C???a h??ng</a>
                            <input type="checkbox" id="show-features">
                            <label for="show-features">C???a h??ng</label>
                            <ul>
                                <li>
                                    <a href="./product/quan-ao_male.php" class="desktop-link">Qu???n & ??o Nam</a>
                                </li>
                                <li>
                                    <a href="./product/quan-ao_female.php" class="desktop-link">Qu???n & ??o N???</a>
                                </li>
                                <li><a href="./product/giay-dep_male.php">Gi??y & d??p Nam</a></li>
                                <li><a href="./product/giay-dep_female.php">Gi??y & d??p N???</a></li>
                                <li><a href="./product/mu-non_male.php">M?? & n??n Nam</a></li>
                                <li><a href="./product/mu-non_female.php">M?? & n??n N???</a></li>
                                <li><a href="./product/balo_male.php">Bal?? Nam</a></li>
                                <li><a href="./product/balo_female.php">Bal?? N???</a></li>
                            </ul>
                        </li>
                        <!-- T??i kho???n -->
                        <?php if (!isset($_SESSION['id']) || empty($_SESSION['id'])) { ?>
                            <li><a href="signIn.php">????ng nh???p</a></li>
                            <li><a href="signUp.php">????ng k??</a></li>
                        <?php } else { ?>
                            <li>
                                <a href="#" class="desktop-link">T??i kho???n</a>
                                <input type="checkbox" id="show-services">
                                <label for="show-services">T??i kho???n</label>
                                <ul>
                                    <li><a href="shopping_carts.php">Ki???m tra ????n h??ng</a></li>
                                    <li><a href="user/infoUser.php">Qu???n l?? t??i kho???n</a></li>
                                    <li><a href="logOut.php">????ng xu???t</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <li><a href="contact.php">Li??n h??? </a></li>
                    </ul>
                </div>
                <label for="show-search" class="search-icon"><i class="fas fa-search"></i></label>
                <form action="" class="search-box" method="GET">
                    <input type="text" placeholder="T??m ki???m s???n ph???m..." name="search" required>
                    <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
                </form>
                <!-- Search php code-->
                <?php
                if (isset($_GET['search']) && $_GET['search'] != '') {
                    $search = trim($_GET['search']);
                    $sql = "SELECT * FROM products WHERE ";
                    $keywords = explode(' ', $search);
                    foreach ($keywords as $word) {
                        $sql .= " pro_name LIKE '" . $word . "%' OR ";
                    }
                    $sql = substr($sql, 0, strlen($sql) - 3);
                    $query = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($query) > 0) {
                        $searches = mysqli_fetch_all($query, MYSQLI_ASSOC);
                    }
                    $_SESSION['search'] = $searches;
                }
                ?>

            </nav>
        </div>

    </div>
    <div class="container" style="margin-top: 75px">
        <?php if (isset($searches)) { ?>
            <div class="h3 ms-2 mt-2">K???t qu??? t??m ki???m: </div>
            <div class="container row row-cols-auto mt-5 mb-5 justify-content-center gap-2">
                <?php foreach ($searches as $product) { ?>
                    <div class="card col product" style="width: 18rem;">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['pro_name']); ?></h5>
                            <h6 class="card-subtitle mb-5 text-muted">
                                Price: <?php echo htmlspecialchars($product['price_sell']); ?> VN??
                            </h6>
                            <a class="btn btn-primary button-detail" href="product/product_detail.php?id=<?php echo $product['pro_id']; ?>" role="button">Detail</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="container">Kh??ng t??m th???y k???t qu???</div>
        <?php } ?>
    </div>
</body>

</html>