<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Repository\Factory;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHub\Label\LabelColor;
use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHub\Label\LabelName;

class LabelFactory
{
    public function create(array $data): GitHubLabel
    {
        return new GitHubLabel(
            new LabelId((int) $data['id']),
            new LabelName($data['name']),
            new LabelColor($data['color']),
            $data['isDefault']
        );
    }
}
