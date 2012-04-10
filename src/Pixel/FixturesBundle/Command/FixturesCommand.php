<?php 

namespace Pixel\FixturesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Pixel\UserBundle\Model\User;
use Pixel\UserBundle\Model\UserQuery;

use Pixel\BootstrapBundle\Model\Book;
use Pixel\BootstrapBundle\Model\BookQuery;

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
        $output->writeln("1/2 - Users");

        // Books
        BookQuery::create()->find()->delete();
        $output->writeln("2/2 - Books");

        $this->createUsers($output);
        $this->createBooks($output);
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

    protected function createBooks(OutputInterface $output)
    {
        $output->writeln("");
        $output->writeln("---------------------");
        $output->writeln("|  Creating Books   |");
        $output->writeln("---------------------\n");

        $users = UserQuery::create()
            ->find();

        $books = array(
            "The Lord of the Rings",
            "The Hobbit",
            "The Adventures of Tom Bombadil",
            "Head First Networking",
            "Head First HTML5 Programming",
            "Head First WordPress",
            "Head First Physics",
            "Robot Dreams",
            "The Complete Robot",
            "The Winds of Change and Other Stories",
            "I, Robot",
            "I Can Has Cheezburger?",
        );

        foreach($books as $key => $book)
        {
            $current = $key + 1;
            $title = $book;
            $author = array_rand($users->toArray());

            $newBook = new Book();
            $newBook->setTitle($title);
            $newBook->setAuthorId($author);
            $newBook->save();

            $output->writeln($current . "/" . count($books) . " - " . $title);
        }
    }
}