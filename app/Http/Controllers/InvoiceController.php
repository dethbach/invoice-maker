<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('company_name', 'asc')->get();
        $invoices = Invoice::orderBy('created_at', 'desc')->get();
        return view('dashboard.index', compact('companies', 'invoices'));
    }

    public function companyStore(Request $request)
    {
        $validated = $request->validate([
            'imageUpload' => 'mimes:jpg,png,jpeg'
        ]);

        $newPicName = time() . '-' . $request->imageUpload->getClientOriginalName();
        $request->imageUpload->move(public_path('storage/company-pic'), $newPicName);

        $store = Company::create([
            'company_name' => $request->company_name,
            'address' => $request->address,
            'contact' => $request->contact,
            'phone' => $request->phone,
            'information' => $request->information,
            'logo' => $newPicName
        ]);

        if ($store) {
            return back()->with('success', 'Data successfully insert');
        } else {
            return back()->with('error', 'Failed to insert data');
        }
    }

    public function companyEdit($id)
    {
        $data = Company::where('id', $id)->first();
        return view('dashboard.company', compact('data'));
    }

    public function register(Request $request)
    {
        $invoiceNumber = generateInvoiceNumber();
        $slug = Carbon::now()->format('dmyhi') . Str::random(10);

        $store = Invoice::create([
            'user_id' => auth()->user()->id,
            'company_id' => $request->company_id,
            'bill_to' => $request->bill_to,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'slug' => $slug
        ]);

        if ($store) {
            return redirect('/invoice/' . $store->slug);
        } else {
            return back()->with('error', 'Failed to insert data');
        }
    }

    public function companyUpdate(Request $request)
    {
        $store = Company::where('id', $request->company_id)->update([
            'company_name' => $request->company_name,
            'address' => $request->address,
            'contact' => $request->contact,
            'phone' => $request->phone,
            'information' => $request->information,
        ]);

        if ($store) {
            return back()->with('success', 'Data successfully insert');
        } else {
            return back()->with('error', 'Failed to insert data');
        }
    }

    public function companyLogoUpdate(Request $request)
    {
        $validated = $request->validate([
            'imageUpload' => 'mimes:jpg,png,jpeg'
        ]);

        $newPicName = time() . '-' . $request->imageUpload->getClientOriginalName();
        $request->imageUpload->move(public_path('storage/company-pic'), $newPicName);

        $update = Company::where('id', $request->company_logo_id)->update([
            'logo' => $newPicName
        ]);

        if ($update) {
            return back()->with('success', 'Data successfully insert');
        } else {
            return back()->with('error', 'Failed to insert data');
        }
    }

    public function reset(Request $request)
    {
        $removal = InvoiceDetail::where('invoice_id', $request->myInvoice)->delete();
        $delete = Invoice::where('id', $request->myInvoice)->delete();
        if ($delete) {
            return redirect('/dashboard');
        } else {
            return back()->with('error', 'Failed to delete data');
        }
    }

    public function workplace($slug)
    {
        $data = Invoice::with('invoiceCompany')->where('slug', $slug)->first();
        $details = InvoiceDetail::where('invoice_id', $data->id)->orderBy('created_at', 'desc')->get();
        $sum = InvoiceDetail::where('invoice_id', $data->id)->sum('amount');
        $receipt = Receipt::with('receiptInvoice')->where('invoice_id', $data->id)->latest()->first();
        return view('dashboard.detail-invoice', compact('data', 'details', 'sum', 'receipt'));
    }

    public function delete($id)
    {
        $delete = InvoiceDetail::where('id', $id)->delete();
        if ($delete) {
            return back()->with('success', 'Record deleted');
        } else {
            return back()->with('error', 'Failed to delete record');
        }
    }

    public function detailStore(Request $request)
    {
        $cleanedPrice = preg_replace('/[^\d]/', '', $request->price);
        $amount = $cleanedPrice * $request->qty;
        $store = InvoiceDetail::create([
            'invoice_id' => $request->invoice_id,
            'item' => $request->item,
            'qty' => $request->qty,
            'price' => $cleanedPrice,
            'amount' => $amount
        ]);

        if ($store) {
            return back()->with('success', 'Data Successfully inserted');
        } else {
            return back()->with('error', 'Failed to insert data');
        }
    }

    public function export($slug)
    {
        $data = Invoice::with('invoiceCompany')->where('slug', $slug)->first();
        $details = InvoiceDetail::where('invoice_id', $data->id)->orderBy('created_at', 'desc')->get();
        $sum = InvoiceDetail::where('invoice_id', $data->id)->sum('amount');
        $pdf = PDF::loadView('invoice', compact('data', 'details', 'sum'));
        return $pdf->stream();
    }

    public function receiptStore(Request $request)
    {
        $cleanedPrice = preg_replace('/[^\d]/', '', $request->amount_received);

        $store = Receipt::create([
            'payment_date' => $request->payment_date,
            'payment_mode' => $request->payment_mode,
            'amount_received' => $cleanedPrice,
            'invoice_id' => $request->invoice_id,
        ]);

        if ($store) {
            return back()->with('success', 'Receipt stored');
        } else {
            return back()->with('error', 'Failed to save receipt');
        }
    }

    public function receiptReset($id)
    {
        $data = Receipt::where('invoice_id', $id)->delete();

        return back();
    }

    public function receiptExport($id)
    {
        $data = Receipt::with('receiptInvoice')->where('id', $id)->first();
        $invoice = Invoice::where('id', $data->invoice_id)->first();
        $sum = InvoiceDetail::where('invoice_id', $data->id)->sum('amount');
        $pdf = PDF::loadView('receipt', compact('data', 'invoice', 'sum'));
        return $pdf->stream();
    }
}
