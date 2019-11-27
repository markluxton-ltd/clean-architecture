<?php
/**
 * The response from the Create User feature.  There's not much here, simply a
 * field to that holds a message to display to the user.
 *
 * @see \core\classes\Response for more information
 */
namespace core\interactors\userManagement\createUser;


use core\classes\Response;

class CreateUserResponse extends Response
{
    
    /**
     * @var bool
     */
    private $message = '';
    
    
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    
    
    public function getMessage(): string
    {
        return $this->message;
    }
}