@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h1>Approval</h1>
            @if(count($withdraws) > 0)
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Withdraw</th>
                        <th scope="col">Request At</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdraws as $index => $withdraw)
                    <tr>
                        <th scope="row">{{$index +1}}</th>
                        <td>{{$withdraw->user->name}}</td>
                        <td>{{$withdraw->user->email}}</td>
                        <td>Rp {{number_format($withdraw->credit)}}</td>
                        <td>{{$withdraw->created_at}}</td>
                        @if($withdraw->status == 0)
                        <td>Pending</td>
                        <td>
                            <a type="button" href="/approve/{{$withdraw->id}}" class="btn btn-success">Approve</a>
                            <a type="button" href="/reject/{{$withdraw->id}}" class="btn btn-danger">Reject</a>
                        </td>
                        @elseif($withdraw->status == 1)
                        <td>Reject</td>
                        <td></td>
                        @elseif($withdraw->status == 2)
                        <td>Success</td>
                        <td></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection