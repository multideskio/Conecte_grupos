<?php // app/Helpers/WhatsAppHelper.php

if (!function_exists('createTextMessage')) {
    function createTextMessage($number, $message, bool $mentions = false) {
        return array(
            "number" => $number,
            "options" => array(
                "delay" => 1200,
                "presence" => "composing",
                "mentions" => array(
                    "everyOne" => $mentions
                )
            ),
            "textMessage" => array(
                "text" => $message
            )
        );
    }
}

if (!function_exists('createImageMessage')) {
    function createImageMessage($number, $caption, $mediaUrl) {
        return array(
            "number" => $number,
            "options" => array(
                "delay" => 1200,
                "presence" => "composing"
            ),
            "mediaMessage" => array(
                "mediatype" => "image",
                "caption" => $caption,
                "media" => $mediaUrl
            )
        );
    }
}

if (!function_exists('createVideoMessage')) {
    function createVideoMessage($number, $caption, $mediaUrl) {
        return array(
            "number" => $number,
            "options" => array(
                "delay" => 1200,
                "presence" => "composing"
            ),
            "mediaMessage" => array(
                "mediatype" => "video",
                "caption" => $caption,
                "media" => $mediaUrl
            )
        );
    }
}

if (!function_exists('createPdfDocumentMessage')) {
    function createPdfDocumentMessage($number, $fileName, $caption, $mediaUrl) {
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

if (!function_exists('createXlsxDocumentMessage')) {
    function createXlsxDocumentMessage($number, $fileName, $caption, $mediaUrl) {
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
    function createZipDocumentMessage($number, $fileName, $caption, $mediaUrl) {
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
    function createAudioMessage($number, $audioUrl) {
        return array(
            "number" => $number,
            "options" => array(
                "delay" => 1200,
                "presence" => "recording",
                "encoding" => true
            ),
            "audioMessage" => array(
                "audio" => $audioUrl
            )
        );
    }
}
