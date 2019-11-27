<?php
/*
 * This is the user input data expected for the CreateUser interactor.
 *
 * @see core\classes\Request.php for more details
 */

namespace core\interactors\userManagement\createUser;

/*
 * No references to outside the `core` namespace
 */

use core\classes\Request;

/*
 * Must extend the `Request` object as each interactor factory is typed hint to expect a
 * Request object.
 */

class CreateUserRequest extends Request
{
    
    /*
     * Added private constants to ensure that the same field is not
     * being accessed using different keys.
     */
    private const FIRST_NAME = 'First Name';
    private const LAST_NAME = 'Last Name';
    private const EMAIL = 'email';
    
    /*
     * This is used to identify what is required this interactor will
     * require. It is also used to provide a "central" way to validate
     * and sanitize the data prior to passing it to the interactor.
     *
     * This is to help ensure that the developer doesn't store unsanitized
     * data. At least the data will have basic validation and sanitization
     * applied.
     *
     * The schema has a number of options that can be applied to each field,
     * please see the `self::OPTION_*` constants for what is supported and
     * the `self::FILED_TYPE_*` for supported filed types.
     */
    protected $schema = [
      self::FIRST_NAME => [
        self::OPTION_TYPE => self::FIELD_TYPE_STRING,
      ],
      self::LAST_NAME => [
        self::OPTION_TYPE => self::FIELD_TYPE_STRING,
      ],
      self::EMAIL => [
        self::OPTION_TYPE => self::FIELD_TYPE_EMAIL,
      ],
    ];
    
    
    public function getFirstName(): string
    {
        /*
         * Getters return the data straight out of the internal `$data`
         * array. At this point, the data has already been verified and
         * sanitized.
         */
        return $this->data[ self::FIRST_NAME ];
    }
    
    
    public function setFirstName(string $firstName): void
    {
        /*
         * Setters update the internal data via a helper `updateModel`
         * method. It the `updateModel` method that will apply the
         * verification and sanitization of the data based on the `$schema`
         * array prior to adding it to the internal `$data` array.
         */
        $this->updateModel(self::FIRST_NAME, $firstName);
    }
    
    
    public function getLastName(): string
    {
        return $this->data[ self::LAST_NAME ];
    }
    
    
    public function setLastName(string $lastName): void
    {
        $this->updateModel(self::LAST_NAME, $lastName);
    }
    
    
    public function getEmail(): string
    {
        return $this->data[ self::EMAIL ];
    }
    
    
    public function setEmail(string $email): void
    {
        $this->updateModel(self::EMAIL, $email);
    }
    
    
}