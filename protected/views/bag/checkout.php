<?php
    print_r($data);
?>

<div class="content-inner single-col clearfix">
    <link rel="stylesheet" type="text/css" href="<?php echo ct::baseURL() ?>/css/bag.css"> 
    <form class="shipping-detail"
          method="POST"
          action="/Bag/Checkout/">
        <div class="checkout-step customer-info">
            <div class="checkout-step-header"><h2>1. Basic info</h2></div>
            <div class="checkout-step-content clearfix">
                <div class="shipping-info">
                    <h2>Shipping info</h2>
                    <div id="customer-info-form">
                        <input type="text" name="shipping[customer_first_name]" placeholder="First Name *">
                        <input type="text" name="shipping[customer_last_name]" placeholder="Last Name *">
                        <input type="text" name="shipping[customer_email]" placeholder="Email *">
                        <input type="text" name="shipping[ship_address]" placeholder="Adress *">
                        <input type="text" name="shipping[customer_phone]" placeholder="Phone Number *">
                    </div>
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
            <input type="radio" name="shipping[payment]" value="visa">Visa<br/>
            <input type="radio" name="shipping[payment]" value="paypal">PayPal<br/>
            
        </div>
        <div class="checkout-step">
            <div class="checkout-step-header"><h2>3. Confirm Order</h2></div>
            <input type="submit" value="Confirm order">
        </div>
    </form>
    <div class="bag-detail">

    </div>
</div>