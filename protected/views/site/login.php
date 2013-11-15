<div class="single-col">
    <div class="login-container">
        <form id="login-form" action="/site/Login/" 
        class="clearfix "
        method="POST">
            <span class="logo">И</span>
            <input type="text" name="login[username]" placeholder="username" required>
            <input type="password" name="login[password]" placeholder ="password" required>     
            <!-- <div class="remember-me">
                <input type="checkbox" name="login[remember]" id="login[remember]" value="1">
                <label for="login[remember]">Remember me</label>
            </div> -->
            <input type="submit" value="Log in">
            <a href="/site/Signup/" class="sign-up link-bt">Sign Up!</a>
            <!-- <a href="/site/PasswordRetrive/" class="forget-link">Forget Password</a> -->
        </form>
    </div>

</div>