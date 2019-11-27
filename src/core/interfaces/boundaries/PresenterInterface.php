<?php
/**
 * The job of the Presenter is to repackage the `Response` into a form usable by the user interface.
 * For example, the `Response` may have a Date object however, it is the `Presenter` that will
 * turn that Data object into a formatted string that the user interface can show.
 *
 * @see core/classes/Response.php
 */

namespace core\interfaces\boundaries;


use core\classes\Response;

interface PresenterInterface
{
    
    public function send(Response $response = null);
}