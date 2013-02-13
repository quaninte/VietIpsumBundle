<?php
/**
 * Quan MT - Brodev Software
 * www.brodev.com
 */

namespace Brodev\VietIpsumBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Brodev\VietIpsumBundle\Ipsum\Dictionary;
use Brodev\VietIpsumBundle\Ipsum\Generator;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('vietipsum:generate')
            ->setDescription('Generate a paragraph')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dictionaryPath = dirname(dirname(__FILE__)) . '/Resources/dictionaries/viet-food.txt';

        $dictionary = new Dictionary();
        $dictionary->readFromFile($dictionaryPath);

        $generator = new Generator($dictionary);
        $str = $generator->generate(3);

        $output->writeln($str);
    }

}
