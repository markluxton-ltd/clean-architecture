<?php
/**
 * The repository is the other side of the `Interactor`'s **what** needs to be done, it is
 * the **how** it is done.  Any class that implements the repository's interface will implement
 * the logic needed to store and retrieve the data.  It will take the data and translate it into
 * the relevant entities that the `Interactor` can work with.
 */

namespace core\interfaces\repositories;

use core\entities\UserEntity;

interface UserRepositoryInterface
{
    
    public function createUser(UserEntity $userEntity): void;
    
    
    public function saveUser(UserEntity $userEntity): void;
    
    
    public function doesUserExist(string $email): bool;
    
    
    public function getUser(string $email): UserEntity;
    
    
    /**
     * @return UserEntity[]
     */
    public function listUsers(): array;
}