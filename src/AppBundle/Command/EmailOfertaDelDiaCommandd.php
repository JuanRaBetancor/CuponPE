<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Command\Command;

class EmailOfertaDelDiaCommandd extends Command
{
    protected  function configure()
    {
        $this->setName('email:oferta-del-diaa')
            ->setDefinition(array(new InputArgument('ciudad',InputArgument::OPTIONAL,
                'El slug de la ciudad para la que se genera los emails'),
                new InputOption('accion',null,InputOption::VALUE_OPTIONAL,
                    'Indica si los emails sólo se generan o también se envían', 'enviar'),))
            ->setDescription('Genera y envía a cada usuario el email con la oferta del día')
            ->setHelp(<<<EOT
El comando <info>email:oferta-del-día</info> genera y envía un email con la oferta del
día de la ciudad en la que se ha apuntado el usuario. 
EOT
        );
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $ciudad = $input->getArgument('ciudad');
        $accion = $input->getOption('accion');

        $output->writeln('Comienza el proceso de generación de emails...');

        // ....


        $output->write(array('Generados <info>10</info> emails',
            '<comment>Comienza el envío de los mensajes</comment>',
            '<info>Conectando</info> con el <comment>servidor de correoz</comment>...'));
    }

}