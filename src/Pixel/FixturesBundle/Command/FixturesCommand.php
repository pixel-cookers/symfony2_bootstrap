<?php 

namespace Pixel\FixturesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Pixel\UserBundle\Model\User;
use Pixel\UserBundle\Model\UserQuery;

class FixturesCommand extends ContainerAwareCommand
{
	protected $userManager;
	
    protected function configure()
    {
        $this
            ->setName('pixel:fixtures')
            ->setDescription('Generate fixtures')
            //->addOption('empty-tables', null, InputOption::VALUE_NONE, 'If set, the task will empty all tables')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $output->writeln("---------------------");
        $output->writeln("|  Emptying tables  |");
        $output->writeln("---------------------");

        // Users
        UserQuery::create()->find()->delete();
        $output->writeln("1/5 - User");

        // Stats
        //StatQuery::create()->find()->delete();
        //$output->writeln("2/5 - Stat");

        // StatsUser
        //StatUserQuery::create()->find()->delete();
        //$output->writeln("3/5 - StatUser");

        // Log
        //StatUserQuery::create()->find()->delete();
        //$output->writeln("4/5 - Log");

        // LogUser
        //StatUserQuery::create()->find()->delete();
        //$output->writeln("5/5 - LogUser");

        $this->createUsers($output);
        //$this->createStats($output);
        //$this->createStatsUser($output);
    }
    
    protected function createUsers(OutputInterface $output)
    {
    	$output->writeln("");
    	$output->writeln("---------------------");
    	$output->writeln("|  Creating Users   |");
    	$output->writeln("---------------------\n");
    	
    	$users = array(
	    	array("Alexandre"),
	    	array("Anthony"),
	    	array("Aurélien"),
	    	array("Benjamin"),
	    	array("Colin"),
	    	array("Eric"),
	    	array("Eymeric"),
	    	array("Hanna"),
	    	array("Jérémie"),
	    	array("Ludovic"),
	    	array("Michel"),
	    	array("Nicolas"),
	    	array("Raphaelle"),
	    	array("Remi"),
	    	array("Sylvain"),
    	);

        foreach($users as $key => $user)
        {
            $current = $key + 1;
            $username = $user[0];
            $password = strtolower($user[0]);
            $email = "colin.bellino+user_" . $current . "@pixel-cookers.com";
            $superadmin = ($username == "Colin") ? true : false;
            $inactive = false;
            $likeWaffles = rand(0, 1); // Obviously there are some false informations here. Really, who don't like waffles ?

            $manipulator = $this->getContainer()->get('fos_user.util.user_manipulator');
            $manager = $this->getContainer()->get('fos_user.user_manager');
            $newUser = $manipulator->create($username, $password, $email, !$inactive, $superadmin);

            $newUser->setLikeWaffles($likeWaffles);
            $manager->updateUser($newUser);

            $output->writeln($current . "/" . count($users) . " - " . $email);
        }
    	
    }
}