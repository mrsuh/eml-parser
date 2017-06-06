<?php

namespace src;

class Tomita
{
    private $bin;
    private $config;

    /**
     * Tomita constructor.
     * @param string $bin
     * @param string $config
     */
    public function __construct(string $bin, string $config)
    {
        $this->bin    = $bin;
        $this->config = $config;
    }

    /**
     * @param string $text
     * @return string
     * @throws \Exception
     */
    public function run(string $text) : string
    {
        $descriptors = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w']  // stderr
        ];
        $cmd         = sprintf('%s %s', $this->bin, $this->config);
        $process     = proc_open($cmd, $descriptors, $pipes, dirname($this->config));
        if (is_resource($process)) {
            fwrite($pipes[0], $text);
            fclose($pipes[0]);
            $output = stream_get_contents($pipes[1]);

            $err = stream_get_contents($pipes[2]);

            if (TOMITA_DEBUG) {
                var_dump($err);
            }

            fclose($pipes[1]);
            fclose($pipes[2]);

            proc_close($process);

            return $output;
        }

        throw new \Exception('proc_open fails');
    }

    /**
     * @param string $xml
     * @return Person
     */
    public function handleResult(string $xml)
    {
        $parse = simplexml_load_string($xml);
        $person  = new Person();
        if(!isset($parse->document->facts->FactPerson)) {
            return $person;
        }

        $facts = $parse->document->facts->FactPerson;

        foreach($facts as $fact) {
            if(isset($fact->Name)) {
                $person->setName(mb_strtolower($fact->Name['val']));
            }

            if(isset($fact->Phone)) {
                $person->setPhone($fact->Phone['val']);
            }

            if(isset($fact->Email)) {
                $person->setEmail(mb_strtolower($fact->Email['val']));
            }
        }

        return $person;
    }
}
