<?php

namespace App\Enums;

enum TaskPriority: string
{
  case LOW    = 'low';
  case MEDIUM = 'medium';
  case HIGH   = 'high';

  public function isLow(): bool
  {
    return $this === self::LOW;
  }

  public function isMedium(): bool
  {
    return $this === self::MEDIUM;
  }

  public function isHigh(): bool
  {
    return $this === self::HIGH;
  }

  public function getLabelText(): string
  {
    return match ($this) {
      self::LOW => 'Low',
      self::MEDIUM => 'Medium',
      self::HIGH => 'High',
    };
  }
}
