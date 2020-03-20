<?php

namespace src\Controller;

use src\Authorization\Response;
use src\Manager\CategoryManager;
use src\Manager\ImageManager;
use src\Manager\UserManager;
use src\Model\Category;
use src\Model\Image;
use src\Service\SecurityService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\TwigFunction;

class BaseController
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    /**
     * @var array
     */
    private $defaultParams = [];

    /**
     * @param array $defaultParams
     */
    public function setDefaultParams(array $defaultParams): void
    {
        $this->defaultParams = $defaultParams;
    }

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../pages');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => APP_DEBUG,
            'cache' => __DIR__ . '/../../cache',
        ]);

        if (APP_DEBUG) {
            $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        }

        $this->twig->addFunction(new TwigFunction('get_image_size', function ($name, $size) {
            if ($name instanceof Image) {
                $name = $name->getName();
            }

            $ia = explode('/', $name);
            $imageName = end($ia);

            return '/img/product/thumbnail/' . ImageManager::getInstance()->getThumbnailForImage($imageName, $size);
        }));

        $this->twig->addFunction(new TwigFunction('get_available_categories', function () {
            return CategoryManager::getInstance()->findAll();
        }));

        $this->twig->addFunction(new TwigFunction('get_logged_user', function () {
            $userId = SecurityService::getInstance()->getAuth()->getUserId();

            if (!$userId) {
                return null;
            }

            return UserManager::getInstance()->findOneById($userId);
        }));
    }

    /**
     * @param string $templateName
     * @param array $parameters
     * @param Response|null $response
     *
     * @return Response
     */
    public function render(string $templateName, $parameters = [], Response $response = null): Response
    {
        try {
            $content = $this->twig->render(sprintf('%s.%s.%s', $templateName, 'html', 'twig'), array_merge($this->defaultParams, $parameters));
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            throw new \RuntimeException(sprintf('Error while loading template! Error message: %s', $e->getMessage()));
        }

        if (null === $response) {
            $response = new Response();
        }
        $response->setContent($content);

        return $response;
    }

    /**
     * @param string $templateName
     * @param array $params
     *
     * @return string
     */
    public function renderBlock(string $templateName, array $params = [])
    {
        return $this->render($templateName, $params)->getContent();
    }

    /**
     * @return Response
     */
    public function notFound()
    {
        try {
            return $this->render('404');
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @param Response|null $response
     *
     * @return Response
     */
    public function json(array $data, Response $response = null)
    {
        header('Content-Type: application/json');

        if (null === $response) {
            $response = new Response();
        }
        $response->setContent(json_encode($data));

        return $response;
    }
}