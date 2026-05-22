<?php

namespace App\Enums;

enum TypeNum: int {
    case ROLLNO = 0;
    case PACKAGENO = 1;
    case BUNDLENO = 2;

    public function label(): string {
        return match($this) {
            self::ROLLNO => 'ROLL NO.',
            self::PACKAGENO => 'PACKAGE NO.',
            self::BUNDLENO => 'BUNDLE NO.',
        };
    }
}
