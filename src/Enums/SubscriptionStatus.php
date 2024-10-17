<?php

namespace HoceineEl\LaravelModularSubscriptions\Enums;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';
    case PENDING = 'pending';
}
