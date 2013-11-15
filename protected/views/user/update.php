<?php
$user = $data['model'];
$avatar = $data['avatarUrl'];
//print_r($pic['url']);
?>

<div class="single-col">
    <form id="register-form" class="user-infos"
    action="/User/Update/<?= $user['id'] ?>"
    method="POST"
    enctype="multipart/form-data">
    <input type='hidden' value='<?= $user['id'] ?>' name ="user[id]">
        <div class="clearfix">
            <div class="avatar-view shadow-box empty pic-input">
                <img height="100%" src="<?= isset($avatar['url']) ? $avatar['url'] : "" ?>"/>
                <input type="file" accept="image/*" name="avatar" class="file" onchange="preview(this)">
            </div>
            <div class="basic-authen">
                <span class="info-group-header">Basic authentication information</span>
                <label>Username:</label>
                <input value="<?= $user['username'] ?>" type="text" name="user[username]" placeholder="Username">
                <label>Password:</label>
                <input value="<?= $user['password'] ?>" type="text" name="user[password]" placeholder="Password">
                <!-- <input type="password" name="register[password_repeat]" placeholder="Confirm password"> -->
                <span class="info-group-header">Personal informations</span>
                <label>First Name:</label>
                <input value="<?= $user['first_name'] ?>" type="text" name="user[first_name]" placeholder="First Name"/>
                <label>Last Name:</label>
                <input value="<?= $user['last_name'] ?>" type="text" name="user[last_name]" placeholder="Last Name"/>
                <label>Email:</label>
                <input value="<?= $user['email'] ?>" type="text" name="user[email]" placeholder="Email Adress"/>
                <label>Address:</label>
                <input value="<?= $user['address'] ?>" type="text" name="user[address]" placeholder="Address"/>  
                <input type="submit" value="Update"/>
            </div>
        </div>
    </form>
</div>