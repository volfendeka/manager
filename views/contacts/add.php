<div class="add_view_edit_form">
    <div class="form_container">
    <h2> Information </h2>
<?php
$errorHendler = isset($this->error)?$this->error:"";
use contact\helpers\HtmlHelper;

echo HtmlHelper::beginForm();

echo HtmlHelper::contentForm(array("First name:" => "first_name",
                                    "Last name:" => "last_name",
                                    "Email:" => "email",
                                    "Home:" => array("home_phone", "radio", "best_phone", "h"),
                                    "Work:" => array("work_phone", "radio", "best_phone", "w"),
                                    "Cell:" => array("cell_phone", "radio", "best_phone", "c", "checked"),
                                    "Address 1:" => "address1",
                                    "Address 2:" => "address2",
                                    "City:" => "city",
                                    "State:" => "state",
                                    "Zip:" => "zip",
                                    "Country:" => "country",
                                    "Birth date:" => "birth_date",),
                            $errorHendler,
                            "",
                            "person_info"
                            );
?>
        <?php
        echo HtmlHelper::endForm("Done");
        echo HtmlHelper::img("/public/img/arrow_done.png", array("width"=>"5px",
                                                                 "height"=>"5px"));
        ?>
        </div>
</div>
