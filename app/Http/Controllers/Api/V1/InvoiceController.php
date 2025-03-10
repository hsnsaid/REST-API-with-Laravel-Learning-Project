<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\InvoicesFilter;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\BulkStoreInvoiceRequest;
use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter=new InvoicesFilter();
        $filterItems=$filter->transform($request);
        $invoices=Invoice::where($filterItems)->paginate();
        return new InvoiceCollection($invoices->appends($request->query()));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $validated = $request->validated();
        $invoice = Invoice::create($validated);

        return response()->json([
            'message' => $invoice == true ? 'Invoice has been created Successfully' : 'Falied creating the Invoice',
            'invoice' => $invoice
        ], $invoice == true ? 200 : 500);
    }
    public function bulk(BulkStoreInvoiceRequest $request){
        $bulk=collect($request->all())->map(function($arr,$key){
            return Arr::except($arr,['customerId','billedDate','paidDate']);
        });
        Invoice::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreInvoiceRequest $request, Invoice $invoice)
    {
        $invoiceUpdated = $request->validated();

        
        if ($invoice === null)
            return response()->json([
                'success' => false,
                'message' => 'Invoice does not exists'
            ], 404);

        $invoice->customer_id = $invoiceUpdated['customer_id'];
        $invoice->amount = $invoiceUpdated['amount'];
        $invoice->status = $invoiceUpdated['status'];
        $invoice->billed_date = $invoiceUpdated['billed_date'];
        $invoice->paid_date = $invoiceUpdated['paid_date'];
        $invoice->save();

        return response()->json([
            'success' => true,
            'message' => 'product updated successfully',
            'invoice' => $invoice
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $status = $invoice?->delete();

        return response()->json([
            'status'=> $status == true ? 'Invoice has been deleted' : 'Error while deleting Invoice'
        ],$status == true ? 200 : 500);
    }
}
