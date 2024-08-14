<?php // app/Helpers/WhatsAppHelper.php

if (!function_exists('createTextMessage')) {
    function createTextMessage($number, $message, bool $mentions = false)
    {
        return array(
            "number" => $number,
            "text"   => $message,
            "mentionsEveryOne" => $mentions,
            "linkPreview" => true,
        );
    }
}

if (!function_exists('createImageMessage')) {
    function createImageMessage($number, $caption, $mediaUrl, bool $mentions = false)
    {
        return array(
            "number" => $number,
            "mediatype" => "image",
            "mimetype" => "image/png",
            "caption" => $caption,
            "media" => $mediaUrl,
            "fileName" => basename($mediaUrl),
            "mentionsEveryOne" => $mentions,
        );
    }
}

if (!function_exists('createVideoMessage')) {
    function createVideoMessage($number, $caption, $mediaUrl, bool $mentions = false)
    {
        return array(
            "number" => $number,
            "mediatype" => "video",
            "mimetype" => "video/mp4",
            "caption" => $caption,
            "media" => $mediaUrl,
            "fileName" => basename($mediaUrl),
            "mentionsEveryOne" => $mentions,
        );
    }
}

if (!function_exists('createPdfDocumentMessage')) {
    function createPdfDocumentMessage($number, $fileName, $caption, $mediaUrl, bool $mentions = false)
    {
        return array(
            "number" => $number,
            "mediatype" => "document",
            "fileName" => $fileName,
            "caption" => $caption,
            "media" => $mediaUrl,
            "mentionsEveryOne" => $mentions,
        );
    }
}

if (!function_exists('createXlsxDocumentMessage')) {
    function createXlsxDocumentMessage($number, $fileName, $caption, $mediaUrl, bool $mentions = false)
    {
        return array(
            "number" => $number,
            "options" => array(
                "delay" => 1200,
                "presence" => "composing"
            ),
            "mediaMessage" => array(
                "mediatype" => "document",
                "fileName" => $fileName,
                "caption" => $caption,
                "media" => $mediaUrl
            )
        );
    }
}

if (!function_exists('createZipDocumentMessage')) {
    function createZipDocumentMessage($number, $fileName, $caption, $mediaUrl, bool $mentions = false)
    {
        return array(
            "number" => $number,
            "options" => array(
                "delay" => 1200,
                "presence" => "composing"
            ),
            "mediaMessage" => array(
                "mediatype" => "document",
                "fileName" => $fileName,
                "caption" => $caption,
                "media" => $mediaUrl
            )
        );
    }
}

if (!function_exists('createAudioMessage')) {
    function createAudioMessage($number, $audioUrl, bool $mentions = false)
    {
        return array(
            "number" => $number,
            "audio" => $audioUrl,
            "mentionsEveryOne" => $mentions
        );
    }
}
