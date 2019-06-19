<div <?=isset($args['args']['opening_hours']) && $args['args']['opening_hours'] ? 'id="opening-hours"' : null ?> class="meta-box-container">
    <?php foreach ($args['meta_fields'] as $meta_field) : ?>
        <div class="meta-box-field-row">
            <div class="meta-box-field-label">
                <div class="meta-box-field-title">
                    <?php if (array_key_exists('title', $meta_field) && !empty($meta_field['title'])) :
                        echo $meta_field['title'];
                    endif; ?>
                </div>
                <div class="meta-box-field-description">
                    <?php if (array_key_exists('description', $meta_field) && !empty($meta_field['description'])) :
                        echo $meta_field['description'];
                    endif; ?>
                </div>
            </div>
            <div class="meta-box-field">
                <?php SB2Media\Basis\app('views')->render($meta_field['callback'], $meta_field, true); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>