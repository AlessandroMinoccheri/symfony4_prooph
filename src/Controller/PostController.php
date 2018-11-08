<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Prooph\Common\Messaging\MessageFactory;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Exception\CommandDispatchException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class PostController extends FOSRestController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    const NAME_ATTRIBUTE = 'prooph_command_name';

    public function __construct(CommandBus $commandBus, MessageFactory $messageFactory, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->messageFactory = $messageFactory;
        $this->logger = $logger;
    }

    public function postCreatePostAction(Request $request)
    {
        $commandName = $request->attributes->get(self::NAME_ATTRIBUTE);

        if (null === $commandName) {
            return JsonResponse::create(
                [
                    'message' => sprintf(
                        'Command name attribute ("%s") was not found in request.',
                        self::NAME_ATTRIBUTE
                    )
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $payload = $request->request->all();

        $command = $this->messageFactory->createMessageFromArray($commandName, ['payload' => $payload]);

        try {
            $this->commandBus->dispatch($command);
        } catch (CommandDispatchException $ex) {
            $this->logger->error($ex->getPrevious());
            return JsonResponse::create(
                ['message' => $ex->getPrevious()->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Throwable $error) {
            $this->logger->error($error);
            return JsonResponse::create(['message' => $error->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return JsonResponse::create(null, Response::HTTP_CREATED);
    }
}
