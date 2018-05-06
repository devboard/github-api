<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\Git\Commit\CommitDate;
use DevboardLib\Git\Commit\CommitMessage;
use DevboardLib\Git\Commit\CommitSha;
use DevboardLib\GitHub\Commit\CommitParent;
use DevboardLib\GitHub\Commit\CommitParentCollection;
use DevboardLib\GitHub\Commit\CommitTree;
use DevboardLib\GitHub\Commit\CommitVerification;
use DevboardLib\GitHub\Commit\Verification\VerificationPayload;
use DevboardLib\GitHub\Commit\Verification\VerificationReason;
use DevboardLib\GitHub\Commit\Verification\VerificationSignature;
use DevboardLib\GitHub\Commit\Verification\VerificationVerified;
use DevboardLib\GitHub\GitHubCommit;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitAuthorFactory;
use DevboardLib\GitHubApi\V4\Object\Repository\Factory\Commit\CommitCommitterFactory;

/**
 * @see CommitFactorySpec
 * @see CommitFactoryTest
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CommitFactory
{
    /** @var CommitCommitterFactory */
    private $committerFactory;

    /** @var CommitAuthorFactory */
    private $authorFactory;

    public function __construct(CommitCommitterFactory $commitCommitterFactory, CommitAuthorFactory $authorFactory)
    {
        $this->committerFactory = $commitCommitterFactory;
        $this->authorFactory    = $authorFactory;
    }

    public function createFromBranchData(array $data): GitHubCommit
    {
        if (true === array_key_exists('verification', $data)) {
            $verification = $this->createVerification($data['verification']);
        } else {
            $verification = null;
        }

        return new GitHubCommit(
            new CommitSha($data['oid']),
            new CommitMessage($data['message']),
            new CommitDate($data['authoredDate']),
            $this->authorFactory->createFromBranchData($data['author']),
            $this->committerFactory->createFromBranchData($data['committer']),
            new CommitTree(new CommitSha($data['tree']['oid'])),
            $this->createParentCollection($data['parents']['edges']),
            $verification
        );
    }

    private function createVerification(array $data): CommitVerification
    {
        if (null !== $data['signature']) {
            $signature = new VerificationSignature($data['signature']);
        } else {
            $signature = null;
        }
        if (null !== $data['payload']) {
            $payload = new VerificationPayload($data['payload']);
        } else {
            $payload = null;
        }

        return new CommitVerification(
            new VerificationVerified($data['verified']),
            new VerificationReason($data['reason']),
            $signature,
            $payload
        );
    }

    private function createParentCollection(array $data): CommitParentCollection
    {
        $commitParentCollection = new CommitParentCollection();

        foreach ($data as $parentData) {
            $parent = new CommitParent(new CommitSha($parentData['node']['oid']));

            $commitParentCollection->add($parent);
        }

        return $commitParentCollection;
    }
}
