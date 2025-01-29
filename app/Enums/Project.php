<?php

declare(strict_types=1);

namespace App\Enums;

use App\Services\ProjectGateway\ProjectJsonService;
use App\Services\ProjectGateway\ProjectSoapService;

enum Project: string
{
    case ProjectJson = 'ProjectJson';
    case ProjectSoap = 'ProjectSoap';

    public function getUrl(): string
    {
        return match ($this) {
            self::ProjectJson => getenv('PROJECT_JSON_URL'),
            self::ProjectSoap => getenv('PROJECT_SOAP_URL'),
        };
    }

    public function getProjectServiceClass(): string
    {
        return match ($this) {
            self::ProjectJson => ProjectJsonService::class,
            self::ProjectSoap => ProjectSoapService::class,
        };
    }

    public static function random(): string
    {
        $projects = self::cases();

        return $projects[array_rand($projects)]->name;
    }
}
