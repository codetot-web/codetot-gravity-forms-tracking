<?php

class Codetot_Gravity_Forms_Tracking {
  private static $allowed_keys = [
    'utm_source',
    'utm_size',
    'utm_campaign'
  ];

  public function __construct()
  {
    $this->cookies_class = Codetot_Gravity_Forms_Tracking_Cookies::instance();

    add_filter( 'gform_field_value_utm_source', array($this, 'set_value_utm_source') );
    add_filter( 'gform_field_value_utm_size', array($this, 'set_value_utm_size') );
    add_filter( 'gform_field_value_utm_campaign', array($this, 'set_value_utm_campaign') );

    add_filter( 'gform_entries_column_filter', array($this, 'entries_column_filter'), 10, 5 );
  }

  public function save_cookie_value_to_field_value($type, $default_value) {
    $cookie_value = $this->cookies_class->read_cookie($type);

    // GFCommon::log_debug('Save cookie name ' . $type  .': ' . $cookie_value .' - default value is: ' . $default_value );

    if (!empty($cookie_value)) {
      return $cookie_value;
    } else {
      return $default_value;
    }
  }

  public function set_value_utm_source($value) {
    return $this->save_cookie_value_to_field_value('utm_source', $value);
  }

  public function set_value_utm_size($value) {
    return $this->save_cookie_value_to_field_value('utm_size', $value);
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
