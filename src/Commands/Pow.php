<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class Pow extends Command
{
    /**
     * @var string
     */
    protected $signature = 'pow {base : The base number} {exp : The exponent number}';

    /**
     * @var string
     */
    protected $description = "Eksponen";

    protected $storage = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $result = $this->Kalkulasi();
        echo $result. "\n";
    }

    protected function Base()
    {
        return $this->argument('base');
    }

    protected function Exp()
    {
        return $this->argument('exp');
    }

    protected function Operator(): string
    {
        return '^';
    }

    protected function Command($base, $exp)
    {
        return $base. ' ^ '. $exp;
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function Hitung($base, $exp)
    {
        $result = pow($base, $exp);
        return $result;
    }

    protected function Kalkulasi() {
        $base = $this->Base();
        $exp  = $this->Exp();

        if($base && $exp) {
            $description       = $this->Command($base, $exp);
            $resultCalculation = $this->Hitung($base, $exp);

            $finalResult = strval($description)." = ".strval($resultCalculation);
            $this->File($description, $resultCalculation, $finalResult);

        } else {
            $this->info('Silahkan Masukkan angkanya');
            exit;
        }

        return $finalResult;
    }

    protected function File($description, $result, $output) {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $this->storage = [
            'command' => $this->getCommandVerb(),
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

    protected function getCommandVerb(): string
    {
        return 'Pow';
    }

}
