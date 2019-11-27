<?php
/**
 * The response from the Create User feature.  There's not much here, simply a
 * field to that holds a message to display to the user.
 *
 * @see \core\classes\Response for more information
 */
namespace core\interactors\userManagement\listUsers;


use core\classes\Response;
use core\entities\UserEntity;

class ListUsersResponse extends Response
{
    
    /**
     * @var UserEntity[]
     */
    private $users = [];
    
    
    /**
     * @param UserEntity[] $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }
    
    
    /**
     * @return UserEntity[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}