<?php
/**
 * The Interactor, may also be refereed to as a use case, is the core of the application. It is the **what**
 * needs to be done but not the how. It's the 10,000 foot view.  Here you will say, for example, that the user
 * details need to be saved, but you will not specify **how** they are saved, so no references to databases!
 *
 * The Interactor will carry out the steps required (via the `execute()` method), it will create a `Response` object
 * setting any data that needs to be passed back to the user, and then finally, it will call the `send()` method on the
 * injected `Presenter` object which will then handle the how/what/why of displaying the data to the user.
 *
 * Just remember, the `Interactor` does not care about the **how**.  It does not care **how** the user data got into
 * the application nor does it care **how** the data is stored on disk. Those are implementation details. Ultimately,
 * the method of getting the user data and how it's stored on disk can change.  Generally, the rules that dictate
 * the **what** needs to be done will not change.
 *
 * For the `Interactor` to be of use, it needs to talk to other repositories.  This is achieved by creating
 * setters for each repository.  The repositories are then added via the `Interactor`'s factory.
 *
 * @see core/classes/Response.php
 * @see core/classes/Request.php
 * @see core/interfaces/boundaries/Presenter.php
 * @see core/interfaces/
 */

namespace core\interfaces\boundaries;


use core\classes\Request;

interface InteractorInterface
{
    
    /*
     * The `execute()` method is how the feature is started. It is generally initiated by the delivery layer
     * and is passed in the details provided by the user (the `Request` object) and where to return the data
     * after completion (via the `Presenter` object).
     *
     * I tend to keep this method more as a controller of the feature. It gives you the step-by-step process
     * needed to carry out the feature.
     */
    public function execute(): void;
}