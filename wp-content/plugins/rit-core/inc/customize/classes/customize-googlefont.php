<?php
/**
 * RIT Core Plugin
 * @package     RIT Core
 * @version     2.3.0
 * @author      Zootemplate
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2015 Zootemplate
 * @license     GPL v2
 */

class WP_Customize_Googlefont_Control extends WP_Customize_Control
{
    public $type = 'googlefont';
    /**
     * Render the control's content.
     *
     * @since 3.4.0
     */
    public function render_content()
    {

//        $ggfont_url = 'www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAVT6Xd4qTswxLkmYTb6e_gH7iDpbxTx5M';
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $ggfont_url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_HEADER, false);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//        $listGoogleFont = curl_exec($curl);
//
//
//        if(curl_error($curl) || $listGoogleFont == ''){
        $listGoogleFont = file_get_contents(RIT_PLUGIN_PATH . 'inc/customize/assets/googlefont.txt');
//        }
//        curl_close($curl);

        if($listGoogleFont){
            $gfont = json_decode($listGoogleFont, true);
        }

        $value = array();
        if($this->value()){
            $value = json_decode($this->value(), true);
        }

        ?>
        <label>
            <h3><?php echo $this->label; ?></h3>
        </label>
        <ul class="customize-wrap-rit_google_font">

            <li class="customize-control customize-control-rit_google_font">
                <label>
                    <span class="customize-control-title">Select Font Family</span>
                    <select class="rit-customize-google-font-family">
                        <?php
                        foreach ($gfont['items'] as $font) {
                            $selected = '';
                            if(isset($value['family']) &&  $value['family'] == $font['family']){
                                $selected = 'selected';
                            }
                            ?>
                            <option
                                value="<?php echo esc_attr($font['family'])?>"
                                data-variants="<?php echo esc_attr( implode(',', $font['variants']))?>"
                                data-subsets="<?php echo esc_attr( implode(',', $font['subsets']))?>"
                                data-category="<?php echo esc_attr( $font['category'] )?>"
                                <?php echo esc_attr($selected) ?> >
                                <?php echo esc_html($font['family'])?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </label>
                <br />
                <br />
                <?php

                $font_current_item = $gfont['items'][0];
                if(isset($value['family'])){
                    foreach ($gfont['items'] as $font){
                        if($value['family'] == $font['family']){
                            $font_current_item = $font;
                        }
                    }
                }
                ?>
                <label>
                    <span class="customize-control-title">Select Font Variants</span>
                    <ul class="rit-customize-font-variant">
                        <?php
                        foreach ($font_current_item['variants'] as $variant) {
                            $checked = '';
                            if(isset($value['variants']) && in_array($variant, $value['variants'])){
                                $checked = 'checked';
                            }
                            ?>
                            <li><input <?php echo esc_attr($checked) ?> class="rit-customize-google-font-variant " type="checkbox" value="<?php echo esc_attr($variant) ?>"><?php echo esc_html($variant) ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </label>
                <br />
                <label>
                    <span class="customize-control-title">Select Font Subsets</span>
                    <ul class="rit-customize-font-subset">
                        <?php
                        foreach ($font_current_item['subsets'] as $subset) {
                            $checked = '';
                            if(isset($value['subsets']) && in_array($subset, $value['subsets'])){
                                $checked = 'checked';
                            }
                            ?>
                            <li><input <?php echo esc_attr($checked) ?> class="rit-customize-google-font-subset" type="checkbox" value="<?php echo esc_attr($subset) ?>"><?php echo esc_html($subset) ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </label>
            </li>

            <input class="customize-input-google-font" type="hidden" <?php echo $this->get_link() ?> value="<?php echo esc_attr($this->value()) ?>" />
        </ul>

        <br />
        <hr />
        <?php
    }
}
