<?php

class Codetot_Gravity_Forms_Tracking {
  private static $allowed_keys = [
    'utm_source',
    'utm_medium',
    'utm_campaign'
  ];

  public function __construct()
  {
    $this->cookies_class = Codetot_Gravity_Forms_Tracking_Cookies::instance();

    add_filter( 'gform_field_value_utm_source', array($this, 'set_value_utm_source') );
    add_filter( 'gform_field_value_utm_medium', array($this, 'set_value_utm_medium') );
    add_filter( 'gform_field_value_utm_campaign', array($this, 'set_value_utm_campaign') );

    add_filter( 'gform_entries_column_filter', array($this, 'entries_column_filter'), 10, 5 );
  }

  public function save_cookie_value_to_field_value($type, $default_value) {
    $cookie_name = $this->cookies_class::$cookie_name;
    $cookie_data = stripslashes($_COOKIE[$cookie_name]);
    $decoded_data_array = !empty($cookie_data) ? json_decode($cookie_data, true) : [];

    GFCommon::log_debug(__FUNCTION__ . ':: Cookie name - ' . $cookie_name . ', cookie data ' . $cookie_data);
    GFCommon::log_debug(__FUNCTION__ . ':: Save cookie value ' . sanitize_key($type) . ' - value: ' . sanitize_text_field($decoded_data_array[$type]));

    if (!empty($decoded_data_array) && !empty($decoded_data_array[$type])) {
      return sanitize_text_field($decoded_data_array[$type]);
    } else {
      return $default_value;
    }
  }

  public function set_value_utm_source($value) {
    return $this->save_cookie_value_to_field_value('utm_source', $value);
  }

  public function set_value_utm_medium($value) {
    return $this->save_cookie_value_to_field_value('utm_medium', $value);
  }

  public function set_value_utm_campaign($value) {
    return $this->save_cookie_value_to_field_value('utm_campaign', $value);
  }

  public function entries_column_filter($value, $form_id, $field_id, $entry, $query_string) {
    $form = RGFormsModel::get_form_meta($form_id);

    foreach ($form['fields'] as $field) {
      if (
        $field->type == 'hidden' &&
        in_array($field->inputName, $this::$allowed_keys) &&
        $field->id == $field_id &&
        !empty(rgar($entry, $field->id))
      ) {
        return rgar($entry, $field->id);
      }
    }

    return $value;
  }
}

return new Codetot_Gravity_Forms_Tracking();
