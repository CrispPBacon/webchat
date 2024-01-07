    <!-- LOGIN COMPONENT -->
    <div class="login-card-container">
        <div class="login-card">
            <div class="login-card-header">
                <h1>Sign-in</h1>
                <p>We are happy to have you back</p>
            </div>
            <form action="#" class="login-card-form" id="login-card-form">
                <loginfailed id="errorMessage"></loginfailed>
                <div class="form-item">
                    <input type="text" placeholder="Username" name="username">
                    <ion-icon name="person"></ion-icon>
                </div>
                <div class="form-item">
                    <input type="password" placeholder="Password" name="password">
                    <ion-icon name="lock-closed"></ion-icon>
                </div>
                <div class="form-item-other">
                    <span>
                        <input type="checkbox" id="rememberMe">
                        <label for="rememberMe">Remember me</label>
                    </span>
                    <a href="#">Forgot password?</a>
                </div>
                <span id="login"><input type="submit" value="LOGIN"></span>
            </form>
            <span>Don't have an account? <a href="#" id="showReg">Sign up</a></span>
        </div>
    </div>

    <!-- REGISTER COMPONENT -->
    <div class="register-card-container hidden">
        <div class="login-card register-card">
            <div class="login-card-header">
                <h1>Sign-up</h1>
                <p>We are happy to have you</p>
            </div>
            <form action="#" class="login-card-form">
                <div class="form-item">
                    <input type="text" placeholder="Full Name">
                    <ion-icon name="person"></ion-icon>
                </div>
                <!-- <div class="form-item">
                    <input type="text" placeholder="Email">
                    <ion-icon name="mail"></ion-icon>
                </div> -->
                <div class="form-item">
                    <input type="text" placeholder="Username">
                    <ion-icon name="glasses"></ion-icon>
                </div>
                <div class="form-item">
                    <input type="password" placeholder="Password">
                    <ion-icon name="lock-closed"></ion-icon>
                </div>
                <div class="form-item">
                    <input type="password" placeholder="Confirm Password">
                    <ion-icon name="lock-closed"></ion-icon>
                </div>
                <span><input type="submit" value="Sign up" style="margin-top: 1rem;"></span>
            </form>
            <span>Already have an account? <a href="#" id="showLgn">Sign in</a></span>
        </div>
    </div>