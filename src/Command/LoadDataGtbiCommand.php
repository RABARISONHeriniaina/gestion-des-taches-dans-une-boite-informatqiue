<?php

namespace App\Command;

use App\Entity\Employee;
use App\Entity\Job;
use App\Entity\Task;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\PasswordHasherEncoder;

class LoadDataGtbiCommand extends Command
{
    protected static $defaultName = 'load:data:gtdbi';
    protected static $defaultDescription = 'Cette commande ajoute des donnees dans notre base de donnees (comme une fixture)';

    private $entityManagerInterface;
    private $passwordHasherEncoder;
    public function __construct(EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $passwordHasherEncoder)
    {
        parent::__construct();
        $this->entityManagerInterface = $entityManagerInterface;
        $this->passwordHasherEncoder = $passwordHasherEncoder;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $jobs[] = [];
        // creation d'un poste
        for ($i = 1; $i <= 10; $i++) {
            $job = new Job();
            $job->setName("JOB-" . $i);
            $this->entityManagerInterface->persist($job);
            $jobs[] = $job;
        }

        $employees[] = [];
        // creation d'un employee
        for ($j = 1; $j < 25; $j++) {

            $random_job = rand(1, 10);

            $employee = new Employee();
            $employee->setEmail("gtdbi" . $j . "@gmail.com")
                ->setRoles(["ROLE_EMPLOYEE"])
                ->setPassword(
                    $this->passwordHasherEncoder->hashPassword(
                        $employee,
                        "password123"
                    )
                )
                ->setSalary(10000000)
                ->setSex("Homme")
                ->setSkills("SKILLS : " . $j)
                ->setExperiences("EXPERIENCE : " . $j)
                ->setTakenAt(new \DateTimeImmutable())
                ->setFirstName("First Name" . $j)
                ->setLastName("Last Name" . $j)
                ->setJob($jobs[$random_job]);
            $this->entityManagerInterface->persist($employee);
            $employees[] = $employee;
        }

        // creation d'une tache

        $tasks[] = [];
        for ($k = 1; $k < 130; $k++) {
            $random_employee = rand(1, 24);
            $task = new Task();
            $task->setSubject("Task Subject : " . $k)
                ->setBeginAt(new \DateTimeImmutable())
                ->setEndAt(new DateTimeImmutable("tomorrow"))
                ->setEmployee($employees[$random_employee])
                ->setIsComplished(false)
                ->setIsInProgress(false);
            $this->entityManagerInterface->persist($task);
            $tasks[] = $task;
        }

        // creation d'une pause dans une tache



        $this->entityManagerInterface->flush();


        return Command::SUCCESS;
    }
}
