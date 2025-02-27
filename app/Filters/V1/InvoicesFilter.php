<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class InvoicesFilter extends ApiFilter{
    protected $safeParams=[
        'customerId'=>['eq'],
        'amount'=>['eq','gt','lt','gte','lte'],
        'status'=>['eq','ne'],
        'billed_date'=>['eq','gt','lt'],
        'paid_date'=>['eq','gt','lt'],
    ];
    protected $columnMap=[
        'customerId'=>'customer_id',
        'billedDate'=>'billed_date',
        'paidDate'=>'paid_date',
    ];
    protected $operatorMap=[
        'eq'=>'=',
        'gt'=>'>',
        'lt'=>'<',
        'gte'=>'>=',
        'lte'=>'<=',
        'ne'=>'!=',
    ];
}