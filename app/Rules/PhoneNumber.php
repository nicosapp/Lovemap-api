<?php

namespace App\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
  /**
   * Create a new rule instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value)
  {
    try {
      if (substr($value, 0, 1) != '+') return false;
      if (strlen($value) < 9 || strlen($value) > 14) return false;
      if (!is_numeric(substr($value, 1))) return false;
    } catch (Exception $e) {
      return false;
    }

    return true;
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {
    return 'Phone number is invalid';
  }
}
