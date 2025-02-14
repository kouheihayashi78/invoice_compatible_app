<?php
namespace App\Enums;

enum Product: int
{
    case Product1 = 1;
    case Product2 = 2;
    case Product3 = 3;

    // public function label(): string
    // {
    //     return match ($this) {
    //         Role::ADMIN  => '管理者',
    //         Role::MEMBER => '一般',
    //     };
    // }
}
