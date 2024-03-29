<?php

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use App\Components\JwtAuth;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\Config\Configuration;
use Slim\App;
use Slim\Factory\AppFactory;

return [
    Configuration::class => function () {
        return new Configuration(require __DIR__ . '/settings.php');
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Optional: Set the base path to run the app in a sub-directory
        // The public directory must not be part of the base path
        $app->setBasePath('/pedidos');

        return $app;
    },

    // Database connection
    Connection::class => function (ContainerInterface $container) {
        $factory = new ConnectionFactory(new IlluminateContainer());

        $connection = $factory->make($container->get(Configuration::class)->getArray('db'));

        // Disable the query log to prevent memory issues
        $connection->disableQueryLog();

        return $connection;
    },

    PDO::class => function (ContainerInterface $container) {
        return $container->get(Connection::class)->getPdo();
    },

    // Add this entry
    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    // And add this entry
    JwtAuth::class => function (ContainerInterface $container) {
        $config = $container->get(Configuration::class);

        $issuer = $config->getString('jwt.issuer');
        $lifetime = $config->getInt('jwt.lifetime');
        $privateKey = $config->getString('jwt.private_key');
        $publicKey = $config->getString('jwt.public_key');

        return new JwtAuth($issuer, $lifetime, $privateKey, $publicKey);
    },

    PHPMailer::class => function (ContainerInterface $container) {
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug  = 0;                      
        $mail->isSMTP();                                
        $mail->Host       = 'smtp.gmail.com';             
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'gonzalore01@gmail.com  ';       
        $mail->Password   = '258g456rew1';                 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;                                    

        //Recipients
        $mail->setFrom('gonzalore@gmail.com', 'Gonzalo');
        $mail->addAddress('re.gonzalo@yahoo.com.ar');
        $mail->isHTML(true);

        return $mail;
    }

];