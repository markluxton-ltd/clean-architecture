<?php
/**
 * The request object represents the input data that has come from the user. It should be
 * unique to each interactor and should only include the expected inputs from the user for
 * that specific interactor.
 *
 * At the heart, it is simply a DTO or Data Transfer Object. I've enhanced the concept slightly
 * by adding initial validation of user data (why wait until the data hits the core application
 * to find out that the user has entered incorrect information). This could be stored as a simple
 * associated array, however, you would lose the ability to know what was stored in the array and
 * would have to go looking through the code to find out. I find using a object to be easier to
 * follow.
 *
 * As part of this implementation, the `Request` class has a `$schema` array that can be used
 * to detail the data that's stored.  The `$schema` is used to validate and sanitize the input
 * data before storing it in the internal `$data` array.  All data is added and accessed via
 * getters and setters.
 *
 * Data is only verified and validated when it is set via the setter method.  This means that
 * any field that is required but not set will not get validated.  One enhancement may be
 * to include a verify method to ensure that all data is valid.
 */


namespace core\classes;


class Request
{
    public const FIELD_TYPE_INT = 'int';
    public const FIELD_TYPE_FLOAT = 'float';
    public const FIELD_TYPE_EMAIL = 'email';
    public const FIELD_TYPE_STRING = 'string';
    public const FIELD_TYPE_BOOL = 'bool';
    public const FIELD_TYPE_URL = 'url';
    public const FIELD_TYPE_IP = 'ip';
    public const FIELD_TYPE_WHITELIST = 'whitelist';
    public const FIELD_TYPE_FILE_ENTITY = 'file entity';
    public const FIELD_TYPE_ARRAY = 'array';
    public const FIELD_TYPE_DATETIME = 'DateTime';
    public const FIELD_TYPE_EMAIL_FORMATTER = 'ReportDataFormatterInterface';
    
    private const DEFAULT_STRING_MIN_LENGTH = 0;
    private const DEFAULT_STRING_MAX_LENGTH = 255;
    private const DEFAULT_REQUIRED = true;
    private const DEFAULT_NULLABLE = false;
    
    public const OPTION_TYPE = 'type';
    public const OPTION_MIN = 'min';
    public const OPTION_MAX = 'max';
    public const OPTION_ALLOWED = 'allowed';
    public const OPTION_REQUIRED = 'required';
    public const OPTION_ALLOW_NULL = 'nullable';
    public const OPTION_DEFAULT = 'default';
    
    /**
     * @var array
     */
    protected $data = [];
    /**
     * @var array
     */
    protected $schema = [];
    
    
    public function __construct(array $data = null)
    {
        $this->processData($data);
    }
    
    
    protected function processData(array $data = null): void
    {
        foreach ($this->schema as $key => $value) {
            if (isset($data[ $key ])) {
                $this->updateModel($key, $data[ $key ]);
            } else {
                $this->data[ $key ] = $this->schema[ $key ][ $data[$key]['default'] ?? self::OPTION_DEFAULT ] ?? null;
            }
        }
    }
    
    
    protected function updateModel(string $field, $value): void
    {
        $this->validateData($field, $value);
        $this->data[ $field ] = $this->sanitizeData($field, $value);
    }
    
    
    private function validateData(string $field, $value): void
    {
        $this->checkForEmptyValue($field, $value);
        
        if (
        !((
            isset($this->schema[ $field ][ self::OPTION_ALLOW_NULL ])
            && $this->schema[ $field ][ self::OPTION_ALLOW_NULL ]
          )
          || self::DEFAULT_NULLABLE)
        ) {
            
            
            switch ($this->schema[ $field ][ self::OPTION_TYPE ]) {
                case self::FIELD_TYPE_INT:
                    
                    $this->verifyInt($field, $value);
                    break;
                
                case self::FIELD_TYPE_EMAIL:
                    
                    $this->verifyEmail($value);
                    break;
                
                case self::FIELD_TYPE_STRING:
                    
                    $this->verifyString($field, $value);
                    break;
                
                case self::FIELD_TYPE_WHITELIST:
                    
                    $this->verifyWhitelist($field, $value);
                    break;
                
                case self::FIELD_TYPE_BOOL:
                    $this->verifyBool($value);
                    break;
                
                case self::FIELD_TYPE_FILE_ENTITY:
                    
                    $this->verifyFileEntity($this->schema[ $field ], $value);
                    break;
                
                default:
                    break;
                
            }
        }
    }
    
    
    private function checkForEmptyValue(string $field, $value): void
    {
        $isRequired = $this->schema[ $field ][ self::OPTION_REQUIRED ] ?? self::DEFAULT_REQUIRED;
        
        if ($isRequired && ('' === $value || $value === null)) {
            throw new InvalidArgumentException($field . ' is required');
        }
    }
    
    
    private function verifyInt(string $field, $value): void
    {
        
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            throw new InvalidArgumentException($field . ' is not an integer.');
        }
        
        
        if (
          isset($this->schema[ $field ][ self::OPTION_MIN ])
          && $value
             < $this->schema[ $field ][ self::OPTION_MIN ]
        ) {
            throw new InvalidArgumentException($field
                                               . ' must be at least '
                                               . $this->schema[ $field ][ self::OPTION_MIN ]
                                               . '.');
        }
        
        
        if (
          isset($this->schema[ $field ][ self::OPTION_MAX ])
          && $value > $this->schema[ $field ][ self::OPTION_MAX ]
        ) {
            throw new InvalidArgumentException($field
                                               . ' must be no more than '
                                               . $this->schema[ $field ][ self::OPTION_MAX ]
                                               . '.');
        }
    }
    
    
    private function verifyEmail(string $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('"' . $value . '" is not a valid email address.');
        }
        
    }
    
    
    private function verifyString(string $field, $value): void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException($field . ' is not a valid string.');
        }
        
        $minLength = $this->schema[ $field ][ self::OPTION_MIN ] ?? self::DEFAULT_STRING_MIN_LENGTH;
        $maxLength = $this->schema[ $field ][ self::OPTION_MAX ] ?? self::DEFAULT_STRING_MAX_LENGTH;
        
        $valueLength = strlen($value);
        
        if ($valueLength < $minLength) {
            throw new InvalidArgumentException($field
                                               . ' is too short, must be at least '
                                               . $minLength
                                               . ' characters long');
        }
        
        if ($valueLength > $maxLength) {
            throw new InvalidArgumentException($field
                                               . ' is too long, must be no more than '
                                               . $maxLength
                                               . ' characters long');
        }
        
    }
    
    
    private function verifyWhitelist(string $field, $value): void
    {
        $not_strict = false;
        
        if (in_array($value, $this->schema[ $field ][ self::OPTION_ALLOWED ], $not_strict) === false) {
            throw new InvalidArgumentException('The value provided for ' . $field . ' is not allowed');
        }
    }
    
    
    private function verifyBool($value): void
    {
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) {
            throw new InvalidArgumentException('Value is not a boolean');
        }
    }
    
    
    private function verifyFileEntity(array $field, $value): void
    {
        if (!is_object($value) && !$value instanceof FileEntity) {
            throw new InvalidArgumentException('Invalid file');
        }
        
        $not_strict = false;
        
        if (isset($field[ 'allowed' ]) && in_array($value->getType(), $field[ 'allowed' ], $not_strict) === false) {
            throw new InvalidArgumentException(
              'Invalid file type, must be one of "'
              . implode(', ', $field[ 'allowed' ]));
        }
        
    }
    
    
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function sanitizeData(string $field, $value)
    {
        if (
          (
            isset($this->schema[ $field ][ self::OPTION_ALLOW_NULL ])
            && $this->schema[ $field ][ self::OPTION_ALLOW_NULL ]
          )
          || self::DEFAULT_NULLABLE
        ) {
            return $value;
        }
        
        switch ($this->schema[ $field ][ self::OPTION_TYPE ]) {
            case self::FIELD_TYPE_INT:
                
                $value = $this->sanitizeInt($value);
                break;
            
            case self::FIELD_TYPE_EMAIL:
                
                $value = $this->sanitizeEmail($value);
                break;
            
            case self::FIELD_TYPE_STRING:
                
                $value = $this->sanitizeString($value);
                break;
            
            case self::FIELD_TYPE_BOOL:
                $value = $this->sanitizeBool($value);
                break;
            
            default:
                break;
            
        }
        
        return $value;
    }
    
    
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function sanitizeInt($value): int
    {
        return (int)filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
    
    
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function sanitizeEmail(string $value): string
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }
    
    
    private function sanitizeString(string $value): string
    {
        $value = trim($value);
        
        return filter_var(
          $value,
          FILTER_SANITIZE_STRING,
          [
            FILTER_FLAG_STRIP_BACKTICK,
            FILTER_FLAG_STRIP_HIGH,
            FILTER_FLAG_STRIP_LOW,
          ]
        );
        
    }
    
    
    private function sanitizeBool($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
    
    private function verifyBoolean(bool $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN) === false) {
            throw new InvalidArgumentException('"' . $value . '" is not a valid boolean.');
        }
    }
}