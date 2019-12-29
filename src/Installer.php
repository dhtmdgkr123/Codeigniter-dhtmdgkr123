<?php
namespace dhtmdgkr123\Codeigniter;
use Composer\Script\Event;
class AfterInstall
{
    public static function postInstall(Event $event = null) : void
    {
        echo 'adsf';
        // self::removeUnUsedVendor();
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
AfterInstall::postInstall();