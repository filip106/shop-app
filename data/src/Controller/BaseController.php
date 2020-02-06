<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 26-Sep-19
 * Time: 10:56 PM
 */

namespace src\Controller;

use src\Authorization\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BaseController
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../pages');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => APP_DEBUG,
            'cache' => __DIR__ . '/../../cache',
        ]);
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
            $content = $this->twig->render(sprintf('%s.%s.%s', $templateName, 'html', 'twig'), $parameters);
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
}