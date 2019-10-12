<?php
namespace Jakmall\Recruitment\Calculator\Commands;
use Illuminate\Console\Command;
class Histori extends Command
{
    /**
     * @var string
     */
    protected $signature = 'history:list';
    /**
     * @var string
     */
    protected $description = "Daftar Riwayat Kalkulasi";
    protected $urlFile = "src/history.txt";
    public function __construct()
    {
        parent::__construct();
    }
    public function handle(): void
    {
        $this->Validasi();
        $this->Header();
        $this->File();
        // $result = $this->prosesKalkulasi();
        // echo $result. "\n";
    }

    protected function Content($content) {
        foreach ($content as $conten) {
            echo '| '.$conten['no'].'  | '.$conten['command'].'      | '.$conten['description'].'           | '.$conten['result'].'      | '.$conten['output'].'      | '.$conten['time'];
        }
    }

    protected function Header() {
        $this->line('+----+----------+-----------------+--------+---------------------+---------------------+');
        $this->line('| '.'No'.' | '.'Command '.' | '.'Description    '.' | '.'Result'.' | '.'Output             '.' | '.'Time               '.' |');
        $this->line('+----+----------+-----------------+--------+---------------------+---------------------+');
    }

    protected function Validasi() {
        if(!file_exists($this->urlFile)) {
            $this->info('Riwayat Kosong.');
            exit;
        } else {
            $read = file($this->urlFile);
            if(!count($read)) {
                $this->info('Riwayat Kosong.');
                exit;
            }
        }
    }

    protected function File() {
        $content = [];
        if(file_exists($this->urlFile)) {
            $read = file($this->urlFile);
            $idx = 1;
            foreach($read AS $r) {
                $arrExplode = explode(';', $r);
                array_push($content, [
                    "no" => $idx,
                    "command" => $arrExplode[0],
                    "description" => $arrExplode[1],
                    "result" => $arrExplode[2],
                    "output" => $arrExplode[3],
                    "time" => $arrExplode[4],
                ]);
                $idx ++;
            }
        } else {
        }
        //echo print_r($contentArr, true);
        // fill the content
        $this->Content($content);
    }

}
