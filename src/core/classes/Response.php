<?php
/**
 * If the `Request` object represents the user's input, the `Response` object represents the `Interactor`'s output.
 * It is simply a DTO (Data transfer Object) that contains any data that the `Interactor` produces.  Like the `Request`
 * object, you could do away with the object and use an associated array instead,  however, I feel using an object that
 * has setters and getters is a more explicit way to identify the possible outputs of the interactor.
 */

namespace core\classes;

class Response
{

}