<div class="single-col">
    <form id="register-form" class="user-infos"
    action="/site/Signup/"
    method="POST">
        <div class="clearfix">
            <div class="avatar-view shadow-box empty pic-input">
                <img height="100%">
                <input type="file" accept="image/*" name="avatar" class="file" onchange="preview(this)">
            </div>
            <div class="basic-authen">
                <span class="info-group-header">Basic authentication information</span>
                <input type="text" name="register[username]" placeholder="Username">
                <input type="password" name="register[password]" placeholder="Password">
                <input type="password" name="register[password_repeat]" placeholder="Repeat password">
                <span class="info-group-header">Personal informations</span>
                <input type="text" name="register[first_name]" placeholder="First Name"/>
                <input type="text" name="register[last_name]" placeholder="Last Name"/>
                <input type="text" name="register[email]" placeholder="Email Adress"/>
                <input type="text" name="register[address]" placeholder="Address"/>  
                <input type="submit" value="Submit"/>
                <input type ="reset" value="Reset"/>
            </div>
        </div>
    </form>
</div>