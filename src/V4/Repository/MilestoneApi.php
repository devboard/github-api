<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository;

use DevboardLib\GitHub\GitHubMilestone;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;
use DevboardLib\GitHubApi\V4\Repository\Factory\MilestoneFactory;

class MilestoneApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    /**
     * @var MilestoneFactory
     */
    private $milestoneFactory;

    public function __construct(GitHubClientFactory $clientFactory, MilestoneFactory $milestoneFactory)
    {
        $this->clientFactory    = $clientFactory;
        $this->milestoneFactory = $milestoneFactory;
    }

    /** @return array|GitHubMilestone[] */
    public function getMilestones(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $data = $this->getRawMilestones($repoFullName, $installationId, $githubUserId);

        $results = [];

        foreach ($data['data']['repository']['milestones']['edges'] as $item) {
            $results[] = $this->milestoneFactory->create($item['node']);
        }

        return $results;
    }

    public function getRawMilestones(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId)
    {
        $query = file_get_contents(__DIR__.'/milestones.graphql');

        $variables = [
            'owner' => $repoFullName->getOwner()->getValue(),
            'name'  => $repoFullName->getRepoName()->getValue(),
        ];
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($installationId, $githubUserId);

        $data = $client->graphql()->execute($query, $variables);

        return $data;
    }
}
