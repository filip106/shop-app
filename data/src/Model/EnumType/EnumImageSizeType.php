<?php

namespace src\Model\EnumType;

class EnumImageSizeType extends EnumType
{
    const IMAGE_SIZE_LARGE = 'lg';
    const IMAGE_SIZE_MEDIUM = 'md';
    const IMAGE_SIZE_SMALL = 'sm';
    const IMAGE_SIZE_EXTRA_SMALL = 'xs';

    protected $name = 'enumimagesizetype';

    protected $values = [
        self::IMAGE_SIZE_LARGE,
        self::IMAGE_SIZE_MEDIUM,
        self::IMAGE_SIZE_SMALL,
        self::IMAGE_SIZE_EXTRA_SMALL,
    ];

    /**
     * @return array
     */
    public static function getImageSizes()
    {
        return [
            self::IMAGE_SIZE_LARGE => '600',
            self::IMAGE_SIZE_MEDIUM => '320',
            self::IMAGE_SIZE_SMALL => '141',
            self::IMAGE_SIZE_EXTRA_SMALL => '85',
        ];
    }
}