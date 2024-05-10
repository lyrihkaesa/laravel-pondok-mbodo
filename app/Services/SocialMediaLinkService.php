<?php

namespace App\Services;

use App\Models\User;

interface SocialMediaLinkService
{
    public function insertUpdateDeleteMany(array $socialMediaLinks, User $user): array;
}
