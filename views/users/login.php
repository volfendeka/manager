<div class="login_register">
    <div class="form_container">
        <p class="login_register_title"> Authorisation </p>
        <?php
        $errorHendler = isset($this->error)?$this->error:"";
        use contact\helpers\HtmlHelper;

        echo HtmlHelper::beginForm();
        echo HtmlHelper::contentForm(array("Login:" => "login",
            "Password:" => "password"),
            $errorHendler,
            "",
            "login_div");
        ?>
        <div class="login_links">
            <a href="<?= URL?>Users/toRegister/">Forgot Password?</a>
            <br>
            <a href="<?= URL?>Users/toRegister/">Register Now!</a>
        </div>
        <?php
        echo HtmlHelper::endForm("Login");
        ?>
    </div>
</div>
