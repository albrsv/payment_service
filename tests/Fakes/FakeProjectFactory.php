<?php

declare(strict_types=1);

namespace Tests\Fakes;

use App\Services\ProjectGateway\ProjectFactoryInterface;
use App\Services\ProjectGateway\ProjectInterface;

class FakeProjectFactory implements ProjectFactoryInterface
{
    protected array $projects = [];

    public function __construct()
    {
        // Define which projects exist
        $this->projects['fake_project'] = new FakeProjectService();
    }

    public function getProjectById(string $projectId): ProjectInterface
    {
        return $this->projects[$projectId] ?? throw new \Exception('Project not found');
    }
}
