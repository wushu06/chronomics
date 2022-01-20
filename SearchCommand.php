<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class SearchCommand extends Command
{

    protected function configure()
    {
        $this->setName('search');
        $this->setDescription('Search for chromosome');
        $this->addArgument('chr', InputArgument::OPTIONAL, 'Chromosome')
            ->addArgument('pos', InputArgument::OPTIONAL, 'Position');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $chr = $input->getArgument('chr');
        $pos = $input->getArgument('pos');
        if ($chr == '' || $pos == '') {
            $chr_question = new Question('Enter chromosome: ');
            $pos_question = new Question('Enter position: ');
            $helper = $this->getHelper('question');
            $chr = $helper->ask($input, $output, $chr_question);
            $pos = $helper->ask($input, $output, $pos_question);
        }

        $output->writeln($this->search($chr, $pos));
        return Command::SUCCESS;
    }

    /**
     * @param $chr
     * @param $pos
     * @return string
     */
    protected function search($chr, $pos): string
    {

        $handle = fopen("./assets/input_tiny.vcf", "r");
        // $chr1 = 'chr1';
        // $pos = '16837';
        $searchBy = $chr . $pos;

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if ($line[0] !== "#") {
                    $array = explode('.', $line);

                    $chrPos = preg_replace('/\s+/', '', $array[0]);

                    if ($searchBy == $chrPos) {
                        $result = trim($array[1]);
                        preg_match('/^\S*/', $result, $output_array);
                        return sprintf('%s:%s is: "%s"', $chr, $pos, $output_array[0]);
                    }
                }
            }

            fclose($handle);
            return 'no result';
        }

        return 'error';
    }
}