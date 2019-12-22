<?php
if(! class_exists('Migrate')) {
    defined('BASEPATH') or exit('No direct script access allowed');
    class Migrate extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            if (! $this->input->is_cli_request()) {
                show_404();
            } else {
                $this->load->library('migration');
            }
        }
        public function version(string $version) : void 
        {
            $migrateVer = $this->migration->version($version);
            if (! $migrateVer) {
                echo $this->migration->error_string();
            } else {
                echo 'success';
            }
        }
        public function generate(string $name = '') : void
        {
            $data = [
                'className' => null
            ];
            if (! $name) {
                echo 'define migrate name';
                return;
            }
            if (! preg_match('/^[a-z_]+$/i', $name)) {
                if (strlen($name) < 4) {
                    echo 'migate name is upper 4 character';
                    return;
                }
                echo 'character is must be a-z';
                return;
            }
            $fileName = date('YmdHis') . '_' . $name . '.php';
            try {
                $folderPath = APPPATH . 'migrations';
                if (! is_dir($folderPath)) {
                    try {
                        mkdir($folderPath);
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                }
                $filePath = $folderPath . $fileName;
                if (! file_exists($filePath)) {
                    echo 'File already exists : '.$filePath;
                    return;
                }
                try {
                    $data['className'] = ucfirst($name);
                    $handle = fopen($filePath, 'w');
                    fwrite($handle, '<?php\n' . $this->load->view('cli/migrate/template', [
                        'className' => ucfirst($name)
                    ], true));
                    fclose($handle);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                echo 'migrate success : '.$filePath;

            } catch (\Exception $th) {
                //throw $th;
            }
        }
    }
}