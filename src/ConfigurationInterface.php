<?php
namespace Old\Milantex\Core;

interface ConfigurationInterface {
    public static function getDatabaseHostname(): string;
    public static function getDatabaseUsername(): string;
    public static function getDatabasePassword(): string;
    public static function getDatabaseName(): string;

    public static function getWebsiteBaseUrl(): string;

    public static function getTemplatesFilesystemPath(): string;
}
