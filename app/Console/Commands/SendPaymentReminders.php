<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pemesanan;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:payment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp reminders for unpaid credit orders close to or on due date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting payment reminders check...');
        $fonnte = new FonnteService();

        $today = now()->format('Y-m-d');
        $threeDaysFromNow = now()->addDays(3)->format('Y-m-d');

        // 1. Due Today Reminders
        $ordersDueToday = Pemesanan::with('user')
            ->whereIn('status', ['Credit', 'Invoice'])
            ->where('estimasipembayaran', $today)
            ->get();

        $this->info("Found {$ordersDueToday->count()} orders due today.");

        foreach ($ordersDueToday as $order) {
            $user = $order->user;
            if ($user && $user->phoneNumber) {
                $totalHargaFormatted = number_format($order->totalHarga, 0, ',', '.');
                $message = "🚨 *PENGINGAT JATUH TEMPO HARI INI* 🚨\n\n";
                $message .= "Halo {$user->username},\n";
                $message .= "Kami ingin mengingatkan bahwa pesanan Anda dengan kode *{$order->kodePemesanan}* jatuh tempo *HARI INI*.\n\n";
                $message .= "Total Tagihan: *Rp {$totalHargaFormatted}*\n";
                $message .= "Tenggat Waktu: *{$order->estimasipembayaran}*\n\n";
                $message .= "Silakan lakukan pembayaran secepatnya. Terima kasih!";

                $fonnte->sendMessage($user->phoneNumber, $message);
                $this->info("Sent reminder to {$user->username} for order {$order->kodePemesanan} (Due Today)");
            }
        }

        // 2. Due in 3 Days Reminders
        $ordersDueSoon = Pemesanan::with('user')
            ->whereIn('status', ['Credit', 'Invoice'])
            ->where('estimasipembayaran', $threeDaysFromNow)
            ->get();

        $this->info("Found {$ordersDueSoon->count()} orders due in 3 days.");

        foreach ($ordersDueSoon as $order) {
            $user = $order->user;
            if ($user && $user->phoneNumber) {
                $totalHargaFormatted = number_format($order->totalHarga, 0, ',', '.');
                $message = "⚠️ *PENGINGAT JATUH TEMPO* ⚠️\n\n";
                $message .= "Halo {$user->username},\n";
                $message .= "Kami ingin mengingatkan bahwa pesanan Anda dengan kode *{$order->kodePemesanan}* akan jatuh tempo dalam *3 hari* lagi.\n\n";
                $message .= "Total Tagihan: *Rp {$totalHargaFormatted}*\n";
                $message .= "Tenggat Waktu: *{$order->estimasipembayaran}*\n\n";
                $message .= "Mohon persiapkan pembayaran sebelum tenggat waktu. Terima kasih!";

                $fonnte->sendMessage($user->phoneNumber, $message);
                $this->info("Sent reminder to {$user->username} for order {$order->kodePemesanan} (Due in 3 Days)");
            }
        }

        // 3. Overdue Reminders (Tenggat Waktu Lewat)
        $ordersOverdue = Pemesanan::with('user')
            ->whereIn('status', ['Credit', 'Invoice'])
            ->where('estimasipembayaran', '<', $today)
            ->get();

        $this->info("Found {$ordersOverdue->count()} orders overdue.");

        foreach ($ordersOverdue as $order) {
            $user = $order->user;
            if ($user && $user->phoneNumber) {
                $totalHargaFormatted = number_format($order->totalHarga, 0, ',', '.');
                $message = "🚨 *PEMBERITAHUAN JATUH TEMPO (LEWAT BATAS)* 🚨\n\n";
                $message .= "Halo {$user->username},\n";
                $message .= "Kami ingin menginformasikan bahwa pesanan Anda dengan kode *{$order->kodePemesanan}* telah *MELEWATI TENGGAT WAKTU* pembayaran.\n\n";
                $message .= "Total Tagihan: *Rp {$totalHargaFormatted}*\n";
                $message .= "Tenggat Waktu: *{$order->estimasipembayaran}*\n\n";
                $message .= "Mohon segera lakukan pembayaran. Terima kasih!";

                $fonnte->sendMessage($user->phoneNumber, $message);
                $this->info("Sent reminder to {$user->username} for order {$order->kodePemesanan} (Overdue)");
            }
        }

        $this->info('Payment reminders check completed.');
    }
}
