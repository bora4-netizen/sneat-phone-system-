<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class LowercaseWithUnderscore implements Rule
{
  public function passes($attribute, $value)
  {
      // Use a regular expression to check if the input contains only lowercase letters and underscores
      return preg_match('/^[a-z_0-9]+$/', $value);
  }

  public function message()
  {
      return 'The :attribute must contain only lowercase letters, underscores, and numbers.';
  }
}
