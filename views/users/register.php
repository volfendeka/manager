<div class="login_register">
    <div class="form_container">
        <p class="login_register_title"> Registration </p>
        <?php
        $errorHendler = isset($this->error)?$this->error:"";
        use contact\helpers\HtmlHelper;

        echo HtmlHelper::beginForm();
        echo HtmlHelper::contentForm(array("Login:" => "login",
            "Password:" => "password",
            "Repeat password:" => "repeat_password"),
            $errorHendler,
            "",
            "register_div");
        ?>
        
        <?php
        echo HtmlHelper::endForm("Register");
        ?>
    </div>
</div>