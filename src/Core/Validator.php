<?php
class Validator {
    private array $errors = [];

    public function required(string $field, ?string $value, string $message): void {
        if (is_null(value: $value) || trim(string: $value) === '') {
            $this->errors[$field][] = $message;
        }
    }

    public function minLen(string $field, ?string $value, int $min, string $message): void {
        if (!is_null($value) && mb_strlen(string: trim(string: $value)) < $min) {
            $this->errors[$field][] = $message;
        }
    }

    public function email(string $field, ?string $value, string $message): void {
        if (!filter_var(value: $value, filter: FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = $message;
        }
    }

    public function regex(string $field, ?string $value, string $pattern, string $message): void {
        if (!preg_match(pattern: $pattern, subject: (string)$value)) {
            $this->errors[$field][] = $message;
        }
    }

    public function errors(): array { return $this->errors; }
    public function ok(): bool { return empty($this->errors); }
}
