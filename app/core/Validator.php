<?php

namespace Core;

use Core\Database;

/**
 * Class Validator
 *
 * A class to handle validation of data
 *
 * @package Core
 */
class Validator
{
  /**
   * @var Database
   */
  protected $db;

  /**
   * @var array
   */
  protected $errors = [];

  /**
   * @var array
   */
  protected $messages = [
    'required' => 'The :fieldname: field is required',
    'min' => 'The :fieldname: field must be a minimum of :rulevalue: characters',
    'max' => 'The :fieldname: field must be a maximum of :rulevalue: characters',
    'email' => 'Not valid email',
    'unique' => 'The :fieldname: is already taken',
  ];

  /**
   * Validator constructor.
   */
  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  /**
   * Validate the given data against given rules
   *
   * @param array $data
   * @param array $rules
   * @return $this
   */
  public function validate($data = [], $rules = [])
  {
    foreach ($data as $fieldname => $value) {
      if (isset($rules[$fieldname])) {
        $this->check([
          'fieldname' => $fieldname,
          'value' => $value,
          'rules' => $rules[$fieldname],
        ]);
      }
    }
    return $this;
  }

  /**
   * Check a field against its rules
   *
   * @param array $field
   */
  protected function check($field)
  {
    foreach ($field['rules'] as $rule => $rule_value) {
      if (method_exists($this, $rule)) {
        if (!call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
          $this->addError(
            $field['fieldname'],
            str_replace(
              [':fieldname:', ':rulevalue:'],
              [$field['fieldname'], $rule_value],
              $this->messages[$rule] ?? 'Validation error on :fieldname:'
            )
          );
        }
      }
    }
  }

  /**
   * Add an error to the list of errors
   *
   * @param string $fieldname
   * @param string $error
   */
  protected function addError($fieldname, $error)
  {
    $this->errors[$fieldname][] = $error;
  }

  /**
   * Get the list of errors
   *
   * @return array
   */
  public function getErrors()
  {
    return $this->errors;
  }

  /**
   * Check if there are any errors
   *
   * @return bool
   */
  public function hasErrors()
  {
    return !empty($this->errors);
  }

  /**
   * List the errors for a specific field
   *
   * @param string $fieldname
   * @return string
   */
  public function listErrors($fieldname)
  {
    $output = '';
    if (isset($this->errors[$fieldname])) {
      $output .= "<div class='validation-errors'><ul class='list-errors'>";
      foreach ($this->errors[$fieldname] as $error) {
        $output .= "<li>$error</li>";
      }
      $output .= "</ul></div>";
    }
    return $output;
  }

  /**
   * Check if a value is required
   *
   * @param mixed $value
   * @param mixed $rule_value
   * @return bool
   */
  protected function required($value, $rule_value)
  {
    return !empty(trim($value));
  }

  /**
   * Check if a value is at least a certain length
   *
   * @param mixed $value
   * @param int $rule_value
   * @return bool
   */
  protected function min($value, $rule_value)
  {
    return mb_strlen($value, 'UTF-8') >= $rule_value;
  }

  /**
   * Check if a value is at most a certain length
   *
   * @param mixed $value
   * @param int $rule_value
   * @return bool
   */
  protected function max($value, $rule_value)
  {
    return mb_strlen($value, 'UTF-8') <= $rule_value;
  }

  /**
   * Check if a value is a valid email
   *
   * @param mixed $value
   * @param mixed $rule_value
   * @return bool
   */
  protected function email($value, $rule_value)
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  /**
   * Check if a value is unique in a database
   *
   * @param mixed $value
   * @param string $rule_value
   * @return bool
   */
  protected function unique($value, $rule_value)
  {
    $data = explode(':', $rule_value);
    $stmt = $this->db->query("SELECT {$data[1]} FROM {$data[0]} WHERE {$data[1]} = ?", [$value]);
    return !$stmt->fetchColumn();
  }
}
