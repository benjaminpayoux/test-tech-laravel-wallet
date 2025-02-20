<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\PerformWalletTransfer;
use Illuminate\Http\Request;
use App\Models\RecurringTransfer;
use App\Http\Requests\Api\V1\StoreRecurringTransferRequest;

class RecurringTransferController
{
    public function create(StoreRecurringTransferRequest $request, PerformWalletTransfer $performWalletTransfer)
    {
        $recurring_transfer = new RecurringTransfer;

        $recurring_transfer->user_id = $request->user()->id;
        $recurring_transfer->start_date = $request->date('start_date');
        $recurring_transfer->end_date = $request->date('end_date');
        $recurring_transfer->frequency = $request->input('frequency');
        $recurring_transfer->recipient_email = $request->input('recipient_email');
        $recurring_transfer->amount = $request->input('amount');
        $recurring_transfer->reason = $request->input('reason');

        $recurring_transfer->save();

        $recipient = $request->getRecipient();

        $performWalletTransfer->execute(
            sender: $request->user(),
            recipient: $recipient,
            amount: $request->input('amount'),
            reason: $request->input('reason'),
        );

        return response()->noContent(201);
    }
}
