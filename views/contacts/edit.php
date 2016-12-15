<div class="add_view_edit_form">
    <div class="form_container">
    <h2> Edit </h2>
<?php
$errorHendler = isset($this->error)?$this->error:"";
use contact\helpers\HtmlHelper;

echo HtmlHelper::beginForm();

echo HtmlHelper::contentForm(array("First name:" => "first_name",
                                    "Last name:" => "last_name",
                                    "Email:" => "email",
                                    "Home:" => "home_phone",
                                    "Work:" => "work_phone",
                                    "Cell:" => "cell_phone",
                                    "Best:" => "best_phone",
                                    "Address 1:" => "address1",
                                    "Address 2:" => "address2",
                                    "City:" => "city",
                                    "State:" => "state",
                                    "Zip:" => "zip",
                                    "Country:" => "country",
                                    "Birth date:" => "birth_date",),
                                $errorHendler,
                                $this->data,
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
