<?php
//Route File Two
// ============================ Inventory Management ============================

// -------------Primary setting ------------------------------------------
Route::resource('small-unit','Inventory\SmallUniteController');
Route::resource('inv-brand','Inventory\InvBrandController');
Route::resource('item-category','ItemCategoryController');

// ----------------------------- Inventory Storage info --------------------------------
Route::resource('storage-info', 'StorageController');
Route::resource('storage-block', 'StorageBlockController');

Route::get('show-all-storage-blocks', 'StorageBlockController@showAllStorageBlocks');
Route::resource('company-terms-conditions','CompanyTermsAndConditionController');

// ----------------------------- Inventory Vendor --------------------------------
Route::resource('inventory-vendor','Inventory\InventoryVendorController');
Route::get('show-all-vendors','Inventory\InventoryVendorController@getAllVendors');

// ----------------------------- Inventory Customer --------------------------------
Route::resource('inventory-customer','Inventory\InventoryCustomerController');
Route::get('show-all-customers','Inventory\InventoryCustomerController@showAllInventoryCustomers');

// ----------------------------- Inventory item --------------------------------
Route::resource('inventory-item','Inventory\InventoryItemController');
Route::get('show-all-inventory-items','Inventory\InventoryItemController@showAllInventoryItems');

// ----------------------------- Inventory Purchase Order --------------------------------
Route::resource('inventory-purchase-order','Inventory\InventoryPurchaseOrderController');
Route::get('search-inventory-item','Inventory\InventoryPurchaseOrderController@inventoryItemSearch');
Route::get('show-all-purchase-orders','Inventory\InventoryPurchaseOrderController@inventoryPuraseOrdersList');
Route::get('purchase-order-pdf-print/{id}','Inventory\InventoryPurchaseOrderController@inventoryPuraseOrdersPdfPrint');

// ==== 18-08-2018 ====
// ----------------------------- Inventory Item Receiving --------------------------------
Route::resource('inventory-item-receiving','Inventory\InvtItemReceivingController');
Route::get('load-self-of-storage-block/{storageBlockId}/{purchaseOrderItemId}','Inventory\InvtItemReceivingController@loadSelfOfStorageBlock');
Route::get('show-all-received-items','Inventory\InvtItemReceivingController@showAllReceivedItems');
Route::get('item-receiving-print-pdf/{masterId}','Inventory\InvtItemReceivingController@itemReceivingPrintPdf');


?>

