<?php


namespace src\Exception;


use Throwable;

class RedirectException extends \Exception
{
    /**
     * @var string
     */
    private $redirectRoute;

    /**
     * RedirectException constructor.
     *
     * @param $redirectRoute
     */
    public function __construct($redirectRoute)
    {
        parent::__construct('', 0, null);

        $this->redirectRoute = $redirectRoute;
    }

    /**
     * @param string $redirectRoute
     *
     * @return RedirectException
     */
    public function setRedirectRoute(string $redirectRoute): RedirectException
    {
        $this->redirectRoute = $redirectRoute;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectRoute(): string
    {
        return $this->redirectRoute;
    }
}