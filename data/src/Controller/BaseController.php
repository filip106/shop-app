<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 26-Sep-19
 * Time: 10:56 PM
 */

namespace src\Controller;

use src\Authorization\Response;

class BaseController
{
    /**
     * @param string $filePath
     * @param array $parameters
     * @param Response|null $response
     *
     * @return Response
     */
    public function render(string $filePath, $parameters = [], Response $response = null) : Response
    {
        $filePath = sprintf('%s/pages/%s', PROJECT_SRC_DIR, $filePath);
        if (!file_exists($filePath)) {
            throw new \RuntimeException('Error, requested file is missing');
        }

        $content = include $filePath;

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
        return $this->render('404.php');
    }
}