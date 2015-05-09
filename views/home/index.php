<h1>Welcome to Home!</h1>
<?php if(!$this->isLoggedIn): ?>
    <a href="/account/login">Login</a>
    <a href="/account/register">Register</a>
<?php endif; ?>
