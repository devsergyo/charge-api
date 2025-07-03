<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Models\InvoiceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendInvoiceNotificationJob implements ShouldQueue
{
    use Queueable;

    protected Invoice $invoice;
    protected $customer;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->customer = $invoice->customer;
    }

    public function handle(): void
    {        
        $emailPayload = [
            'to' => [
                'email' => $this->customer->email,
                'name' => $this->customer->full_name
            ],
            'subject' => 'Nova cobrança gerada - Cobrança #' . $this->invoice->id,
            'content' => [
                'html' => $this->generateEmailContent(),
                'text' => $this->generateTextContent()
            ]
        ];

        // Simula envio do email via Log (apenas para visualização)
        Log::info('=== SIMULAÇÃO DE ENVIO DE EMAIL ===');
        Log::info("Cobrança {$this->invoice->id}: E-mail enviado com sucesso para {$this->customer->email}");
        Log::info('Conteúdo do email:');
        Log::info($emailPayload['content']['text']);
        Log::info('=====================================');


        $this->invoice->notifications()->create([
            'type' => 'mailing',
            'status' => 'done',
            'payload' => $emailPayload,
        ]);
    }

    /**
     * Gera o conteúdo HTML do email
     * 
     * @return string
     */
    private function generateEmailContent(): string
    {
        return "
        <h2>Nova Cobrança Gerada</h2>
        <p>Olá, <strong>{$this->customer->full_name}</strong>!</p>
        
        <p>Uma nova cobrança foi gerada em nosso sistema:</p>
        
        <div style='background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;'>
            <h3>Detalhes da Cobrança</h3>
            <p><strong>Número:</strong> #{$this->invoice->id}</p>
            <p><strong>Valor:</strong> R$ " . number_format($this->invoice->amount, 2, ',', '.') . "</p>
            <p><strong>Vencimento:</strong> {$this->invoice->due_date->format('d/m/Y')}</p>
            <p><strong>Descrição:</strong> {$this->invoice->description}</p>
        </div>
        
        <p>Por favor, efetue o pagamento até a data de vencimento.</p>
        
        <p>Atenciosamente,<br>Equipe Charge API</p>
        ";
    }

    /**
     * Gera o conteúdo texto do email
     * 
     * @return string
     */
    private function generateTextContent(): string
    {
        return "
            Nova Cobrança Gerada

            Olá, {$this->customer->full_name}!

            Uma nova cobrança foi gerada em nosso sistema:

            DETALHES DA COBRANÇA
            Número: #{$this->invoice->id}
            Valor: R$ " . number_format($this->invoice->amount, 2, ',', '.') . "
            Vencimento: {$this->invoice->due_date->format('d/m/Y')}
            Descrição: {$this->invoice->description}

            Por favor, efetue o pagamento até a data de vencimento.

            Atenciosamente,
            Equipe Charge API";
    }
}
