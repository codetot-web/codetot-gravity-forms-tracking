<?php

/**
 * @package    Codetot_Base
 * @subpackage Codetot_Blocks_Templates
 * @author     CODE TOT JS <dev@codetot.com>
 */
class Codetot_Gravity_Forms_Tracking_Cookies
{
  /**
   * Singleton instance
   *
   * @var Codetot_Gravity_Forms_Tracking_Cookies
   */
  private static $instance;

  private static $allowed_keys = [
    'utm_source',
    'utm_size',
    'utm_campaign'
  ];

  private static $cookie_name = 'STYXKEY_ct_gf_tracking';

  /**
   * Get singleton instance.
   *
   * @return Codetot_Gravity_Forms_Tracking_Cookies
   */
  public final static function instance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function __construct()
  {
    add_action('init', array($this, 'check_and_set_cookies'));
  }

  /**
   * Check if $_GET matches allowed keys
   *
   * @param string $key
   * @return boolean
   */
  public function is_allowed_key($key)
  {
    return in_array($key, $this::$allowed_keys);
  }

  /**
   * Set cookie with default 1 day
   *
   * @param string $value
   * @param string $time
   * @return void
   */
  public function set_cookie($values, $time = '')
  {
    $_default_time = time() + (86400 * 30);
    $_time = !empty($time) ? $time : $_default_time; // Default is 1 day

    if (empty($this->read_cookies()) && !empty($values)) {
      setcookie($this::$cookie_name, json_encode($values), apply_filters('ct_gf_cookie_time', $_time), COOKIEPATH, COOKIE_DOMAIN);
    }
  }

  public function get_formatted_cookies() {
    $data = $_COOKIE[$this::$cookie_name];
    // Example data below
    // $data = '%7B%22utm_source%22%3A%22meomeo%22%2C%22utm_size%22%3A%22medium%22%2C%22utm_campaign%22%3A%22meow%22%7D';
    $decoded_data_array = json_decode(stripslashes($data), true);

    return is_array($decoded_data_array) ? $decoded_data_array : [];
  }

  public function is_cookies_validated() {
    if (empty($_COOKIE[$this::$cookie_name])) {
      return false;
    }

    // Try to read cookies and ensure it must be array
    $cookie_value_decoded = $this->get_formatted_cookies();

    return !empty($cookie_value_decoded) && is_array($cookie_value_decoded);
  }

  public function read_cookie($key)
  {
    $cookies = $this->read_cookies();

    if ($this->is_cookies_validated() && !empty($cookies[$key])) {

      return $cookies[$key];
    }

    return null;
  }

  /**
   * Read cookie value
   *
   * @return array
   */
  public function read_cookies()
  {
    if ($this->is_cookies_validated()) {
      GFCommon::log_debug(__FUNCTION__ . ':: ' . implode(', ', $this->get_formatted_cookies()));

      return $this->get_formatted_cookies();
    } else {
      return [];
    }
  }

  /**
   * Check from current url and set cookies
   *
   * @return void
   */
  public function check_and_set_cookies()
  {
    $available_values = [];

    foreach ($this::$allowed_keys as $query_key) {
      if (!empty($_GET[$query_key])) {
        $available_values[$query_key] = esc_attr($_GET[$query_key]);
      }
    }

    return $this->set_cookie($available_values);
  }
}

Codetot_Gravity_Forms_Tracking_Cookies::instance();
