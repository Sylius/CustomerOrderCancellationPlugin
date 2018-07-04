<?php

declare(strict_types=1);

namespace Sylius\CustomerOrderCancellationPlugin\Action;

use Doctrine\ORM\EntityManagerInterface;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use SM\SMException;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\OrderTransitions;
use Sylius\CustomerOrderCancellationPlugin\Checker\CustomerOrderCancellationCheckerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webmozart\Assert\Assert;

final class CustomerOrderCancellationAction
{
    /** @var CustomerOrderCancellationCheckerInterface */
    private $customerOrderCancellationChecker;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var EntityManagerInterface */
    private $orderManager;

    /** @var StateMachineFactoryInterface */
    private $stateMachineFactory;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(
        CustomerOrderCancellationCheckerInterface $customerOrderCancellationChecker,
        OrderRepositoryInterface $orderRepository,
        EntityManagerInterface $orderManager,
        StateMachineFactoryInterface $stateMachineFactory,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->customerOrderCancellationChecker = $customerOrderCancellationChecker;
        $this->orderRepository = $orderRepository;
        $this->orderManager = $orderManager;
        $this->stateMachineFactory = $stateMachineFactory;
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(Request $request): Response
    {
        $orderNumber = $request->attributes->get('orderNumber');
        $order = $this->orderRepository->findOneByNumber($orderNumber);

        if (!$this->customerOrderCancellationChecker->canBeCancelled($order)) {
            $this->getFlashBag($request)->add('error', 'sylius.order.cancel_error');

            return new RedirectResponse($this->urlGenerator->generate('sylius_shop_account_order_index'));
        }

        try {
            $this->stateMachineFactory
                ->get($order, OrderTransitions::GRAPH)
                ->apply(OrderTransitions::TRANSITION_CANCEL)
            ;
        } catch (SMException $e) {
            $this->getFlashBag($request)->add('error', 'sylius.order.cancel_error');

            return new RedirectResponse($this->urlGenerator->generate('sylius_shop_account_order_index'));
        }

        $this->orderManager->flush();

        return new RedirectResponse($this->urlGenerator->generate('sylius_shop_account_order_index'));
    }

    private function getFlashBag(Request $request): FlashBagInterface
    {
        /** @var SessionInterface|null $session */
        $session = $request->getSession();

        Assert::notNull($session);

        /** @var FlashBagInterface $flashBag */
        $flashBag = $session->getBag('flashes');

        Assert::isInstanceOf($flashBag, FlashBagInterface::class);

        return $flashBag;
    }
}
