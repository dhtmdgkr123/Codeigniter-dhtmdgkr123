<?php
namespace dhtmdgkr123\Codeigniter;
use Composer\Script\Event;
class PostInstall
{
    public static function postInstall(Event $event = null) : void
    {
        self::removeUnUsedVendor($event);
        // self::selfDelete();
    }
    private static function selfDelete() : void
    {
        $sorcePath = realpath('../composer.json.bak');
        $distPath = realpath('../composer.json');
        // copy($sorcePath, $distPath);
        // exec();
        // echo sprintf('cat '.$sorcePath. ' > '. $distPath);
        // unlink($sorcePath);

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
        } else {
            $io = $e->getIO();
            $io->write('Vendor Not Found');
            // echo \sprintf("Vendor not found\n");
        }
    }
}