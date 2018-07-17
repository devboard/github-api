<?php

declare(strict_types=1);

namespace DevboardLib\GitHubApi\V4\Object\Repository\Factory;

use DevboardLib\GitHub\GitHubLabel;
use DevboardLib\GitHub\Label\LabelColor;
use DevboardLib\GitHub\Label\LabelId;
use DevboardLib\GitHub\Label\LabelName;

class LabelFactory
{
    public function create(array $data): GitHubLabel
    {
        $id = str_replace('05:Label', '', base64_decode($data['id'], true));

        return new GitHubLabel(
            new LabelId((int) $id),
            new LabelName($data['name']),
            new LabelColor($data['color']),
            $data['isDefault']
        );
    }
}
