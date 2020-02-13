<?php

namespace src\Model\EnumType;

class EnumOrderType extends EnumType
{

    const STATE_NEW = 'new';
    const STATE_PENDING = 'pending';
    const STATE_FINISH = 'finish';
    const STATE_CANCELED = 'canceled';
    const STATE_REJECTED = 'rejected';

    /** @var array */
    const CAN_CONTINUE_STATES = [self::STATE_NEW];

    protected $name = 'enumordertype';

    protected $values = [
        self::STATE_NEW,
        self::STATE_PENDING,
        self::STATE_FINISH,
        self::STATE_CANCELED,
        self::STATE_REJECTED,
    ];
}