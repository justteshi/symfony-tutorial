<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArticleStatsCommand extends Command
{
    protected static $defaultName = 'article:stats';
    protected static $defaultDescription = 'Return some article stats';

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('slug', InputArgument::REQUIRED, 'The article\'s slug')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'THe output format description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $data = [
            'slug' => $slug,
            'hearts' => rand(10,100)
        ];

        switch ($input->getOption('format')) {
            case 'text':
                $rows =[];
                foreach ($data as $key => $value){
                    $rows[] = [$key, $value];
                }
                $io->table(['Key', 'Value'],$rows);
                break;
            case 'json':
                $io->writeln(json_encode($data));
                break;
            default:
                throw new \Exception('WHat format is that ?!');
        }
        return 0;
    }
}
