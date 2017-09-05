<span class="customize-control-title">
    <?php esc_html_e('Export', RIT_TEXT_DOMAIN); ?>
</span>
<span class="description customize-control-description">
    <?php esc_html_e('Click the button below to export the customization settings for this theme.', RIT_TEXT_DOMAIN); ?>
</span>
<input type="button" class="button" name="rit-export-button"
       value="<?php esc_attr(esc_html_e('Export', RIT_TEXT_DOMAIN)); ?>"/>

<hr class="rit-hr"/>

<span class="customize-control-title">
    <?php esc_html_e('Import', RIT_TEXT_DOMAIN); ?>
</span>
<span class="description customize-control-description">
    <?php esc_html_e('Upload a file to import customization settings for this theme.', RIT_TEXT_DOMAIN); ?>
</span>
<div class="rit-import-controls">
    <input type="file" name="rit-import-file" class="rit-import-file"/>
    <label class="rit-import-images">
        <input type="checkbox" name="rit-import-images"
               value="1"/> <?php esc_html_e('Download and import image files?', RIT_TEXT_DOMAIN); ?>
    </label>
    <?php wp_nonce_field('rit-importing', 'rit-import'); ?>
</div>
<div class="rit-uploading"><?php esc_html_e('Uploading...', RIT_TEXT_DOMAIN); ?></div>
<input type="button" class="button" name="rit-import-button"
       value="<?php esc_attr(esc_html_e('Import', RIT_TEXT_DOMAIN)); ?>"/>