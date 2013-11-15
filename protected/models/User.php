<?php

/**
 * User Model 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class User extends CTModel {

    public function fieldRules() {
        return array(
            "id" => array(
                "maxLength" => 20,
                "minLength" => 1,
                "name" => "Identitier",
                "unique" => true,
                "required" => true,
            ),
            "username" => array(
                "maxLength" => 50,
                "minLength" => 5,
                "unique" => true,
                "required" => true,
                "regEx" => "/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/",
            ),
            "password" => array(
                "maxLength" => 40,
                "minLength" => 6,
                "required" => true,
            //"regEx" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",
            ),
            "password_repeat" => array(
                "maxLength" => 40,
                "minLength" => 6,
                "required" => true,
            //"regEx" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",
            ),
            "first_name" => array(
                "maxLength" => 50,
                "minLength" => 1,
                "unique" => true,
                "required" => true,
                "regEx" => "/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/",
            ),
            "last_name" => array(
                "maxLength" => 50,
                "minLength" => 1,
                "unique" => true,
                "required" => true,
                "regEx" => "/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/",
            ),
            "email" => array(
                "required" => true,
                "regEx" => "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/",
            ),
        );
    }

    //get all users datas to be listed in Admin Page
    public function getUsersList($page) {
        $NumberUserOf1Page = 10;
        $pos = ($page - 1) * $NumberUserOf1Page;

        //connect to db      
        $db = CTSQLite::connect();

        // Count total number Products
        $SelectQuerry = 'SELECT * FROM ic_user';
        $res = $db->query($SelectQuerry);
        $totalRecord = 0;
        while ($rows = $res->fetchArray()) {
            $totalRecord++;
        }
        $totalPages = ceil($totalRecord / $NumberUserOf1Page);

        //getting users datas from db
        $getUsersQuery = "SELECT * FROM ic_user limit " . $pos . "," . $NumberUserOf1Page;
        $result = $db->query($getUsersQuery);

        //an array to store each user's datas
        $row_results = array();

        //to count how many row in users db
        $count = 0;

        //pushing datas to $row_results

        while ($row = $result->fetchArray()) {
            array_push($row_results, $row);
            $count++;
        }

        //pushing out users datas
        for ($i = 0; $i <= $count - 1; $i++) {
            $row_results[$i]['currentPage'] = $page;
            //print_r($row_results[$i]);
            if (empty($row_results[$i]['id'])) {
                return $row_results;
            } else {
                // getting avatar's url
                $getAvaQuery = 'SELECT * FROM ic_pictures WHERE type = 9 AND user_id=' . $row_results[$i]['id'];
                $avatars = $db->query($getAvaQuery);
                $avatar = $avatars->fetchArray();
                $avatarUrl = $avatar['url'];
                $row_results[$i]['avatarUrl'] = $avatarUrl;
                
                 // Count total number Users
                $SelectQuerry = 'SELECT * FROM ic_user';
                $res = $db->query($SelectQuerry);
                $counts = 0;
                while ($rows = $res->fetchArray()) {
                    $counts++;
                }
                $row_results[$i]['totalRecord'] = $counts;
            }
        }

        return $row_results;
        $db->close();
        unset($db);
    }

    public function updateAvatarUrl() {
        $userID = $this->getVal('id');
        $newFolderName = "avatars";
        $avatar = Pictures::getUserAvatarModels($userID);

        if ($avatar->getVal('type') == 9) {
            $path = $avatar->getVal('url');
        }

        $fileName = explode('/', $path);
        print_r($fileName);
        $extension = explode('.', $fileName[3]);
        print_r($extension);
        $oldDir = BASE_PATH . $path;
        $newDir = BASE_PATH . "/images/" . $newFolderName . "/" . $_POST['user']['username'] . "." . $extension[1];
        print_r($newDir);
        rename($oldDir, $newDir);


        $newUrl = "/images/" . $newFolderName . "/" . $_POST['user']['username'] . "." . $extension[1];
        $avatar->setVal('url', $newUrl);
        $avatar->setVal('name', $_POST['user']['username']);
        $avatar->update();
    }

    public function updatePictures($files) {
        $marsk = array();
        $uploadMarsk = array();
        $folderName = "avatars";
        $pictures = Pictures::getUserAvatarModels($this->getVal('id'));
        foreach ($pictures as $picture) {
            array_push($marsk, $picture);
        }
        foreach ($files as $file) {
            array_push($uploadMarsk, $file);
        }
        for ($i = 0; $i < 4; $i++) {
            if (!empty($uploadMarsk[$i]['name'])) {
                $uploadedTo = Pictures::uploadPicture($uploadMarsk[$i], $folderName);
                // Get extension of file upload       
                $info = new SplFileInfo($uploadMarsk[$i]['name']);
                $extension = $info->getExtension();
                // Rename File upload followed by CategoryName
                $oriName = BASE_PATH . "/images/" . $folderName . "/" . $uploadMarsk[$i]['name'];
                $newName = BASE_PATH . "/images/" . $folderName . "/" . $_POST['user']['username'] . "." . $extension;
                rename($oriName, $newName);
                $url = "/images/" . $folderName . "/" . $_POST['user']['username'] . "." . $extension;
                if (isset($marsk[$i])) {
                    $marsk[$i]->setVal('url', $url);
                    if ($marsk[$i]->update()) {
                        echo 'updated picture to db <br/>';
                    } else {
                        echo 'failed to update picuture <br/>';
                    }
                } else {
                    $marsk[$i] = new Pictures();
                    $marsk[$i]->setVal('url', $url);
                    $marsk[$i]->setVal('name', $this->getVal('name'));
                    $marsk[$i]->setVal('type', 1);
                    $marsk[$i]->setVal('user_id', $this->getVal('id'));
                    if ($marsk[$i]->create()) {
                        echo 'inserted new picture to db <br/>';
                    } else {
                        echo 'cant insert new picutre <br/>';
                    }
                }
            }
        }
    }

    // public static function deleteUser($id) {
    //     $user = new User($id);
    //     $avatar = Pictures::getUserAvatarModels($id);
    //     if (count($avatar) > 0) {
    //         if ($avatar->getVal('type') == 9) {
    //             $path = $avatar->getVal('url');
    //         }
    //         $folders = explode('/', $path);
    //         $oldDir = BASE_PATH;
    //         for ($i=0; $i < 3; $i++) { 
    //             $oldDir .= $folders[$i] . '/';
    //         }
    //         if ($files = scandir($oldDir)) {
    //             foreach ($files as $file) {
    //                 $tfile = explode('.', $file);
    //                 $fileName = $tfile[0];
    //             }
    //         }
    //     }
    // }

    public function deleteUser($id) {
        $user = new User();
        $user->get($id);
        $results = $user->delete();

        if ($results) {
            return $results;
            echo "Delete user Success!!!";
        } else {
            echo "Delete user fail";
            return false;
        }
        $db->close();
        unset($db);
    }

    public function deleteFileAvatar($id) {
        $db = CTSQLite::connect();
        $getUrlQuery = 'SELECT * FROM ic_pictures WHERE user_id=' . $id;
        $results = $db->query($getUrlQuery);
        if ($row = $results->fetchArray()) {
            unlink(BASE_PATH . $row['url']);
        }
        $db->close();
        unset($db);
    }

    //list all users raw
    public function listUsers() {
        $db = CTSQLite::connect();
        $query = 'SELECT * FROM ic_user';
        $stmt = $db->prepare($query);
        $result = $stmt->execute();
        if (!$result) {
            return false;
        } else {
            // $id = $result->fetchArray();
            // return $id['id'];
            $row = $result->fetchArray();
            return $row;
        }
        $db->close();
        unset($db);
    }

    //get all user's infos
    public function getUser($id) {
        $db = CTSQLite::connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id=' . $id);
        if ($row = $results->fetchArray()) {
            return $row;
        } else {
            return false;
        }
        $db->close();
        unset($db);
    }

    //get user's role
    public function getUserRole($id) {
        $db = CTSQLite::connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id=' . $id);
        if ($row = $results->fetchArray()) {

            $userRole = $row['role'];
            return $userRole;
        } else {
            return false;
        }
        $db->close();
        unset($db);
    }

    //get user id by username
    public function getUserIdByName($name) {
        $db = CTSQLite::connect();
        $query = 'SELECT id FROM ic_user WHERE username =:name';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $result = $stmt->execute();
        if (!$result) {
            return false;
        } else {
            $id = $result->fetchArray();
            return $id['id'];
        }
        $db->close();
        unset($db);
    }

    //block user that (hacking, violate rules,.... etc)
    public function blockUser($id) {
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id=' . $id);
        if ($row = $results->fetchArray()) {

            $blockUserQuery = 'UPDATE ic_user SET active=0 WHERE id=' . $id;
            $this->db->query($blockUserQuery);

            $userName = $row['username'];
            return $userName;
        } else {
            return false;
        }
        $db->close();
        unset($db);
    }

    //authorize login and return user's role
    public function isAuthorize($username, $password) {
        $this->connect();
        $results = $this->db->query('SELECT * FROM ic_user WHERE id=' . $id);
        if ($row = $results->fetchArray()) {
            if ($username == $row['username'] && $password == $row['password']) {
                return $row['role'];
            }
        } else {
            return false;
        }
        $db->close();
        unset($db);
    }

    //check required fields
    public function checkRequiredFields($required_array) {
        $field_errors = array();
        foreach ($required_array as $fieldname) {
            if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] != 0)) {
                $field_errors[] = $fieldname;
            }
        }
        return $field_errors;
    }

    //check for field that requires max length
    //confirm query
    function confirm_query($result_set) {
        if (!$result_set) {
            die("Database query failed: " . sqlite_error());
        }
    }

    //validate login informations
    //not done yet
    // warning dont use this
    // i double dare you to use this
    public function validateLogin() {
        if (isset($_POST['submit'])) {
            $errors = array();

            $required_fields = array('username', 'password');
            $errors = array_merge($errors, checkRequiredFields($required_fields));

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($errors)) {
                $conn = CTSQLite::connect();


                //check database if user and password exist
                $query = "SELECT id, username ,role ";
                $query .= "FROM ic_user ";
                $query .= "WHERE username = '{$username}' ";
                $query .= "password = '{$password}' ";
                $query .= "LIMIT 1";

                $result = $conn->query($query);
                confirm_query($result);

                if (sqlite_num_rows($result) == 1) {
                    $user = $result->fetchArray();
                    $role = $user['role'];
                    CT::user()->setRole($role);
                }
            } else {
                if (count($errors) == 1) {
                    // 1 error ocurred
                    $message = "There was 1 error in the form";
                } else {
                    //more than 1 error occured
                    $message = "There were" . count($errors) . "errors in the form";
                }
            }
        } else {
            //form has not been submitted
        }
    }

}
