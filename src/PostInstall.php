<?php
namespace dhtmdgkr123\Codeigniter;
use Composer\Script\Event;
class PostInstall
{
    public static function postInstall(Event $event = null) : void
    {
        self::removeUnUsedVendor($event);
        self::selfDelete();
    }
    private static function selfDelete() : void
    {
        $sourcePath = realpath(__DIR__ . '/../composer.json.bak');
        $distPath  = realpath(__DIR__ . '/../composer.json');
        copy($sourcePath, $distPath);
        unlink($sourcePath);
        exec('composer update');
        
    }
    private static function removeUnUsedVendor(Event $e = null) : void
    {
        $base = realpath(__DIR__ . '/../vendor/codeigniter/framework');
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
                self::recursiveRemove($folder);
            }
        } else {
            $alertMessage = 'Vendor Not Found';
            if ($e) {
                $io = $e->getIO();
                $io->write($alertMessage);
            } else {
                echo sprintf($alertMessage.'\n');
            }
        }
    }
    private static function recursiveRemove(string $path) : vold
    {
        $realPath = realpath($path);
        if ($realPath) {
            $dirIterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($dirIterator as $dir) {
                $todo = ($dir->isDir() ? 'rmdir' : 'unlink');
                $todo($dir->getRealPath());
            }
            rmdir($path);
        }
    }
}