<?php

namespace App\Repositories\Profile;

use App\Interfaces\Profile\UserLocationRepository;
use App\Models\Profile\UserLocation;
use App\Services\IpApi\IpApiService;

class UserLocationEloquentRepository implements UserLocationRepository
{
    public function __construct(
        protected UserLocation $model
    ) {
    }

    public function create(int $userId, int $pageId)
    {
        $location = [
            'profile_user_id' => $userId,
            'profile_page_id' => $pageId,
            'ip_address' => session('user_remote_address'),
            'platform' => session('user_remote_platform'),
        ];
        $result = app(IpApiService::class)->iPGeolocation(session('user_remote_address'));

        if (isset($result['status']) && $result['status'] === 'success') {
            $location['country'] = $result['country'];
            $location['country_code'] = $result['countryCode'];
            $location['city'] = $result['city'];
            $location['zip_code'] = $result['zip'];
            $location['isp'] = $result['isp'];
        }

        $this->model->create($location);
    }
}
