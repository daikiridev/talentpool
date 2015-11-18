<?php
// src/Application/Sonata/MediaBundle/Provider/FileProvider.php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Provider\FileProvider as BaseFileProvider ;
use Sonata\CoreBundle\Model\Metadata;

use Sonata\MediaBundle\Model\MediaInterface;


class FileProvider extends BaseFileProvider
{

    /**
     * @throws \RuntimeException
     *
     * @param MediaInterface $media
     */
// This transforms all filenames into "resume", which might not be suitable in the future...
// -> should be amended
    // MySQL Update:
    // update media__media set name='resume', provider_metadata='{"filename":"resume"}' where provider_name='sonata.media.provider.file'
    
    protected function fixFilename(MediaInterface $media)
    {
        $media->setName("resume");
        $media->setMetadataValue('filename', "resume");
    }
}
