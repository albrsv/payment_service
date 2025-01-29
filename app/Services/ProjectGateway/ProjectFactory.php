<?php

declare(strict_types=1);

namespace App\Services\ProjectGateway;

use App\enums\Project;

class ProjectFactory implements ProjectFactoryInterface
{
    private array $projects = [];

    public function __construct()
    {
        // Register projects with their corresponding IDs
        foreach (Project::cases() as $project) {
            $this->projects[$project->name] = $project->getProjectServiceClass();
        }
    }

    public function getProjectById(string $projectId): ProjectInterface
    {
        if (!isset($this->projects[$projectId])) {
            throw new \InvalidArgumentException("Project with ID '{$projectId}' not found.");
        }

        $projectServiceClass = $this->projects[$projectId];

        return new $projectServiceClass();
    }
}
