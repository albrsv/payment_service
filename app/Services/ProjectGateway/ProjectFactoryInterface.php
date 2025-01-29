<?php

declare(strict_types=1);

namespace App\Services\ProjectGateway;

interface ProjectFactoryInterface
{
    public function getProjectById(string $projectId): ProjectInterface;
}
