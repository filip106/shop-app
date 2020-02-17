<?php

namespace src\Manager;

use Imagick;
use src\Model\EnumType\EnumImageSizeType;
use src\Model\Image;

class ImageManager extends BasicManager
{
    /** @var string */
    CONST PRODUCT_IMAGE_DIR = __DIR__ . '/../../public/img/product/original';

    /** @var string */
    CONST PRODUCT_THUMBNAIL_DIR = __DIR__ . '/../../public/img/product/thumbnail';

    /** @var ImageManager */
    private static $instance;

    /**
     * @return ImageManager
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new ImageManager();
        }

        return self::$instance;
    }

    /**
     * @param Image $image
     */
    public function generateThumbnails(Image $image)
    {
        try {
            $imagick = new Imagick(sprintf('%s/%s', self::PRODUCT_IMAGE_DIR, $image->getName()));

            foreach (EnumImageSizeType::getImageSizes() as $prefix => $size) {
                $imagick->resizeImage($size, 0, Imagick::FILTER_LANCZOS, 1);

                if (!$imagick->writeImage(sprintf('%s/%s', self::PRODUCT_THUMBNAIL_DIR, $this->getThumbnailForImage($image->getName(), $prefix)))) {
                    // TODO error while saving image
                }
            }

        } catch (\ImagickException $e) {
            // TODO handle error
        }
    }

    /**
     * @param string $imageName
     * @param string $size
     *
     * @return string
     */
    public function getThumbnailForImage($imageName, $size)
    {
        $i = explode('.', $imageName);
        array_splice($i, count($i) - 1, 0, $size);

        return implode('.', $i);
    }
}