<?php

namespace App\Enums;

enum TargetType: string
{
  case NUMBER   = 'number';
  case BOOLEAN  = 'boolean';
  case CURRENCY = 'currency';
  case TASKS    = 'tasks';

  public function getLabelText(): string
  {
    return match ($this) {
      self::NUMBER => 'Number',
      self::BOOLEAN => 'True/False',
      self::CURRENCY => 'Currency',
      self::TASKS => 'Tasks',
    };
  }
}
