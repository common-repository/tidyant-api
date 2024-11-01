<?php
if ($repair instanceof \Tidyant_API\Admin\Models\Repair) {
    ?>
    <div class="wrap">
    <h4><?=__('Repair saved!', 'tidyant')?></h4>
        <?php
        if (\Tidyant_API\Admin\Tidyant::showRepairLink() == true) {
            ?>
            <a href="<?= $repair->getUrl() ?>"><?= __('Go to repair page', 'tidyant') ?></a>
            <?php
        }
        ?>
    </div>
    <?php
}
else {
    $lastError = \Tidyant_API\Admin\API::init()->getLastError();
    if (!empty($lastError)) {
        ?>
        <div class="tidyant-error"> <?= $lastError ?></div>
        <?php
    }
    ?>
    <div class="tidyant-container">
    <form action="" method="post" name="tidyant_save_repair_form" id="tidyant_save_repair_form"
          enctype="multipart/form-data">
        <div class="tidyant-row">
            <input type="text" name="name" id="name" value="" class="tidyant-mandatory">
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_brand"><?= __('Brand', 'tidyant') ?> *</label>
            </div>
            <div class="tidyant-col-65">
                <select name="tidyant_brand" id="tidyant_brand">
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_model"><?= __('Model', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <select name="tidyant_model" id="tidyant_model" disabled>
                </select>
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_picture"><?= __('Picture', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input name="tidyant_picture" type="file">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_name"><?= __('Name', 'tidyant') ?> *</label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_name" id="tidyant_name">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_identifier"><?= __('Identifier', 'tidyant') ?> *</label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_identifier" id="tidyant_identifier">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_business_name"><?= __('Business name', 'tidyant') ?> *</label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_business_name" id="tidyant_business_name">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_address"><?= __('Address', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_address" id="tidyant_address">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_city"><?= __('City', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_city" id="tidyant_city">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_state"><?= __('State', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_state" id="tidyant_state">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_country"><?= __('Country', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_country" id="tidyant_country">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_postcode"><?= __('Postcode', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_postcode" id="tidyant_postcode">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_phone"><?= __('Phone', 'tidyant') ?> *</label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_phone" id="tidyant_phone">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_email"><?= __('Email', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_email" id="tidyant_email">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_web"><?= __('Web', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_web" id="tidyant_web">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_contact"><?= __('Contact', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <input type="text" name="tidyant_contact" id="tidyant_contact">
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-col-35">
                <label for="tidyant_observations"><?= __('Observations', 'tidyant') ?></label>
            </div>
            <div class="tidyant-col-65">
                <textarea name="tidyant_observations" id="tidyant_observations"></textarea>
            </div>
        </div>
        <div class="tidyant-row">
            <div class="tidyant-button-container">
                <input type="button" name="tidyant_save_repair" id="tidyant_save_repair" class="tidyant-button"
                       value="<?= __('Save repair', 'tidyant') ?>">
                <?php wp_nonce_field('tidyant_save_repair', 'tidyant-security-code'); ?>
                <input name="action" value="tidyant_save_repair" type="hidden">
            </div>
        </div>
    </form>
    </div>
<?php
}
$repair = null;
?>
