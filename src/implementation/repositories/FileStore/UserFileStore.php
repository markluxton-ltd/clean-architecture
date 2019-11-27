<?php
/**
 * This is an example of a repository. It will be one of many.  This one deals with storing the
 * user details in a json file.
 *
 * @see /core/interfaces/repositories/UserRepositoryInterface
 */

namespace implementation\repositories\FileStore;

use core\entities\UserEntity;
use core\exceptions\repositories\RepositoryAlreadyExists;
use core\exceptions\repositories\RepositoryNotFound;
use core\interfaces\repositories\UserRepositoryInterface;

class UserFileStore extends FileStore implements UserRepositoryInterface
{
    
    private const FILE_STORE = __DIR__ . '/users.json';
    /**
     * @var UserEntity[]
     */
    protected $users;
    
    
    public function __construct()
    {
        $this->users = $this->load(self::FILE_STORE);
    }
    
    
    public function createUser(UserEntity $userEntity): void
    {
        if ($this->doesUserExist($userEntity->getEmail())) {
            throw new RepositoryAlreadyExists('User already exists with the email "' . $userEntity->getEmail() . '"');
        }
        
        $this->users[ $userEntity->getEmail() ] = $userEntity;
        $this->save($this->createArray(), self::FILE_STORE);
    }
    
    
    public function doesUserExist(string $email): bool
    {
        return isset($this->users[ $email ]);
    }
    
    
    public function saveUser(UserEntity $userEntity): void
    {
        if (!$this->doesUserExist($userEntity->getEmail())) {
            throw new RepositoryNotFound('No user found with the email "' . $userEntity->getEmail() . '"');
        }
        
        $this->users[ $userEntity->getEmail() ] = $userEntity;
        $this->save($this->createArray(), self::FILE_STORE);
    }
    
    
    public function save(array $data, string $filePath): void
    {
        parent::save($this->createArray(), $filePath);
    }
    
    
    public function load(string $filePath): array
    {
        $users = [];
        
        foreach(parent::load($filePath) as $row)
        {
            $user = new UserEntity();
            $user->setFirstName($row['firstName']);
            $user->setLastName($row['lastName']);
            $user->setEmail($row['email']);
            
            $users[] = $user;
        }
        
        return $users;
    }
    
    
    private function createArray(): array
    {
        $data = [];
        
        foreach ($this->users as $user) {
            $data[] = [
              'firstName' => $user->getFirstName(),
              'lastName' => $user->getLastName(),
              'email' => $user->getEmail(),
            ];
            
        }
        
        return $data;
    }
    
    
    public function getUser(string $email): UserEntity
    {
        
        if (!$this->doesUserExist($email)) {
            throw new RepositoryNotFound('No user found with the email "' . $email . '"');
        }
        
        return $this->users[ $email ];
    }
    
    
    /**
     * @return UserEntity[]
     */
    public function listUsers(): array
    {
        return $this->users;
    }
}