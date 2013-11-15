<?php

/**
 * UserController 
 * 
 * @author duyht <duyht@smartosc.com>
 * @created 28 Oct 2013
 * @copyright &copy; 2013 Createve Team 
 */
class UserController extends CTController {

    public function actionList($page) {
        if (!empty($page)) {
            $user = new User();
            $pic = new Pictures();

            if (isset($_POST['checkbox'])) {
                foreach ($_POST['checkbox'] as $id) {
                    $u = new User($id);
                    $u->delete();
                }
            }

            if (isset($_POST['user'])) {
                foreach ($_POST['user'] as $id) {
                    if (!isset($_POST['cbActive'][$id])) {
                        $u = new User($id);
                        $u->setVal('active', '0');
                        $u->update();
                    } else {
                        $u = new User($id);
                        $u->setVal('active', '1');
                        $u->update();
                    }
                }
            }

            $data = $user->getUsersList($page);

            CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'users');
            $this->render('list', $data);
            //exit;
        } else {
            header("Location: http://irene.local/User/List/1");
        }
    }

    public function actionUpdate($id) {
        if (isset($_POST['user'])) {
            $user = new User();
            print_r($_POST['user']);
            $user->setData($_POST['user']);

            if ($user->changesThanOrigin()) {
                $oldUserInfo = new User($_POST['user']['id']);
                if ($user->update()) {
                    if ($oldUserInfo->getVal('username') != $user->getVal('username')) {
                        # code...
                        $folderName = "avatars";
                        foreach (array_keys($_FILES) as $key) {
                            Pictures::uploadPicture($_FILES[$key], $folderName);
                            $user->updateAvatarUrl();
                        }
                    }
                    echo 'update info sucessfully <br/>';
                } else {
                    echo "update failed";
                }
            } else {
                echo "nothing changes";
            }

            if ($this->hasChanges($_FILES)) {
                $user->updatePictures($_FILES);
            }
        }

        if (!empty($id)) {
            $model = new User();
            $model->get($id);
            $avatar = new Pictures();
            $avatarUrl = Pictures::getUserAvatar($id);
            CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'users');
            $this->layout = 'main';
            $this->render('update', array(
                'model' => $model->getData(),
                'avatarUrl' => $avatarUrl,
            ));
        } else {
            header("Location: http://irene.local/User/List");
        }
    }

    private function hasChanges($files) {
        foreach ($files as $file) {
            if (!empty($file['name'])) {
                return true;
            }
        }
        return false;
    }

    public function actionDelete($id) {
        $user = new User();
        $user->deleteUser($id);
        $user->deleteFileAvatar($id);

        $pic = new Pictures();
        $pic->deleteAvatar($id);

        CT::widgets('MainMenu')->setActive(ADMIN_MENU, 'users');
        $this->layout = 'main';
        $this->render('delete', $id);
    }

    public function actionGetUser($id) {
        //$model = $this->loadModel('User');
        //$userData = $model->getUser($id);
        //this->render
        if (!empty($id)) {
            $model = new User();
            $row = $model->getUser($id);
            if (empty($row)) {
                Bootstrap::error('404');
            } else {
                $userData = $row;
                print_r($userData);
            }
        } else {
            header("Location: http://irene.local/");
        }
    }

    public function actionGetUserRole($id) {

        if (!empty($id)) {
            $model = new User();
            $row = $model->getUserRole($id);
            if (empty($row)) {
                Bootstrap::error('404');
            } else {
                $userRole = $row;
                echo "Get User's role successful! Role is " . $userRole;
            }
        } else {
            header("Location: http://irene.local/");
        }
    }

    public function actionBlockUser($id) {

        if (!empty($id)) {
            $model = new User();
            $row = $model->blockUser($id);
            if (empty($row)) {
                Bootstrap::error('404');
            } else {
                $userName = $row;
                echo "Block user successful! User name is " . $userName;
            }
        } else {
            header("Location: http://irene.local/");
        }
    }

}