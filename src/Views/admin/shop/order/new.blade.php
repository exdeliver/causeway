@extends('causeway::admin.layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.order.index') }}">Orders</a></li>
    <li class="breadcrumb-item">New</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Create new order</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')

            {{ Form::open() }}

            @include('causeway::admin.common._select', [
            'title' => 'Customer',
            'name' => 'customer_id',
            'value' => null,
            'data' => \Exdeliver\Causeway\Domain\Entities\Shop\Customers\Customer::join('contacts', 'contacts.customer_id', 'customers.id')
            ->orderBy('contacts.last_name')->get()->mapWithKeys(function($customer, $key) {
                $contact = $customer->primaryContact();
                if(isset($contact)) {
                $company = $contact !== null && $contact->company !== null ? ' '.$contact->company : '';
                return [$key => '#'.$customer->id .' '. $contact->full_name . $company];
                }
                return [];
            }),
            'options' => ['class' => 'form-control'],
            'description' => 'Select the customer which you want to invoice, or create a new customer.',
            ])


            <order-item-component :products="{}"></order-item-component>

            {{ Form::submit('Save', ['class' => 'btn btn-primary pull-right']) }}

            {{ Form::close() }}
        </div>
    </div>
@endsection
