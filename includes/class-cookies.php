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

  private static $cookie_name = 'ct_gf_tracking';

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
    add_action('after_setup_theme', array($this, 'check_and_set_cookies'));
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
  public function set_cookie($value, $time = '')
  {
    $_time = !empty($time) ? $time : time() + (86400 * 30); // Default is 1 day

    if (empty($this->read_cookies())) {
      setcookie($this::$cookie_name, $value, $_time, COOKIEPATH, COOKIE_DOMAIN);
    }
  }

  public function is_cookies_validated() {
    if (empty($_COOKIE[$this::$cookie_name])) {
      return false;
    }

    // Try to read cookies and ensure it must be array
    $cookie_value = stripslashes($_COOKIE[$this::$cookie_name]);
    $cookie_value_decoded = json_decode($cookie_value);

    return !empty($cookie_value_decoded) && is_array($cookie_value_decoded);
  }

  /**
   * Set cookies in array format
   *
   * @param array $values
   * @return void
   */
  public function set_cookies($values)
  {
    // In case cookie is empty or not validate, we override existing cookies
    if (is_array($values) && !$this->is_cookies_validated()) {
      $this->set_cookie(json_encode($values));

      return true;
    } else {
      return false;
    }
  }

  public function read_cookie($key)
  {
    $cookies = $this->read_cookies();

    if (!empty($cookies) && !empty($cookies[$key])) {
      return $cookies[$key];
    }

    return null;
  }

  /**
   * Read cookie value
   *
   * @return void
   */
  public function read_cookies()
  {
    return !empty($_COOKIE[$this::$cookie_name]) && $this->is_cookies_validated() ? json_decode(stripslashes($_COOKIE[$this::$cookie_name]), true) : '';
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

    return $this->set_cookies($available_values);
  }
}

Codetot_Gravity_Forms_Tracking_Cookies::instance();
