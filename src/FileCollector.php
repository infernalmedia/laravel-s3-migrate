<?php

namespace OneThirtyOne\S3Migration;

use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Collection;

/**
 * Class FileCollector.
 */
class FileCollector
{
    /**
     * @var
     */
    protected $files;

    /**
     * @var \Illuminate\Filesystem\FilesystemManager
     */
    protected $fileSystem;

    /**
     * FileCollector constructor.
     *
     * @param \Illuminate\Filesystem\FilesystemManager $fileSystem
     */
    public function __construct(FilesystemManager $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function fromLocalStorage()
    {
        foreach (config('s3migrate.disks') as $disk) {
            foreach ($this->fileSystem->disk($disk)->files() as $file) {
                $files[] = File::newFileFromStorage($disk, $file);
            }
        }

        return Collection::make($files);
    }
}
