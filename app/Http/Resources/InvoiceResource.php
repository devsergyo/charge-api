<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer_id' => $this->customer_id,
            'amount' => number_format($this->amount, 2, '.', ''),
            'due_date' => $this->due_date->format('Y-m-d'),
            'description' => $this->description,
        ];
    }
}
