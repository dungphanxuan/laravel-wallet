<?php

declare(strict_types=1);

namespace Bavix\Wallet\Services;

use Bavix\Wallet\Models\Wallet;

final class StateService implements StateServiceInterface
{
    private BookkeeperServiceInterface $bookkeeperService;
    private RegulatorServiceInterface $regulatorService;

    /** @var Wallet[] */
    private array $wallets = [];

    public function __construct(
        BookkeeperServiceInterface $bookkeeperService,
        RegulatorServiceInterface $regulatorService
    ) {
        $this->bookkeeperService = $bookkeeperService;
        $this->regulatorService = $regulatorService;
    }

    public function persist(Wallet $wallet): void
    {
        $this->wallets[] = $wallet;
    }

    public function commit(): void
    {
        foreach (array_unique($this->wallets) as $wallet) {
            $this->bookkeeperService->increase($wallet, $this->regulatorService->diff($wallet));
        }

        $this->purge();
    }

    public function purge(): void
    {
        foreach ($this->wallets as $wallet) {
            $this->regulatorService->missing($wallet);
        }

        $this->wallets = [];
    }
}