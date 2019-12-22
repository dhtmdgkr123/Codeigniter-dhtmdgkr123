<?php
if(! class_exists('File')) {
    class File
    {
        public function checkView(string $head, string $body, string $foot) : bool
        {
            $ext = '.php';
            return file_exists(VIEWPATH.$head.$ext) && file_exists(VIEWPATH.$body.$ext) && file_exists(VIEWPATH.$foot.$ext);
        }
    }
}