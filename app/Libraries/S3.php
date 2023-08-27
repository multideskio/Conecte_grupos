<?php

namespace App\Libraries;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Intervention\Image\ImageManager;


class S3
{
    private $s3;
    private $awsBucket;
    private $image;

    public function __construct()
    {
        //$this->image = new ImageManager(['driver' => 'gd']);
        $this->awsBucket = getenv('AWS_BUCKET');

        $this->s3 = new S3Client([
            'credentials' => [
                'key'    => getenv('AWS_ACCESS_KEY_ID'),
                'secret' => getenv('AWS_SECRET_ACCESS_KEY')
            ],
            'region' => getenv('AWS_DEFAULT_REGION'),
            'version' => 'latest',
        ]);
    }

    public function uploadFile($localFilePath, $s3Path, $contentType)
    {
        try {
            $result = $this->s3->putObject([
                'Bucket' => $this->awsBucket,
                'Key'    => $s3Path,
                'ContentType' => $contentType,
                'SourceFile' => $localFilePath,
                'ACL' => 'public-read'
            ]);

            return $result['ObjectURL'];
        } catch (S3Exception $e) {
            return null;
        }
    }


    public function getDirectorySize($directoryPath)
    {
        try {
            $objects = $this->s3->listObjectsV2([
                'Bucket' => $this->awsBucket,
                'Prefix' => $directoryPath
            ]);

            $totalSize = 0;

            foreach ($objects['Contents'] as $object) {
                $totalSize += $object['Size'];
            }

            return $totalSize;
        } catch (S3Exception $e) {
            // Tratar exceções, se necessário
            return -1; // Ou outro valor de erro
        }
    }


    public function listDirectoryContents($directoryPath)
    {
        try {
            $objects = $this->s3->listObjectsV2([
                'Bucket' => $this->awsBucket,
                'Prefix' => $directoryPath
            ]);

            $contents = [];

            foreach ($objects['Contents'] as $object) {
                $contents[] = $object['Key'];
            }

            return $contents;
        } catch (S3Exception $e) {
            // Tratar exceções, se necessário
            return [];
        }
    }
}
