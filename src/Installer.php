<?php
namespace dhtmdgkr123\CodeIgniter;
use Composer\Script\Event;
if(! class_exists('AfterInstall')) {
    class AfterInstall
    {
        public static function postInstall(Event $event = null) : void
        {
            self::removeUnUsedVendor();
        }
        private static function removeUnUsedVendor() : void
        {
            $base = realpath('../vendor/codeigniter/framework');
            if ($base) {
                $base .= '/';
                $unusedFolders = [
                    'application',
                    'user_guide',
                ];
                $unusedFiles = [
                    '.editorconfig',
                    '.gitignore',
                    'composer.json',
                    'index.php',
                    'readme.rst',
                ];
                
                foreach ($unusedFiles as $file) {
                    if (file_exists($base.$file)) {
                        unlink($base.$file);
                    }
                }
                foreach ($unusedFolders as $folder) {
                    $dirIterator = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($base.$folder, \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::CHILD_FIRST
                    );
                    foreach ($dirIterator as $info) {
                        $todo = ($info->isDir() ? 'rmdir' : 'unlink');
                        $todo($info->getRealPath());
                    }
                    rmdir($base.$folder);
                }
            }
        }
    }
}