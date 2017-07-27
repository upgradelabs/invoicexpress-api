<?php

return [

	'api_key'      => env('INVOICEXPRESS_API_KEY'),
	'account_name' => env('INVOICEXPRESS_ACCOUNT_NAME'),
	'app_url'      => 'https://www.app.invoicexpress.com/',
	'my_url'       => 'https://'.env('INVOICEXPRESS_ACCOUNT_NAME').'.app.invoicexpress.com/',
	'username'     => '',
	'password'     => '',

	'endpoints' => [
		'login' => 'login.xml',
		'users' => [
			'authentication' => 'login.xml',
			'accounts'       => 'users/accounts.xml',
			'change_account' => 'users/change_account.xml',
		],
		'invoices' => [
			'create'            => 'invoices.xml',
			'get'               => 'invoices/{invoice-id}.xml',
			'update'            => 'invoices/{invoice-id}.xml',
			'list'              => 'invoices.xml',
			'change_state'      => 'invoice/{receipt-id}/change-state.xml',
			'send_by_email'     => 'invoices/{invoice-id}/email-document.xml',
			'related_documents' => 'document/{invoice-id}/related_documents.xml',
			'generate_pdf'      => 'api/pdf/{invoice-id}.xml',
			'archive'           => '{document-type}/{document-id}/archive.xml',
			'unarchive'         => '{document-type}/{document-id}/unarchive.xml',
			'partial_payment'   => 'documents/{document-id}/partial_payments.xml'
		],
		'invoice_receipts' => [
			'create'            => 'invoice_receipts.xml',
			'get'               => 'invoice_receipts/{invoice-receipt-id}.xml',
			'update'            => 'invoice_receipts/{invoice-receipt-id}.xml',
			'list_all'          => 'invoice_receipts.xml',
			'change_state'      => 'invoice_receipts/{invoice-receipt-id}/change-state.xml',
			'send_by_email'     => 'invoice_receipts/{invoice-receipt-id}/email-document.xml',
			'related_documents' => 'document/{invoice-receipt-id}/related_documents.xml',
			'generate_pdf'      => 'api/pdf/{invoice-receipt-id}.xml'
		],
		'simplified_invoices' => [
			'create'            => 'simplified_invoices.xml',
			'get'               => 'simplified_invoices/{simplified-invoice-id}.xml',
			'update'            => 'simplified_invoices/{simplified-invoice-id}.xml',
			'list_all'          => 'simplified_invoices.xml',
			'change_state'      => 'simplified_invoices/{receipt-id}/change-state.xml',
			'send_by_email'     => 'simplified_invoices/{simplified-invoice-id}/email-document.xml',
			'related_documents' => 'document/{simplified-invoice-id}/related_documents.xml',
			'generate_pdf'      => 'api/pdf/{simplified-invoice-id}.xml'
		],
		'credit_notes' => [
			'create'            => 'credit_notes.xml',
			'get'               => 'credit_notes/{credit-note-id}.xml',
			'update'            => 'credit_notes/{credit-note-id}.xml',
			'list_all'          => 'credit_notes.xml',
			'change_state'      => 'credit_notes/{credit-note-id}/change-state.xml',
			'send_by_email'     => 'credit_notes/{credit-note-id}/email-document.xml',
			'generate_pdf'      => 'api/pdf/{simplified-invoice-id}.xml'
		],
		'debit_notes' => [
			'create'            => 'debit_notes.xml',
			'get'               => 'debit_notes/{debit-note-id}.xml',
			'update'            => 'debit_notes/{debit-note-id}.xml',
			'list_all'          => 'debit_notes.xml',
			'change_state'      => 'debit_notes/{debit-note-id}/change-state.xml',
			'send_by_email'     => 'debit_notes/{debit-note-id}/email-document.xml',
			'generate_pdf'      => 'api/pdf/{debit-note-id}.xml'
		],
		'transport_guides' => [
			'create'            => 'transports.xml',
			'get'               => 'transports/{transport-guide-id}.xml',
			'update'            => 'transports/{transport-guide-id}.xml',
			'list_all'          => 'transports.xml',
			'change_state'      => 'transports/{transport-guide-id}/change-state.xml',
			'send_by_email'     => 'transports/{transport-guide-id}/email-document.xml',
			'generate_pdf'      => 'api/pdf/{transport-guide-id}.xml'
		],
		'shipping_guides' => [
			'create'            => 'shippings.xml',
			'get'               => 'shippings/{shipping-guide-id}.xml',
			'update'            => 'shippings/{shipping-guide-id}.xml',
			'list_all'          => 'shippings.xml',
			'change_state'      => 'shippings/{shipping-guide-id}/change-state.xml',
			'send_by_email'     => 'shippings/{shipping-guide-id}/email-document.xml',
			'generate_pdf'      => 'api/pdf/{shipping-guide-id}.xml'
		],
		'devolution_guides' => [
			'create'            => 'devolutions.xml',
			'get'               => 'devolutions/{devolution-guide-id}.xml',
			'update'            => 'devolutions/{devolution-guide-id}.xml',
			'list_all'          => 'devolutions.xml',
			'change_state'      => 'devolutions/{devolution-guide-id}/change-state.xml',
			'send_by_email'     => 'devolutions/{devolution-guide-id}/email-document.xml',
			'generate_pdf'      => 'api/pdf/{devolution-guide-id}.xml'
		],
		'quotes' => [
			'create'            => 'quotes.xml',
			'get'               => 'quotes/{quote-id}.xml',
			'update'            => 'quotes/{quote-id}.xml',
			'list_all'          => 'quotes.xml',
			'change_state'      => 'quotes/{quote-id}/change-state.xml',
			'send_by_email'     => 'quotes/{quote-id}/email-document.xml',
			'generate_pdf'      => 'api/pdf/{quote-id}.xml'
		],
		'proformas' => [
			'create'            => 'proformas.xml',
			'get'               => 'proformas/{proforma-id}.xml',
			'update'            => 'proformas/{proforma-id}.xml',
			'list_all'          => 'proformas.xml',
			'change_state'      => 'proformas/{proforma-id}/change-state.xml',
			'send_by_email'     => 'proformas/{proforma-id}/email-document.xml',
			'generate_pdf'      => 'api/pdf/{proforma-id}.xml'
		],
		'fees_notes' => [
			'create'            => 'fees_notes.xml',
			'get'               => 'fees_notes/{fees-note-id}.xml',
			'update'            => 'fees_notes/{fees-note-id}.xml',
			'list_all'          => 'fees_notes.xml',
			'change_state'      => 'fees_notes/{fees-note-id}/change-state.xml',
			'send_by_email'     => 'fees_notes/{fees-note-id}/email-document.xml',
			'generate_pdf'      => 'api/pdf/{fees-note-id}.xml'
		],
		'clients' => [
			'create'            => 'clients.xml',
			'get'               => 'clients/{client-id}.xml',
			'update'            => 'clients/{client-id}.xml',
			'list_all'          => 'clients.xml',
			'list_invoice'      => 'clients/{client-id}/invoices.xml',
			'find_by_name'      => 'clients/find-by-name.xml?client_name={first_name+last_name}',
			'find_by_code'      => 'clients/find-by-code.xml?client_code={client_code}',
			'invoice'           => 'clients/{client-id}/create/invoice.xml',
			'credit_note'       => 'clients/{client-id}/create/credit-note.xml',
			'debit_note'        => 'clients/{client-id}/create/debit-note.xml'
		],
		'items' => [
			'create'            => 'items.xml',
			'get'               => 'items/{item-id}.xml',
			'update'            => 'items/{item-id}.xml',
			'delete'            => 'items/{item-id}.xml',
			'list_all'          => 'items.xml'
		],
		'fees_notes' => [
			'create'            => 'purchase_orders.xml',
			'get'               => 'purchase_orders/{purchase-order-id}.xml',
			'update'            => 'purchase_orders/{purchase-order-id}.xml',
			'list_all'          => 'purchase_orders.xml',
			'change_state'      => 'purchase_orders/{purchase-order-id}/change-state.xml',
			'send_by_email'     => 'purchase_orders/{purchase-order-id}/email-document.xml'
		],
		'schedules' => [
			'create'            => 'schedules.xml',
			'get'               => 'schedules/{schedule-id}.xml',
			'update'            => 'schedules/{schedule-id}.xml',
			'list_all'          => 'schedules.xml',
			'activate'          => 'schedules/{schedule-id}/activate',
			'deactivate'        => 'schedules/{schedule-id}/deactivate'
		],
		'taxes' => [
			'create'            => 'taxes.xml',
			'get'               => 'taxes/{tax-id}.xml',
			'update'            => 'taxes/{tax-id}.xml',
			'list_all'          => 'taxes.xml',
			'delete'            => 'taxes/{tax-id}.xml'
		],
		'sequences' => [
			'create'            => 'sequences.xml',
			'get'               => 'sequences/{sequence-id}.xml',
			'update'            => 'sequences/{sequence-id}/set_current.xml',
			'list_all'          => 'sequences.xml'
		],
		'dashboard' => [
			'invoicing'         => 'api/charts/invoicing.xml',
			'treasury'          => 'api/charts/treasury.xml',
			'top_clients'       => 'api/charts/top-clients.xml',
			'top_debtors'       => 'api/charts/top-debtors.xml',
			'quarterly_results' => 'api/charts/quarterly-results.xml'
		]
	]
];