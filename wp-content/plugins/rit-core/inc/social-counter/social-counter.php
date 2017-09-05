<?php
if (!class_exists('RIT_SOCIAL_COUNTER')) {

    class RIT_SOCIAL_COUNTER {

        var $rit_sc_settings;

        public function __construct() {

            $this->rit_sc_settings = get_option('rit_sc_settings');

            if(!$this->rit_sc_settings){
                $rit_sc_settings = $this->get_default_settings();
                $this->rit_sc_settings = $rit_sc_settings;
                update_option('rit_sc_settings', $rit_sc_settings);
            }

            $this->init();
            
        }

        public static function &getInstance()
        {
            static $instance;

            if (!isset($instance)) {

                $instance = new RIT_SOCIAL_COUNTER();
            }

            return $instance;
        }


        public function init(){

            add_action('init', array($this, 'session_init')); //starts the session

            add_action('admin_menu', array($this, 'add_sc_menu')); //adds plugin menu in wp-admin

            add_action('admin_enqueue_scripts', array($this, 'register_admin_assets')); //registers admin assests such as js and css
            
            add_action('wp_enqueue_scripts', array($this, 'register_frontend_assets')); //registers js and css for frontend
            
            add_action('admin_post_rit_sc_settings_action', array($this, 'rit_sc_settings_action')); //recieves the posted values from settings form
            
            add_action('admin_post_rit_sc_restore_default', array($this, 'rit_sc_restore_default')); //restores default settings;
   
            add_shortcode('rit-social-counter', array($this, 'rit_sosial_counter_shortcode')); //adds a shortcode

        }

        public function rit_sosial_counter_shortcode($atts) {

            $atts = shortcode_atts(array(
                'social_list' => '',
                'counter_format' => 'comma'
            ), $atts);

            return rit_get_template_part('shortcode', 'social-counter', array('atts' => $atts));
        }

       
        public function add_sc_menu() {
            add_menu_page(__('RIT Social Counter', RIT_TEXT_DOMAIN), __('RIT Social Counter', RIT_TEXT_DOMAIN), 'manage_options', 'rit-social-counter', array($this, 'rit_sc_settings'));
        }

        public function rit_sc_settings() {
            include('settings.php');
        }

        
        public function register_admin_assets() {
            if (isset($_GET['page']) && $_GET['page'] == 'rit-social-counter') {
                wp_enqueue_style('rit-social-counter-admin-css', RIT_PLUGIN_URL . 'inc/social-counter/css/rit-social-counter-backend.css', array(), RIT_VERSION);
            }

            wp_enqueue_style('fontawesome-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',false,RIT_VERSION);
        }

       
        public function register_frontend_assets() {
          
            wp_enqueue_style('rit-social-counter-frontend-css', RIT_PLUGIN_URL . 'inc/social-counter/css/rit-social-counter-frontend.css', array(), RIT_VERSION);
            
        }

        
        public function rit_sc_settings_action() {

            if (!empty($_POST) && wp_verify_nonce($_POST['rit_sc_settings_nonce'], 'rit_sc_settings_action')) {
            
                update_option('rit_sc_settings', $_POST['social_profile']);

                update_option('rit_sc_cache_time', $_POST['rit_sc_cache_time']);

                $_SESSION['rit_sc_message'] = __('Settings Saved Successfully', RIT_TEXT_DOMAIN);

                wp_redirect(admin_url().'admin.php?page=rit-social-counter');
            }
        }

      
        public function print_array($array) {
            echo "<pre>";
            print_r($array);
            echo "</pre>";
        }

      
        public function session_init() {
            if (!session_id()) {
                session_start();
            }
        }


        public function rit_get_facebook_share($url, $cache_time = 600){


            $transient_id = 'sc_fb_'. md5($url);

            $count = get_transient($transient_id);

            if (false === $count) {
                $url = trim( 'http://graph.facebook.com/?id=' . esc_url($url));
                $headers = array();
                $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
                $headers[] = 'Connection: Keep-Alive';
                $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
                $user_agent = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36';
                $process = curl_init($url);
                curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($process, CURLOPT_HEADER, 0);
                curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
                curl_setopt($process, CURLOPT_TIMEOUT, 30);
                curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($process, CURLOPT_CAINFO, NULL);
                curl_setopt($process, CURLOPT_CAPATH, NULL);
                $api = curl_exec($process);

                $fb_data = json_decode($api, true);

                if(isset($fb_data['shares'])){
                    $count = $fb_data['shares'];
                }else {
                    $count = 0;
                }

                $cache_time = (intval($cache_time) > 0 ) ? $cache_time : 600;

                if($cache_time > 0){

                    set_transient($transient_id, $count, intval($cache_time));

                }
            }

            return $count;
            
        }


        public function rit_get_reddit_share($url, $cache_time = 600){

            $transient_id = 'sc_reddit_'. md5($url);

            $count = get_transient($transient_id);

            if (false === $count) {

                $url = trim( 'http://www.reddit.com/api/info.json?url=' . esc_url($url));
                $headers = array();
                $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
                $headers[] = 'Connection: Keep-Alive';
                $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
                $user_agent = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36';
                $process = curl_init($url);
                curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($process, CURLOPT_HEADER, 0);
                curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
                curl_setopt($process, CURLOPT_TIMEOUT, 30);
                curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($process, CURLOPT_CAINFO, NULL);
                curl_setopt($process, CURLOPT_CAPATH, NULL);
                $api = curl_exec($process);

               
                $ups = 0;
                $downs = 0;

                if($api) {
                    $json = json_decode($api,true);

                    foreach($json['data']['children'] as $child) { 
                        $ups+= (int) $child['data']['ups'];
                        $downs+= (int) $child['data']['downs'];
                    }

                    $count = $ups - $downs;

                    $cache_time = (intval($cache_time) > 0 ) ? $cache_time : 600;

                    if($cache_time > 0){

                        set_transient($transient_id, $count, intval($cache_time));

                    }
                }

                return $count;
            }
        }


        public function rit_get_google_plus_share($url , $cache_time = 600){

            $transient_id = 'sc_gg_'. md5($url);

            $count = get_transient($transient_id);

            if (false === $count) {

                $curl = curl_init();
                curl_setopt( $curl, CURLOPT_URL, "https://clients6.google.com/rpc" );
                curl_setopt( $curl, CURLOPT_POST, 1 );
                curl_setopt( $curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]' );
                curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-type: application/json' ) );
                $curl_results = curl_exec( $curl );
                curl_close( $curl );
                $json = json_decode( $curl_results, true );

                $count = intval( $json[0]['result']['metadata']['globalCounts']['count'] );

                $cache_time = (intval($cache_time) > 0 ) ? $cache_time : 600;

                if($cache_time > 0){

                    set_transient($transient_id, $count, intval($cache_time));

                }
            }

            return $count;
        }

        public function rit_get_pinterest_share ( $url, $cache_time = 600 ) {

            $transient_id = 'sc_pin_'. md5($url);

            $count = get_transient($transient_id);

            if (false === $count) {

                $url = trim( 'http://api.pinterest.com/v1/urls/count.json?url=' . esc_url($url));
                $headers = array();
                $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
                $headers[] = 'Connection: Keep-Alive';
                $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
                $user_agent = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36';
                $process = curl_init($url);
                curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($process, CURLOPT_HEADER, 0);
                curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
                curl_setopt($process, CURLOPT_TIMEOUT, 30);
                curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($process, CURLOPT_CAINFO, NULL);
                curl_setopt($process, CURLOPT_CAPATH, NULL);
                $api = curl_exec($process);

               
                $body = preg_replace( '/^receiveCount\((.*)\)$/', '\\1', $api );

                $count_json = json_decode(trim( $body ), true);

                $count = $count_json['count'];

                $cache_time = (intval($cache_time) > 0 ) ? $cache_time : 600;

                if($cache_time > 0){

                    set_transient($transient_id, $count, intval($cache_time));

                }
            }
            return $count;

        }

        public function rit_get_linkedin_share ( $url, $cache_time = 600 ) {

            $transient_id = 'sc_link_'. md5($url);

            $count = get_transient($transient_id);

            if (false === $count) {

                $url = trim( 'https://www.linkedin.com/countserv/count/share?url=' . esc_html($url) .'&format=json');
                $headers = array();
                $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
                $headers[] = 'Connection: Keep-Alive';
                $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
                $user_agent = 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36';
                $process = curl_init($url);
                curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($process, CURLOPT_HEADER, 0);
                curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
                curl_setopt($process, CURLOPT_TIMEOUT, 30);
                curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($process, CURLOPT_CAINFO, NULL);
                curl_setopt($process, CURLOPT_CAPATH, NULL);
                $api = curl_exec($process);

                $count_json = json_decode( $api , true);

                $count = $count_json['count'];

                $cache_time = (intval($cache_time) > 0 ) ? $cache_time : 600;

                if($cache_time > 0){

                    set_transient($transient_id, $count, intval($cache_time));

                }
            }
            
            return $count;

        }


        public function rit_get_total_share($url){

            $fb       = $this->rit_get_facebook_share($url);
            $linkedin = $this->rit_get_linkedin_share($url);
            $pin      = $this->rit_get_pinterest_share($url);
            $google   = $this->rit_get_google_plus_share($url);
            $reddit   = $this->rit_get_reddit_share($url);

            return $this->get_formatted_count($fb + $linkedin + $pin + $google + $reddit);
        }

        public function rit_get_share_number($type, $url){

            $function = "rit_get_$type_share";

            return $function($url);

        }

        
        public function rit_sc_restore_default() {
            if (!empty($_GET) && wp_verify_nonce($_GET['_wpnonce'], 'rit-sc-restore-default-nonce')) {
                
                $rit_sc_settings = $this->get_default_settings();
                
                update_option('rit_sc_settings', $rit_sc_settings);
                
                $_SESSION['rit_sc_message'] = __('Default Settings Restored Successfully', RIT_TEXT_DOMAIN);
                
                wp_redirect(admin_url() . 'admin.php?page=rit-social-counter');
            }
        }

        
        public function get_default_settings() {
            return  array(
                        'facebook' => array('page_id' => ''),
                        'twitter' => array('username' => '', 'consumer_key' => '', 'consumer_secret' => '', 'access_token' => '', 'access_token_secret' => ''),
                        'googlePlus' => array('page_id' => '', 'api_key' => ''),
                        'instagram' => array('username' => '', 'access_token' => '','user_id'=>''),
                        'youtube' => array('username' => '', 'channel_url' => ''),
                        'soundcloud' => array('username' => '', 'client_id' => ''),
                        'dribbble' => array('username' => ''),
                    );
        }


        /**
         * 
         * @param type $user
         * @param type $consumer_key
         * @param type $consumer_secret
         * @param type $oauth_access_token
         * @param type $oauth_access_token_secret
         * @return string
         */
        public function authorization($user, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret) {
            $query = 'screen_name=' . $user;
            $signature = $this->signature($query, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret);

            return $this->header($signature);
        }

        /**
         * 
         * @param type $url
         * @param type $query
         * @param type $method
         * @param type $params
         * @return type string
         */
        public function signature_base_string($url, $query, $method, $params) {
            $return = array();
            ksort($params);

            foreach ($params as $key => $value) {
                $return[] = $key . '=' . $value;
            }

            return $method . "&" . rawurlencode($url) . '&' . rawurlencode(implode('&', $return)) . '%26' . rawurlencode($query);
        }

        /**
         * 
         * @param type $query
         * @param type $consumer_key
         * @param type $consumer_secret
         * @param type $oauth_access_token
         * @param type $oauth_access_token_secret
         * @return type array
         */
        public function signature($query, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret) {
            $oauth = array(
                'oauth_consumer_key' => $consumer_key,
                'oauth_nonce' => hash_hmac('sha1', time(), true),
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_token' => $oauth_access_token,
                'oauth_timestamp' => time(),
                'oauth_version' => '1.0'
            );
            $api_url = 'https://api.twitter.com/1.1/users/show.json';
            $base_info = $this->signature_base_string($api_url, $query, 'GET', $oauth);
            $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
            $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
            $oauth['oauth_signature'] = $oauth_signature;

            return $oauth;
        }

        /**
         * Build the header.
         *
         * @param  array $signature OAuth signature.
         *
         * @return string           OAuth Authorization.
         */
        public function header($signature) {
            $return = 'OAuth ';
            $values = array();

            foreach ($signature as $key => $value) {
                $values[] = $key . '="' . rawurlencode($value) . '"';
            }

            $return .= implode(', ', $values);

            return $return;
        }

        /**
         * Returns twitter count
         */
        public function get_twitter_follower() {
            $rit_sc_settings = $this->rit_sc_settings;
            $user = $rit_sc_settings['twitter']['username'];
            $api_url = 'https://api.twitter.com/1.1/users/show.json';
            $params = array(
                'method' => 'GET',
                'sslverify' => false,
                'timeout' => 60,
                'headers' => array(
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => $this->authorization(
                            $user, $rit_sc_settings['twitter']['consumer_key'], $rit_sc_settings['twitter']['consumer_secret'], $rit_sc_settings['twitter']['access_token'], $rit_sc_settings['twitter']['access_token_secret']
                    )
                )
            );

            $connection = wp_remote_get($api_url . '?screen_name=' . $user, $params);

            if (is_wp_error($connection)) {
                $count = 0;
            } else {
                $_data = json_decode($connection['body'], true);
                if (isset($_data['followers_count'])) {
                    $count = intval($_data['followers_count']);

                } else {
                    $count = 0;
                }
            }
            return $count;
        }
        
        /**
         * 
         * @param int $count
         * @param string $format
         */
        public function get_formatted_count($count, $format) {
            if($count==''){
                return 0;
            }
            switch ($format) {
                case 'comma':
                    $count = number_format($count);
                    break;
                case 'short':
                    $count = $this->abreviateTotalCount($count);
                    break;
                default:
                    break;
            }
            return $count;
        }
         
         /**
         * 
         * @param integer $value
         * @return string
         */
        public function abreviateTotalCount($value) {

            $abbreviations = array(12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => '');

            foreach ($abbreviations as $exponent => $abbreviation) {

                if ($value >= pow(10, $exponent)) {

                    return round(floatval($value / pow(10, $exponent)), 1) . $abbreviation;
                }
            }
        }
        
        public function facebook_count($url){
 
            // Query in FQL
            $fql  = "SELECT like_count ";
            $fql .= " FROM link_stat WHERE url = '$url'";
         
            $fqlURL = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);
         
            // Facebook Response is in JSON
            $response = json_decode(file_get_contents(trim($fqlURL)));
            if(is_array($response) && isset($response[0]->like_count)){
                return $response[0]->like_count;    
            }else{
                return 0;
            }
        }
        
        public function get_count($social_media){
            $count = 0;

            $rit_sc_settings = $this->rit_sc_settings;
        
            $cache_time =  get_option('rit_sc_cache_time', 0);

            $cache_time = (intval($cache_time) > 0 ) ? $cache_time : 0;

            if($cache_time == 0){
                $transient_array = array('rit_sc_facebook', 'rit_sc_twitter', 'rit_sc_youtube', 'rit_sc_instagram', 'rit_sc_googlePlus', 'rit_sc_soundcloud', 'rit_sc_dribbble', 'rit_sc_posts', 'rit_sc_comments');
                foreach ($transient_array as $transient) {
                    delete_transient($transient);
                }
            }

            switch($social_media){
                case 'facebook':
                    $facebook_page_id = $rit_sc_settings['facebook']['page_id'];
                    $facebook_count = get_transient('rit_sc_facebook');
                    if (false === $facebook_count) {

                        $api_url = 'https://www.facebook.com/' . $facebook_page_id;
                        
                            $count = $this->facebook_count($api_url);
                            set_transient('rit_sc_facebook', $count, $cache_time);
                        
                    } else {
                        $count = $facebook_count;
                    }
                    
                    $default_count = isset($rit_sc_settings['facebook']['default_count'])?$rit_sc_settings['facebook']['default_count']:0;
                    $count = ($count==0)?$default_count:$count;
                    if($count!=0){
                        set_transient('rit_sc_facebook',$count,$cache_time);
                    }
                    break;
                case 'twitter':
                        
                    $twitter_count = get_transient('rit_sc_twitter');
                    if (false === $twitter_count) {
                        $count = ($this->get_twitter_follower());
                        set_transient('rit_sc_twitter', $count, $cache_time);
                    } else {
                        $count = $twitter_count;
                    }
                    
                    
                    break;
                case 'googlePlus':
                    $social_profile_url = 'https://plus.google.com/' . $rit_sc_settings['googlePlus']['page_id'];
                    
                    $googlePlus_count = get_transient('rit_sc_googlePlus');
                    if (false === $googlePlus_count) {
                        $api_url = 'https://www.googleapis.com/plus/v1/people/' . $rit_sc_settings['googlePlus']['page_id'] . '?key=' . $rit_sc_settings['googlePlus']['api_key'];
                        $params = array(
                            'sslverify' => false,
                            'timeout' => 60
                        );
                        $connection = wp_remote_get($api_url, $params);
                        
                        if (is_wp_error($connection)) {
                            $count = 0;
                        } else {
                            $_data = json_decode($connection['body'], true);

                            if (isset($_data['circledByCount'])) {
                                $count = (intval($_data['circledByCount']));
                                set_transient('rit_sc_googlePlus', $count,$cache_time);
                            } else {
                                $count = 0;
                            }
                        }
                    } else {
                        $count = $googlePlus_count;
                    }
                    
                    break;
                case 'instagram':
                    $username = $rit_sc_settings['instagram']['username'];
                    $user_id = $rit_sc_settings['instagram']['user_id'];
                    $social_profile_url = 'https://instagram.com/' . $username;
                    
                    $instagram_count = get_transient('rit_sc_instagram');
                    if (false === $instagram_count) {
                        $access_token = $rit_sc_settings['instagram']['access_token'];

                        $api_url = 'https://api.instagram.com/v1/users/' . $user_id . '?access_token=' . $access_token;
                        $params = array(
                            'sslverify' => false,
                            'timeout' => 60
                        );
                        $connection = wp_remote_get($api_url, $params);
                        if (is_wp_error($connection)) {
                            $count = 0;
                        } else {
                            $response = json_decode($connection['body'], true);
                            if (
                                    isset($response['meta']['code']) && 200 == $response['meta']['code'] && isset($response['data']['counts']['followed_by'])
                            ) {
                                $count = (intval($response['data']['counts']['followed_by']));
                                set_transient('rit_sc_instagram',$count,$cache_time);
                            } else {
                                $count = 0;
                            }
                        }
                    } else {
                        $count = $instagram_count;
                    }
                    
                    break;
                case 'youtube':
                    $social_profile_url = esc_url($rit_sc_settings['youtube']['channel_url']);
                    $count = get_transient('rit_sc_youtube');
                   
                    if(false === $count){
                    $count = $rit_sc_settings['youtube']['subscribers_count'];
                    if(
                        isset($rit_sc_settings['youtube']['channel_id'],$rit_sc_settings['youtube']['api_key']) && 
                        $rit_sc_settings['youtube']['channel_id']!='' && $rit_sc_settings['youtube']['api_key']
                       )
                     {
                        
                          $api_key = $rit_sc_settings['youtube']['api_key'];
                          $channel_id = $rit_sc_settings['youtube']['channel_id'];
                          $api_url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_id.'&key='.$api_key;
                          $connection = wp_remote_get($api_url, array('timeout'=>60));
                          
                          if (!is_wp_error($connection)) {
                                $response = json_decode($connection['body'], true);
                                if (isset($response['items'][0]['statistics']['subscriberCount'])) {
                                    $count = $response['items'][0]['statistics']['subscriberCount'];
                                    set_transient('rit_sc_youtube',$count,$cache_time);
                                    } 
                                }
                        } 
                    }
                    break;
                case 'soundcloud':
                    $username = $rit_sc_settings['soundcloud']['username'];
                    $social_profile_url = 'https://soundcloud.com/' . $username;
                    
                    $soundcloud_count = get_transient('rit_sc_soundcloud');
                    if (false === $soundcloud_count) {
                        $api_url = 'https://api.soundcloud.com/users/' . $username . '.json?client_id=' . $rit_sc_settings['soundcloud']['client_id'];
                        $params = array(
                            'sslverify' => false,
                            'timeout' => 60
                        );

                        $connection = wp_remote_get($api_url, $params);
                        if (is_wp_error($connection)) {
                            $count = 0;
                        } else {
                            $response = json_decode($connection['body'], true);

                            if (isset($response['followers_count'])) {
                                $count = (intval($response['followers_count']));
                                set_transient( 'rit_sc_soundcloud',$count,$cache_time );
                            } else {
                                $count = 0;
                            }
                        }
                    } else {
                        $count = $soundcloud_count;
                    }
                    
                    break;
                case 'dribbble':
                    $social_profile_url = 'http://dribbble.com/'.$rit_sc_settings['dribbble']['username'];
                    
                    $dribbble_count = get_transient('rit_sc_dribbble');
                    if (false === $dribbble_count) {
                        $username = $rit_sc_settings['dribbble']['username'];
                         $api_url = 'http://api.dribbble.com/' . $username;
                        $params = array(
                            'sslverify' => false,
                            'timeout' => 60
                        );
                        $connection = wp_remote_get($api_url, $params);
                        if (is_wp_error($connection)) {
                            $count = 0;
                        } else {
                            $response = json_decode($connection['body'], true);
                            if (isset($response['followers_count'])) {
                                $count = (intval($response['followers_count']));
                                set_transient('rit_sc_dribbble',$count,$cache_time );
                            } else {
                                $count = 0;
                            }
                        }
                    } else {
                        $count = $dribbble_count;
                    }
                    
                    break;
                case 'posts':
                    
                    $posts_count = get_transient('rit_sc_posts');
                    if (false === $posts_count) {
                        $posts_count = wp_count_posts();
                        $count = $posts_count->publish;
                        set_transient('rit_sc_posts', $count, $cache_time);
                    } else {
                        $count = $posts_count;
                    }
                    
                    break;
                case 'comments':
                    
                    $comments_count = get_transient('rit_sc_comments');
                    if (false === $comments_count) {
                        $data = wp_count_comments();
                        $count = ($data->approved);
                        set_transient('rit_sc_comments', $count, $cache_time);
                    } else {
                        $count = $comments_count;
                    }
                    
                    break;
                default:
                    break;
            }
            return $count;
        }
    }

    $rit_social_counter = RIT_SOCIAL_COUNTER::getInstance();
}