<?php

namespace App\Enums;

enum PeriodForCalculatingInterest: string {
    case PCI360 = '360';
    case PCI364 = '364';
    case PCI365 = '365';
}
