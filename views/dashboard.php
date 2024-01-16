<?php
session_start();

require '../classes/User.php';

$user       = new User; //creating an obj
$all_users  = $user->getAllUsers(); //$all_users holds all data in sql
//getAllUsers() gives all the data to $all_users
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Dashboard</title>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?= $_SESSION['full_name'] ?></span>
                <form action="../actions/logout.php" method="post" class="d-flex ms-2">
                    <button type="submit" class="text-danger bg-transparent border-0">Log out</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="row justify-content-center gx-0">
        <div class="col-6">
            <h2 class="text-center">USER LIST</h2>
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th><!-- for photo --></th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th><!-- for action buttons --></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //cannot for loop because it connot have fetch_assoc()
                        while($user = $all_users->fetch_assoc()){
                            // ['id' => 1, 'first_name' => 'Rene', 'last_name' => 'Okamura', 'username' -> 'rene']
                            // ['id' => 2, 'first_name' => 'John', 'last_name' => 'Okamura', 'username' -> 'rene']
                            // Those are accosiative array
                            
                           
                        ?>
<!-- here is now HTML -->
                            <tr>
                                <td>
                                    <?php
                                        if($user['photo']){
                                    ?>
<!-- here is now HTML -->
                                        <img src="../assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] //use php because it's depends on the photo?>" class="d-block mx-auto dashboard-photo">
                                    <?php
                                        } else {
                                    ?>
<!-- here is now HTML -->
                                        <!-- if user does't have a photo-->
                                        <i class="fa-solid fa-user text-secondary d-block text-center dashboard-icon"></i>
                                    <?php
                                        }
                                    ?>
                                </td>
                                <td><?= $user['id']?></td>
                                <td><?= $user['first_name']?></td>
                                <td><?= $user['last_name']?></td>
                                <td><?= $user['username']?></td>
                                <td>
                                    <?php
                                        if ($_SESSION['id'] === $user['id']) {
                                    ?>
                                            <a href="edit-user.php">
                                                <button class="btn btn-outline-warning" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square danger"></i>
                                                </button>
                                            </a>
                                            <a href="delete-user.php">
                                                <button class="btn btn-outline-danger" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </a>
                                    <?php
                                        }
                                    ?>
                                        
                                    
                                </td>
                            </tr>
                        <?php
                            }
                        ?>

                    
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>