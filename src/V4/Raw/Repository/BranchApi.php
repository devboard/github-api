<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Raw\Repository;

use DevboardLib\GitHub\Repo\RepoFullName;
use DevboardLib\GitHubApi\Credentials\InstallationCredentials;
use DevboardLib\GitHubApi\V3\GitHubClientFactory;

class BranchApi
{
    /** @var GitHubClientFactory */
    private $clientFactory;

    public function __construct(GitHubClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    public function allBranches(RepoFullName $fullName, InstallationCredentials $credentials, $cursor = null): array
    {
        $queryDefinition = file_get_contents(__DIR__.'/branches.graphql');

        $variables = [
            'owner'  => $fullName->getOwner()->asString(),
            'name'   => $fullName->getRepoName()->asString(),
            'cursor' => $cursor,
        ];
        $client = $this->clientFactory->createAppAndUserAuthenticatedClient($credentials);

        $edges = [];

        do {
            $data = $client->graphql()->execute($queryDefinition, $variables);

            if (false === $data['data']['repository']['refs']['pageInfo']['hasNextPage']) {
                break;
            }
            // Merge edges with previous ones
            $edges = array_merge($edges, $data['data']['repository']['refs']['edges']);

            $lastId = $data['data']['repository']['refs']['pageInfo']['endCursor'];

            $variables['cursor'] = $lastId;
        } while (true);

        //Merge previously gathered edges to last one
        $data['data']['repository']['refs']['edges'] = array_merge(
            $data['data']['repository']['refs']['edges'], $edges
        );

        return $data;
    }
}
