<?php
class Validator {
    private array $errors = [];

    //verifica se o usuário não digitou nada ou digitou só espaços, tamnem remove espaços no inicios e no fim
    public function required(string $field, ?string $value, string $message): void {
        if (is_null(value: $value) || trim(string: $value) === '') {
            $this->errors[$field][] = $message;
        }
    }
    public function minLen(string $field, ?string $value, int $min, string $message): void {
        if (!is_null(value: $value) && mb_strlen(string: trim(string: $value)) < $min) {
            $this->errors[$field][] = $message;
        }
    }

    public function email(string $field, ?string $value, string $message): void {
        if (!filter_var(value: $value, filter: FILTER_VALIDATE_EMAIL)) { //valida se esta no formato correto
            $this->errors[$field][] = $message;
        }
    }
    //    public function minLenCPF(string $field, ?string $value, int $length, string $message): void {
    //     if (!is_null(value: $value) && mb_strlen(string: trim(string: $value)) !== $length) {
    //         $this->errors[$field][] = $message;
    //     }
    //     }

    public function minLenCPF(string $field, ?string $value, int $min, int $max,  string $message): void {
        if (!is_null(value: $value)) {
            $len = mb_strlen(trim($value));
                if ($len < $min || $len > $max) {
                $this->errors[$field][] = $message;
            }
        }
    }
    public function regex(string $field, ?string $value, string $pattern, string $message): void {
        if (!preg_match( $pattern, (string)$value)) { //verificada se telefone bate com a expressao regular (preg_match) 
            $this->errors[$field][] = $message;
        }
    }

    public function errors(): array { return $this->errors; }
    public function ok(): bool { return empty($this->errors); }
}