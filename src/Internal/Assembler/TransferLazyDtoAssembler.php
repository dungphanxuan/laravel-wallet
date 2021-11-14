<?php

declare(strict_types=1);

namespace Bavix\Wallet\Internal\Assembler;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Internal\Dto\TransactionDto;
use Bavix\Wallet\Internal\Dto\TransferLazyDto;

final class TransferLazyDtoAssembler implements TransferLazyDtoAssemblerInterface
{
    public function create(
        Wallet $fromWallet,
        Wallet $toWallet,
        int $discount,
        string $fee,
        TransactionDto $withdrawDto,
        TransactionDto $depositDto,
        string $status
    ): TransferLazyDto {
        return new TransferLazyDto(
            $fromWallet,
            $toWallet,
            $discount,
            $fee,
            $withdrawDto,
            $depositDto,
            $status
        );
    }
}