@extends('voyager::master')

@section('content')
<div class="container">
    <h1>Orders</h1>
    @if ($orders->isEmpty())
        <p>No orders found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Place</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->time_appointment }}</td>
                        <td>{{ $order->date_appointment }}</td>
                        <td>{{ $order->place_appointment }}</td>
                        <td>{{ $order->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<style>
    .container {
        margin-top: 50px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }
</style>
@endsection
