<?php
/*
★★(class User)は、レシピです。
ウェブサイト内でのユーザーができる動き(ログイン、データ編集、削除、ログアウトなど）全般の方法（手順、method)があります★★

★★function store(), login, logoutはそれぞれのしたい作業の手順です★★
*/


/*
    include - will include the file everytime you run the program.
    include_once - will include the file once only.

    require - will require or include the file, if not found it will stop the script
    require_once - will require once or include once the file, if not found it will stop the script
*/

require_once "Database.php";

class User extends Database
{
    //サインイン時に入力された情報をデータベースに保存。そして index.phpへの方法（手順）
    //storeにはカレーを作る手順が書かれてあり、$requestにはその材料が入っている。
    //register.php(実際に作るところ)に作る方法(store)と実際に使う材料($_POST = $request)が
    public function store($request) //userinfo is also okay
    {
        $first_name = $request['first_name']; // the name of form in HTML
        $last_name = $request['last_name'];
        $username = $request['username'];
        $password = $request['password'];

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, username, password) VALUES ('$first_name', '$last_name', '$username', '$password')";

        //execute in sql
        if($this->conn->query($sql)){
            header('location: ../views');  // go to index.php or the login page
            //we don't need to add index.php after views. becauser it will automatically work.
            exit;                          //same as die
        } else {
            die('Error creating the user: '.$this->conn->error);
        }
    }

    //ログインするために、データベースから入力された情報があるか見つける。あればsession startし、dashboard.phpへ
    public function login($request)
    {
        $username = $request['username'];
        $password = $request['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'";

        //$result holds the data of spesific username
        $result = $this->conn->query($sql);

        #check the username
        if($result->num_rows == 1){
            $user = $result->fetch_assoc();
            // $user(rene) = ['id' => 1 'first_name => 'Rene', 'last_name' => 'okamura', 'username' => 'rene'];

            // $user['id'] get value 1
            // $user['first_name'] get value 'Rene'
            // $user['last_name'] get value 'okamura'

            if(password_verify($password, $user['password'])){
                #create session variables for future use.
                session_start();
                $_SESSION['id']            = $user['id'];
                $_SESSION['username']      = $user['username'];
                $_SESSION['full_name']     = $user['first_name']. " " .$user['last_name'];

                header('location: ../views/dashboard.php');
                exit;
            } else {
                die('Passowrd is incorrect');
            }
        } else {
            die('Username not found.');
        }
    }

    //ログアウトする方法
    public function logout()
    {
        session_start();
        session_unset(); // remove all your session having all value id, username, fullname
        session_destroy(); // remove the session we created

        header('location: ../views'); // go back to login page
        exit;
    }

    //user listのテーブルにデータベースの情報を表示させるための方法（手順）
    public function getAllUsers()
    {
        $sql = "SELECT id, first_name, last_name, username, photo FROM users"; //also can use * to apply all 

        if($result = $this->conn->query($sql)){
            return $result;
        } else {
            die('Error retrieving all users: '. $this->conn->error);
        }
    }

    //編集ボタンを押したときにfirstname, lastname, username, photoをデータから取ってきてブラウザに表示させる。
    public function getUser()
    {
        //session_start(); it's not necessarily here.
        $id = $_SESSION['id'];

        $sql = "SELECT first_name, last_name, username, photo FROM users WHERE id = $id";
        //it's not included password

        if($result = $this->conn->query($sql)){
            return $result->fetch_assoc(); 
            // associative array: ['id' => 1, 'first_name' -> 'Rene', 'last_name' => 'Okamura', 'photo' => NULL];
        } else {
            die('Error retrieving the user: '. $this->conn->error);
        }
    }

    //編集ボタンによって表示されたものを編集したときに、それがデータベース上でもアップデートされているようにする。
    public function update($request, $files)
    {
        session_start();
        $id         = $_SESSION['id'];
        $first_name = $request['first_name'];
        $last_name  = $request['last_name'];
        $username   = $request['username'];
        $photo  = $files['photo']['name']; // $photo holds the name of the photo
        $tmp_photo  = $files['photo']['tmp_name']; // holds the file from the temporary strage(img in desktop user use)
        // ['photo'] is the name of the form input file in edit-user.php(views)
        // ['name'] is the name of the file 
        // ['tmp_name'] is the temporary strage of the file
        // image in temporary strage will be saved in the image file

        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username  = '$username' WHERE id = $id"; // since id is integer, don't need to add ''.

        if ($this->conn->query($sql)){ // if it's successful to connect to spl,
            $_SESSION['username']    = $username;
            $_SESSION['full_name']   = "$first_name $last_name";
            // here is edit section and updating the session data here. and it will be displayed in the bar.
            
            #if there is an uploaded photo, save it to the db and save the file to images folder.
            
            if($photo){ // if there is the name of the image in the form input,
                $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";
                $destination = "../assets/images/$photo";
                
                // save the image name to db
                if($this->conn->query($sql)){ //if there is something wrong with the firstname, lastname, username,
                    //save the file to images folder
                    if(move_uploaded_file($tmp_photo, $destination)){
                        header('location: ../views/dashboard.php');
                        exit;
                    } else {
                        die('Error moving the photo.');
                    }
                } else {
                    die('Error uploading photo: ' . $this->conn->error);
                }
            }
            header('location: ../views/dashboard.php');
            exit;
        } else {
            die('Error updating your accout: '. $this->conn->error);
        }
    }


    public function delete()
    {
        session_start();
        $id = $_SESSION['id'];

        $sql = "DELETE FROM users WHERE id = $id";

        if ($this->conn->query($sql)){ // if this condition is ture,
            $this->logout();
        } else {
            die('Error deleting your account: '. $this->conn->error);
        }
    }
}


//$_POST, $_SESSION, $_FILES
?>