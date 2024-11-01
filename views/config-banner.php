<div class="tidyant-container">
    <div>
        <img src="<?= plugins_url('img/logo-tidyant-web.png', __FILE__) ?>"
             class="tidyant-center">
    </div>

    <div>
        <h1 class="tidyant"><?= __('TidyAnt API', 'tidyant') ?></h1>
    </div>
    <div class="tidyant-content">
        <div class="">
            <?= __('Instructions', 'tidyant') ?>
            <ol>
                <li>
                    <?= __('You have to create an api key in your TidyAnt application, for creating an new key you have to go to company menu', 'tidyant') ?>
                </li>
                <li>
                    <?= __('You have to configure the credentials (tenancy and api key) in plugin settings, you can go to the settings page with the configure plugin button or going to the menu Settings -> TidyAnt API', 'tidyant') ?>
                    .
                </li>
                <li>
                    <?= __('To activate the repair form you have to add the wildcard <b>{tidyant}</b> in any page or post. The plugin will replace the wildcard for a form', 'tidyant') ?>
                    .
                </li>
            </ol>
            <p>
                <?= __('When the plugin is configured this banner will disappear, if you see this banner it means that the plugin is not properly configured', 'tidyant') ?>
                .
            </p>
            <p>
                <?= __('Notice: the banner will disappear although you do not write the willdcard, plugin only checks if the credentials are properly set', 'tidyant') ?>
                .
            </p>
        </div>
    </div>
    <div>
        <a href="options-general.php?page=tidyant-config-admin"
           class="tidyant-button"><?= __('Configure plugin', 'tidyant') ?></a>
    </div>
</div>