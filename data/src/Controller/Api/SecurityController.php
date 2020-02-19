<?php

namespace src\Controller\Api;

use Delight\Auth\AuthError;
use src\Authorization\Request;
use src\Controller\BaseController;
use src\Service\SecurityService;

class SecurityController extends BaseController
{

    /**
     * @param Request $request
     *
     * @return \src\Authorization\Response
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $userData = $request->getJsonData();

        try {
            SecurityService::getInstance()->getAuth()->login($userData['email'], $userData['password']);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->json(['id' => SecurityService::getInstance()->getAuth()->id()]);
    }

    /**
     * @return \src\Authorization\Response
     *
     * @throws AuthError
     */
    public function logout()
    {
        SecurityService::getInstance()->getAuth()->logOut();

        return $this->json([])->setStatusCode(204);
    }

    /**
     * @param Request $request
     *
     * @return \src\Authorization\Response
     * @throws \Exception
     */
    public function register(Request $request)
    {
        $userData = $request->getJsonData();

        try {
            $userId = SecurityService::getInstance()->getAuth()->register(
                $userData['email'],
                $userData['password'],
                $userData['username']
            );

            /** TODO send verification mail */
//            function ($selector, $token) use ($userData) {
//                MailService::getInstance()->sendMail('Registration', "Selector: $selector\n\r Token: $token", $userData['email']);
//            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->json(['id' => $userId]);
    }
}