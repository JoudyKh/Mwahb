<?php

namespace App\Services\General\Home;

use App\Constants\MawahbInfo;
use App\Services\General\Info\InfoService;
use App\Services\General\Teacher\TeacherService;

class HomeService
{
    public function __construct(protected InfoService $infoService, protected TeacherService $teacherService)
    {
    }
    public function getHome()
    {
        $data = $this->infoService->getAll();
        return MawahbInfo::home($data);
    }
}
