<div <?=SB2Media\Basis\has_opening_hours($args['menu_slug']) ? 'id="opening-hours"' : null ?>  class="wrap">
    <h1><?=$args['page_title']?></h1>
    <?php \settings_errors(); ?>

    <form method="POST" action="options.php">
        <?php \settings_fields(SB2Media\Basis\app('settings')->option_group); ?>
        <?php do_settings_sections($args['menu_slug']); ?>
        <?php \submit_button(); ?>
    </form>
</div>