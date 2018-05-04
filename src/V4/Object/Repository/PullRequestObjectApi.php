<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository;

use DevboardLib\GitHub\GitHubPullRequest;
use DevboardLib\GitHub\Installation\InstallationId;
use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHub\User\UserId;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\PullRequestFactory;
use DevboardLib\GitHubApi\V4\Raw\Repository\PullRequestApi;

class PullRequestObjectApi
{
    /** @var PullRequestApi */
    private $pullRequestApi;

    /** @var PullRequestFactory */
    private $pullRequestFactory;

    public function __construct(PullRequestApi $pullRequestApi, PullRequestFactory $pullRequestFactory)
    {
        $this->pullRequestApi     = $pullRequestApi;
        $this->pullRequestFactory = $pullRequestFactory;
    }

    /** @return array|GitHubPullRequest[] */
    public function getPullRequests(RepoFullName $repoFullName, InstallationId $installationId, UserId $githubUserId): array
    {
        $dataLists = $this->pullRequestApi->getPullRequests($repoFullName, $installationId, $githubUserId);

        $results = [];

        foreach ($dataLists as $data) {
            foreach ($data['data']['repository']['pullRequests']['edges'] as $item) {
                $results[] = $this->pullRequestFactory->create($item['node']);
            }
        }

        return $results;
    }
}
