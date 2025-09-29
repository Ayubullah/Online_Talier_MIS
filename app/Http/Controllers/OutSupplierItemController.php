<?php

namespace App\Http\Controllers;

use App\Models\OutSupplierItem;
use App\Models\Supplier;
use Illuminate\Http\Request;

class OutSupplierItemController extends Controller
{
	public function index()
	{
		$items = OutSupplierItem::with(['supplier','invoice'])->latest()->paginate(20);
		return view('out-supplier-items.index', compact('items'));
	}

	public function create()
	{
		$suppliers = Supplier::orderBy('Sup_Name')->get();
		return view('out-supplier-items.create', compact('suppliers'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'sup_id' => 'required|exists:suppliers,Sup_ID',
			'F_Inv_ID' => 'nullable|integer',
			'item_name' => 'required|string|max:255',
			'qty' => 'required|integer|min:1',
			'p_price' => 'required|numeric|min:0',
			's_price' => 'nullable|numeric|min:0',
			'amount' => 'required|numeric|min:0',
			'notes' => 'nullable|string',
		]);

		OutSupplierItem::create($request->only(['sup_id','F_Inv_ID','item_name','qty','p_price','s_price','amount','notes']));
		return redirect()->route('out-supplier-items.index')->with('success','Record created');
	}

	public function show(OutSupplierItem $out_supplier_item)
	{
		$out_supplier_item->load('supplier');
		return view('out-supplier-items.show', ['item' => $out_supplier_item]);
	}

	public function edit(OutSupplierItem $out_supplier_item)
	{
		$suppliers = Supplier::orderBy('Sup_Name')->get();
		return view('out-supplier-items.edit', ['item' => $out_supplier_item, 'suppliers' => $suppliers]);
	}

	public function update(Request $request, OutSupplierItem $out_supplier_item)
	{
		$request->validate([
			'sup_id' => 'required|exists:suppliers,Sup_ID',
			'F_Inv_ID' => 'nullable|integer',
			'item_name' => 'required|string|max:255',
			'qty' => 'required|integer|min:1',
			'p_price' => 'required|numeric|min:0',
			's_price' => 'nullable|numeric|min:0',
			'amount' => 'required|numeric|min:0',
			'notes' => 'nullable|string',
		]);

		$out_supplier_item->update($request->only(['sup_id','F_Inv_ID','item_name','qty','p_price','s_price','amount','notes']));
		return redirect()->route('out-supplier-items.index')->with('success','Record updated');
	}

	public function destroy(OutSupplierItem $out_supplier_item)
	{
		$out_supplier_item->delete();
		return redirect()->route('out-supplier-items.index')->with('success','Record deleted');
	}
}


