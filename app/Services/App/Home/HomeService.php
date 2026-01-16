<?php

namespace App\Services\App\Home;

use App\Constants\TamkeenInfo;
use App\Models\Info;
use App\Models\Offer;
use App\Models\Section;
use App\Models\TopStudent;
use App\Constants\Constants;
use App\Constants\EliteInfo;
use App\Constants\TheqaInfo;
use App\Constants\MawahbInfo;
use App\Constants\KhrejeenInfo;
use App\Http\Resources\OfferResource;
use App\Http\Resources\TopStudentResource;
use App\Services\General\Info\InfoService;
use App\Http\Resources\Section\CourseResource;
use App\Http\Resources\Section\SectionResource;
use App\Services\General\Teacher\TeacherService;

class HomeService
{
    public function __construct(
        protected TeacherService $teacherService,
        protected InfoService $infoService
    ) {
    }
    public function getMobileHome()
    {
        $data = $this->infoService->getAll();

        $infoMap = [
            'theqa' => TheqaInfo::class,
            'khrejeen' => KhrejeenInfo::class,
            'elite' => EliteInfo::class,
            'mawahb' => MawahbInfo::class,
            'tamkeen' => TamkeenInfo::class,
        ];

        $className = $infoMap[strtolower(config('app.name'))];

        return $className::mobileHome($data);
    }

}