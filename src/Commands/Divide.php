<?php
namespace Jakmall\Recruitment\Calculator\Commands;
use Illuminate\Console\Command;
class Divide extends Command
{
    /**
     * @var string
     */
    protected $signature = 'divide {angka*}';
    /**
     * @var string
     */
    protected $description = "Masukkan angka yang akan di kalkulasi";
    protected $storage = [];

    public function __construct() {
        parent::__construct();
    }

    public function handle(): void {
        $result = $this->Kalkulasi();
        echo $result. "\n";
    }

    protected function Input() {
        return $this->argument('angka');
    }

    protected function Operator(): string {
        return '-';
    }

    protected function Command($arrayNumber) {
        return implode(' - ', $arrayNumber);
    }

    protected function hitung(array $numbers) {
      $result = null;
      if(count($numbers) > 0) {
          foreach($numbers as $key => $value) {
              if($key === 0) {
                  $result = $value;
              } else {
                  $result = $result / $value;
              }
          }
      }
      return $result;
    }

    protected function Kalkulasi() {
        $number = $this->Input();
        if(count($number) > 0) {
            $description       = $this->Command($number);
            $resultCalculation = $this->hitung($number);
            $finalResult = strval($description)." = ".strval($resultCalculation);
            $this->File($description, $resultCalculation, $finalResult);
        } else {
            $this->info('Silahkan input angkanya');
            exit;
        }
        return $finalResult;
    }

    protected function File($description, $result, $output) {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $this->storage = [
            'command' => $this->getCommand(),
            'description' => $description,
            'result' => $result,
            'output' => $output,
            'time' => $now
        ];
        $file    = fopen('src/history.txt', 'a');
        $content = $this->storage['command'].';'.$this->storage['description'].';'.$this->storage['result'].';'.$this->storage['output'].';'.$this->storage['time'];
        fwrite($file, $content. "\n");
        fclose($file);
    }


    protected function getCommand(): string
    {
        return 'Divide';
    }
}
