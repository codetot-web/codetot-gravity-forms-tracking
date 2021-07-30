<?php

class Codetot_Gravity_Forms_Tracking {
  private static $allowed_keys = [
    'utm_source',
    'utm_size',
    'utm_campaign'
  ];

  public function __construct()
  {
    add_filter( 'gform_field_value_utm_source', array($this, 'set_value_utm_source') );
    add_filter( 'gform_field_value_utm_size', array($this, 'set_value_utm_size') );
    add_filter( 'gform_field_value_utm_campaign', array($this, 'set_value_utm_campaign') );

    add_filter( 'gform_entries_column_filter', array($this, 'entries_column_filter'), 10, 5 );
  }

  public function set_value_utm_source() {
    $cookie_value = Codetot_Gravity_Forms_Tracking_Cookies::instance()->read_cookie('utm_source');

    if (empty($_GET['utm_source']) && !empty($cookie_value)) {
      return $cookie_value;
    }
  }

  public function set_value_utm_size() {
    $cookie_value = Codetot_Gravity_Forms_Tracking_Cookies::instance()->read_cookie('utm_size');

    if (empty($_GET['utm_size']) && !empty($cookie_value)) {
      return $cookie_value;
    }
  }

  public function set_value_utm_campaign() {
    $cookie_value = Codetot_Gravity_Forms_Tracking_Cookies::instance()->read_cookie('utm_campaign');

    if (empty($_GET['utm_campaign']) && !empty($cookie_value)) {
      return $cookie_value;
    }
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
