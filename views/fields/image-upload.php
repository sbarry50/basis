<div class="upload">
    <img data-src="<?=$args['default_image'];?>" src="<?=$args['src'];?>" width="<?=$args['width'];?>" height="<?=$args['height'];?>" />
    <div>
        <input type="hidden" name="<?=$args['id'];?>" id="<?=$args['id'];?>" value="<?=$args['value'];?>" />
        <button type="button" class="upload_image_button button-primary">Upload Image</button>
        <button type="button" class="remove_image_button button-primary">&times;</button>
    </div>
</div>