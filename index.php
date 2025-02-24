<?php
    include __DIR__.'/php/database.php'; 
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Table</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .table thead th {
            background-color: black;
            color: white; 
            text-align: center;
        }
        .table tbody td {
            text-align: center;
        }
        .loginBtn {
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Dashboard Table</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Favourite Name</th>
                    <th>Favourite Item</th>
                    <th>Category</th>
                    <th>Like</th>
                </tr>
            </thead>
            <tbody>
                
                <?php 
                    $sql = "SELECT * FROM favourites ORDER BY id DESC;";
                    $favouriteData = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($favouriteData) > 0) {
                        while($row = mysqli_fetch_assoc($favouriteData)) {
                                $targetUserID = $row['userId'];
                                $name = $row['favName'];
                                $item = $row['favItem'];
                                $like = $row['like_count'];
                                $sqlUser = "SELECT fname,lname FROM users WHERE userId='$targetUserID'";
                                $userData = mysqli_query($conn,$sqlUser);
                                $targetRow = mysqli_fetch_assoc($userData);
                                $userName  = $targetRow['fname']." ".$targetRow['lname'];
                             ?>
                            <tr>
                                <td> <?php echo htmlspecialchars($userName) ?> </td>
                                <td> <?php echo htmlspecialchars($name) ?> </td>
                                <td> <?php echo htmlspecialchars($item) ?> </td>
                                <td> <?php  ?> </td>
                                <td> <i class="fa-solid fa-thumbs-up fa-xl btnLike" style="color: #518ffb;margin-right : 8px;"></i> <span id="showCount"><?php echo htmlspecialchars($like) ?> </span> </td>
                            </tr>
                    <?php } } ?>
                 
                
            </tbody>
        </table>
    </div>
    <div class="text-center mb-4">
        <button class="btn btn-info"><a href="/login.php" class="loginBtn">Login</a></button>
    </div>
</div>

<!-- Bootstrap JS cdn-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- jquery cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<!-- sweet alert cdn -->
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js
"></script>
<script src="./js/script.js"></script>
<script src="./js/favouriteModule.js"></script>
<script src="./js/pageModule.js"></script>


</body>
</html>

