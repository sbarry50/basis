<fieldset>
    <?php if (array_key_exists('legend', $args['args'])) : ?>
        <p><legend><?=$args['args']['legend'] ?></legend></p>
    <?php endif; ?>
    <?php foreach ($args['args'] as $options) : ?>
        <?php if (!is_array($options)) {
    continue;
} ?>
        <div>
            <input 
                type="checkbox" 
                id="<?=$options['id'];?>" 
                name="<?=$args['id'];?>[]" 
                value="<?=$options['id'];?>" 
                <?= in_array($options['id'], $args['value'] ? $args['value'] : []) ? 'checked' : ''; ?>
            >
            <label for="<?=$options['id'];?>"><?=$options['label'];?></label>
        </div>
    <?php endforeach; ?>
</fieldset>