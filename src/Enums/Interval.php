<?php

namespace HoceineEl\LaravelModularSubscriptions\Enums;

enum Interval: string
{
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
    case YEAR = 'year';
}
