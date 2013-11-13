<div class="content-inner single-col clearfix">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/bag.css"> 
    <div class="shipping-detail">
        <div class="checkout-step customer-info">
            <div class="checkout-step-header"><h2>1. Basic info</h2></div>
            <div class="checkout-step-content clearfix">
                <div class="shipping-info">
                    <h2>Shipping info</h2>
                    <form id="customer-info-form">
                        <input type="text" name="shipping[first_name]" placeholder="First Name *">
                        <input type="text" name="shipping[last_name]" placeholder="Last Name *">
                        <input type="text" name="shipping[email]" placeholder="Email *">
                        <input type="text" name="shipping[adress]" placeholder="Adress *">
                        <input type="text" name="shipping[phone]" placeholder="Phone Number *">
                    </form>
                </div>
                <div class="user-options">
                    <div class="user-options-wrapper">
                        <h2>User Options</h2>
                        <a href="/site/Login/" class="dark-box-ajax link-bt">Login</a>
                        <a href="/site/Signup/" class="link-bt">Sign Up</a> 
                    </div>
                </div>
            </div>
        </div>
        <div class="checkout-step">
            <div class="checkout-step-header"><h2>2. Payment Selection</h2></div>
            <input type="radio" name="checkout[payment]" value="visa">Visa<br/>
            <input type="radio" name="checkout[payment]" value="paypal">PayPal<br/>
            
        </div>
        <div class="checkout-step">
            <div class="checkout-step-header"><h2>3. Confirm Order</h2></div>
            <input type="submit" value="Confirm order">
        </div>
    </div>
    <div class="bag-detail">

    </div>
</div>