<?php /*
    Plugin Name: URL Find and Replace
    Plugin URI: http://webpresencepartners.com/
    Description: Find a string in the current URL, replace it, and redirect to the new URL
    Version: 1
    Author: Daniel Grundel, Web Presence Partners
    Author URI: http://www.webpresencepartners.com
*/

    class WebPres_URL_Find_and_Replace {
        
        public function __construct() {
            add_action('init', array(&$this , 'maybe_redirect'));
            add_filter('admin_init', array(&$this , 'register_fields'));
        }
        
        public function maybe_redirect() {
            
            //don't do anything inside the admin panel.
            if(is_admin()) return;
            
            $old = get_option('url_find_and_replace__find', '');
            $new = get_option('url_find_and_replace__replace', '');
            
            if( strlen($old) > 0 && strlen($new) > 0 && $old != $new ) {
                
                $old = strtolower($old);
                $new = strtolower($new);
                $current_url = strtolower(self::current_url());
                
                if(stristr($current_url, $old) !== false) {
                    $redirect_url = str_replace($old, $new, $current_url);
                    
                    header('HTTP/1.1 301 Moved Permanently');
                    header("Location: {$redirect_url}");
                    exit();
                }
            }
            
            
        }
        
        public function current_url() {
            $url = 'http';
            if ($_SERVER["HTTPS"] == "on") {$url .= "s";}
            $url .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            } else {
                $url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }
            return $url;
        }
        
        function register_fields() {
            
            add_settings_section('url_find_and_replace', 'URL Find and Replace', array(&$this, 'section_description_html'), 'permalink');
            
            register_setting('general', 'url_find_and_replace__find', array(&$this, 'sanitize_field'));
            register_setting('general', 'url_find_and_replace__replace', array(&$this, 'sanitize_field'));
            
            add_settings_field('url_find_and_replace__find', '<label for="url_find_and_replace__find">'.__('Find String' , 'url_find_and_replace__find' ).'</label>' , array(&$this, 'find_field_html') , 'permalink', 'url_find_and_replace');
            add_settings_field('url_find_and_replace__replace', '<label for="url_find_and_replace__replace">'.__('Replace With' , 'url_find_and_replace__replace' ).'</label>' , array(&$this, 'replace_field_html') , 'permalink', 'url_find_and_replace');
        }
        
        function section_description_html() {
            ?><p>Options for the URL Find and Replace plugin. <strong>Use with caution</strong>.</p><?php
        }
        
        function find_field_html() {
            $field_value = get_option('url_find_and_replace__find', '');
            ?><input type="text" id="url_find_and_replace__find" name="url_find_and_replace__find" value="<?php echo $field_value; ?>" class="regular-text code"><?php
        }
        
        function replace_field_html() {
            $field_value = get_option('url_find_and_replace__replace', '');
            ?><input type="text" id="url_find_and_replace__replace" name="url_find_and_replace__replace" value="<?php echo $field_value; ?>" class="regular-text code"><?php
        }
        
        function sanitize_field($field_value) {
            return trim($field_value);
        }
    }
    
    $webpres_url_find_and_replace = new WebPres_URL_Find_and_Replace();
?>