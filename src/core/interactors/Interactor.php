<?php
/**
 * A base class to be used by all Interactors.  Each interactor will need to have the
 * Request and Presenter set.  Crating the base class means the code isn't duplicated.
 *
 * Note that the InteractorInterface's execute method is **not** implemented here.  This
 * class is marked abstract so the responsibility of implementing the `execute()` method
 * will fall to the extending class.
 */

namespace core\interactors;

use core\classes\Request;
use core\classes\Response;
use core\interfaces\boundaries\InteractorInterface;
use core\interfaces\boundaries\PresenterInterface;

abstract class Interactor implements InteractorInterface
{
    
    /**
     * @var Response|null
     */
    protected $response;
    
    /**
     * @var PresenterInterface|null
     */
    private $presenter;
    
    /**
     * @var Request|null
     */
    protected $request;
    
    
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
    
    
    public function setPresenter(PresenterInterface $presenter): void
    {
       $this->presenter = $presenter;
    }
    
    protected function sendResponse(): void
    {
        $this->presenter->send($this->response);
    }
    
}