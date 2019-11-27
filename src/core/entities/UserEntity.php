<?php
/**
 * The entities are the heart of clean architecture and contain any business rules and logic.
 * These are non-application specific - so basically any global or shareable logic that could
 * be reused in other applications should be encapsulated in an entity.
 */

namespace core\entities;

class UserEntity
{
    
    /**
     * @var string|null
     */
    private $firstName;
    
    
    /**
     * @var string|null
     */
    private $lastName;
    
    /**
     * @var string|null
     */
    private $email;
    
    /**
     * @var bool
     */
    private $isEnabled = false;
    
    
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    
    
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }
    
    
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    
    
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }
    
    
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
    
    
    /**
     * The forget method (along with the `enable` and `disable` methods) is a "business rule".  It could be used for the
     * right to be forgotten rule of GDPR.  We are also "hiding" the class' internal implementation.
     *
     * ```php
     *  $userRepository = (new UserRepositoryFactory)->create();
     *  $user = $userRepository->getUser('user@example.com');
     *  $user->forget();
     *  $userRepository->save($user);
     * ```
     */
    public function forget(): void
    {
       $this->firstName = '';
       $this->lastName = '';
       $this->email = '';
    }
    
    public function enable(): void
    {
        $this->isEnabled = true;
    }
    
    public function disable(): void
    {
        $this->isEnabled = false;
    }
}
