<?php

declare(strict_types=1);

use App\Actions\PerformWalletTransaction;
use App\Enums\WalletTransactionType;
use App\Models\Wallet;
use App\Notifications\BalanceTooLow;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->action = app(PerformWalletTransaction::class);
});

test('user is notified when balance is under 10€', function () {
    Notification::fake();

    // given user wallet with a balance > 10€
    $wallet = Wallet::factory()->forUser()->richChillGuy()->create();

    // when making a transaction
    $this->action->execute($wallet, WalletTransactionType::DEBIT, 999_991, 'test');

    // then receive a notification if the new balance is under 10€
    Notification::assertSentTo(
        [$wallet->user], BalanceTooLow::class
    );
});